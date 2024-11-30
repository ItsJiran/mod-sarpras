<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Module\System\Traits\HasMeta;
use Illuminate\Support\Facades\DB;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Config;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureUser;

use Module\Infrastructure\Http\Resources\RecordNoteResource;

class InfrastructureRecordNote extends Model
{
    use Filterable;
    use HasMeta;
    use HasPageSetup;
    use Searchable;
    use SoftDeletes;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'platform';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'infrastructure_record_notes';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-record-note'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'record_id',
        'user_id',
        'payprice',
        'paydate',
        'description',
        'proof_img_path',
        'status',
    ];

    /**
     * The default key for the order.
     *
     * @var string
     */
    protected $defaultOrder = 'name';

    // +===============================================
    // +--------------- RELATION METHODS
    // +===============================================

    public function record(): BelongsTo
    {
        return $this->belongsTo(InfrastructureRecord::class, 'record_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(InfrastructureUser::class, 'user_id');
    }

    public function uses(): HasMany 
    {
        return $this->hasMany(InfrastructureRecordNoteUsed::class, 'note_id');
    }

    // +===============================================
    // +--------------- RESROUCE METHODS
    // +===============================================

    public static function mapResourceShow(Request $request, $model = null): array
    {
        $user = InfrastructureUser::mapResourceShow($request,$model->user);

        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');
        $isUserCreator = $request->user()->id == $user['id'];

        return [
            'id' => $model->id,
            'name' => $model->name, 
            'paydate' => $model->paydate,
            'payprice' => $model->payprice,
            'description' => $model->description,
            'proof_img_path' => 'https://' . $request->host() . '/infrastructure/api/ref-image/' . $model->proof_img_path,

            'user' => $user,
            'status' => $model->status,
            'status_step' => self::mapStatusStep($request, $model),
            
            'is_admin' => $isUserAdmin || $isUserSuperAdmin,
            'is_creator' => $isUserCreator,
        ];
    }

    public static function mapStatusStep(Request $request, $model) : String
    {
        if ( $model->status == 'draft' ) 
            return '1';

        if ( $model->status == 'pending' ) 
            return '2';

        return '3';
    }

    // +===============================================
    // +--------------- RELATION METHODS
    // +===============================================

    public static function mapCombos(Request $request, $model = null): array
    {
        return [
            'statuses' => [
                'regular' => self::mapStatus($request),
                'store' => self::mapStoreStatus($request),
                'update' => self::mapUpdateStatus($request),
            ]
        ];
    }

    public static function mapStatus(Request $request)
    {
        return [
            'pending',
            'draft',
            'cancelled',
            'unverified',
            'verified',
        ];
    }

    public static function mapStoreStatus(Request $request)
    {
        return [
            'pending',
            'draft',
        ];
    }

    public static function mapUpdateStatus(Request $request)
    {
        return [
            'pending',
            'draft',
        ];
    }


    // +===============================================
    // +--------------- ONGOING METHOD
    // +===============================================

    public static function isOngoing( Request $request, InfrastructureRecord $record ) : bool
    {
        $wherePending = [
            ['record_id','=',$record->id],
            ['status','=','pending'],
        ];

        $whereDraft = [
            ['record_id','=',$record->id],
            ['status','=','draft'],
        ];

        $wherePendingRecord = self::where($wherePending)
        ->first();

        $whereDraftRecord = self::where($whereDraft)
        ->first();

        return !is_null($wherePendingRecord) || !is_null($whereDraftRecord);
    }

    // +===============================================
    // +--------------- MAP STORE REQUEST
    // +===============================================

    public static function mapStoreRequest(Request $request, InfrastructureRecord $record)
    {
        $array = [
            'name' => 'required',
            'description' => 'required',
            'paydate' => 'required',            
            'status' => [
                'required',
                Rule::in( self::mapStatus($request) ),
            ],
            'payprice' => 'required|numeric',
            'proof_img' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ];

        return $array;
    }

    // +===============================================
    // +----------- MAP STORE REQUEST VALID
    // +===============================================

    public static function mapStoreRequestValid(Request $request, InfrastructureRecord $record) : JsonResponse | null
    {
        if ( $record->isRecordLog() ) 
            $custom = self::mapStoreRequestLog($request, $record);

        if ( $record->isRecordPeriodic() ) 
            $custom = self::mapStoreRequestPeriodic($request, $record);               

        return ensureRequests([
            ensureRequestUserOperator($request),
            $custom
        ]);
    }

    public static function mapStoreRequestLog(Request $request, InfrastructureRecord $record) : JsonResponse | null
    {
        return null;
    }

    public static function mapStoreRequestPeriodic(Request $request, InfrastructureRecord $record) : JsonResponse | null
    {
        if ( self::isOngoing($request, $record) ) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data karena ada pajak yang masih berjalan..'
            ], 500);
        }

        return null;
    }

    // +===============================================
    // +-------- MAP UPDATE REQUEST VERIFICATION
    // +===============================================

    public static function mapUpdateToCancelled(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        if ( $model->status_step == '3' ) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah selesai!'
            ], 500);
        }

        return ensureRequests([
            ( ensureRequestModelStatusPending($request, $model) || ensureRequestModelStatusDraft($request, $model) ),
            ensureRequestUserOwnerModel($request, $model),
            ensureRequestUserOperator($request),
        ]);
    }

    public static function mapUpdateToVerified(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        if ( $model->status_step == '3' ) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah selesai!'
            ], 500);
        }

        return ensureRequests([
            ensureRequestModelStatusPending($request, $model),
            ensureRequestUserVerificator($request),
        ]);
    }

    public static function mapUpdateToUnVerified(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        // kalau bukan draft dan bukan admin
        if ( $model->status_step == '3' ) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah selesai!'
            ], 500);
        }


        return ensureRequests([
            ensureRequestModelStatusPending($request, $model),
            ensureRequestUserVerificator($request),
        ]);
    }

    public static function mapUpdateToDraft(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        return ensureRequests([
            ensureRequestUserOwnerModel($request, $model),
            ensureRequestModelStatusPending($request, $model),
            ensureRequestUserOperator($request),
        ]);
    }

    public static function mapUpdateToPending(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        return ensureRequests([
            ensureRequestUserOwnerModel($request, $model),
            ensureRequestModelStatusDraft($request, $model),
            ensureRequestUserOperator($request),
        ]);
    }

    // +===============================================
    // +------------- MAP UPDATE REQUEST
    // +===============================================

    public static function mapUpdateRequest(Request $request, InfrastructureRecord $record)
    {
        $array = [
            'name' => 'required',
            'description' => 'required',
            'paydate' => 'required',
            'payprice' => 'required|numeric',
            'proof_img' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ];

        return $array;
    }

    /**
     * =====================================================
     * +---------------------- MAP BASE -------------------+
     * =====================================================
     */

    public static function mapResource(Request $request, $model) 
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'status' => $model->status,
            'creator' => InfrastructureUser::where('id',$model->user_id)->first()->name,
            'payment_date' => $model->paydate,
            'payment_amount' => number_format( ($model->payprice), 3 ),
        ];
    }

    public static function mapHeaders(Request $request): array 
    {
        return [
            ['title' => 'Nama', 'value' => 'name', 'sortable' => true],
            ['title' => 'Status', 'value' => 'status', 'sortable' => true],
            ['title' => 'Pembuat', 'value' => 'creator', 'sortable' => true],
            ['title' => 'Tanggal Pembayaran', 'value' => 'payment_date', 'sortable' => true],
            ['title' => 'Jumlah Pembayaran', 'value' => 'payment_amount', 'sortable' => true],
        ];
    }

    // +===============================================
    // +---------- MAP UPDATE REQUEST VALID
    // +===============================================

    public static function mapUpdateRequestValid(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        return ensureRequests([
            ensureRequestModelStatusDraft($request, $model),
            ensureRequestUserOwnerModel($request, $model),
            ensureRequestUserOperator($request),
        ]);
    }


    // +===============================================
    // +---------- MAP DELETE REQUEST VALID
    // +===============================================

    public static function mapDeleteRequestValid(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        if ( ( $model->status != 'pending' && $model->status != 'draft' ) ) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menghapus pembayaran yang sudah selesai'
            ], 500);
        }

        return ensureRequests([
            ensureRequestModelStatusDraft($request, $model),
            ensureRequestUserOwnerModel($request, $model),
            ensureRequestUserOperator($request),
        ]);
    }

    // +===============================================
    // +---------- MAP RESTORE REQUEST VALID
    // +===============================================

    public static function mapRestoreRequestValid(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        if ( self::isOngoing($request, $record) && $record->isRecordPeriodic() ) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengembalikan data karena ada pajak yang masih berjalan..'
            ], 500);
        }

        $ensureRequestUserOperator = ensureRequestUserOperator($request);
        if(!is_null($ensureRequestUserOperator)) return $ensureRequestUserOperator;

        return null;
    }

    // +===============================================
    // +----------- CHANGE STATUS METHODS
    // +===============================================

    public static function changeStatuses(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note, $callback) {
        DB::connection($note->connection)->beginTransaction();
        try {
            $callback($request, $record, $note);            

            DB::connection($note->connection)->commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah status..',
                'record' => self::mapResourceShow($request, $note),                
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // +===============================================
    // +--------------- STATUS METHODS
    // +===============================================

    public static function toPending(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        return self::changeStatuses($request, $record, $note, function( Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note ){
            if($note->status != 'pending' && $note->status != 'draft') {
                throw new \Exception('Data sudah selesai');         
            }
            
            $note->status = 'pending';
            $note->save();
        });
    }

    public static function toCancelled(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        return self::changeStatuses($request, $record, $note, function( Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note ){            
            if($note->status != 'pending' && $note->status != 'draft')
                throw new \Exception('Data sudah selesai');         

            if($note->status == 'cancelled')
                throw new \Exception('Data sudah tercancel');         

            $note->status = 'cancelled';
            $note->save();
        });
    }

    public static function toDraft(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        return self::changeStatuses($request, $record, $note, function( Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note ){
            if($note->status != 'pending' && $note->status != 'draft')
                throw new \Exception('Data sudah selesai');
            
            $note->status = 'draft';
            $note->save();
        });
    }

    public static function toVerified(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        return self::changeStatuses($request, $record, $note, function( Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note ){
            if($note->status != 'pending')
                throw new \Exception('Data tidak sedang pending');
            
            if ( $record->isRecordPeriodic() ) {
                $duedate = Carbon::parse($note->duedate);

                $duedate->addDays($record->recordable->period_number_day);
                $duedate->addMonths($record->recordable->period_number_month);
                $duedate->addYear($record->recordable->period_number_year);

                $record->recordable->duedate = $duedate;
                $record->recordable->save();
                $record->save();
            }

            $note->status = 'verified';
            $note->save();
        });
    }

    public static function toUnverified(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        return self::changeStatuses($request, $record, $note, function( Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note ){
            if($note->status != 'pending')
                throw new \Exception('Data tidak sedang pending');

            $note->status = 'unverified';
            $note->save();
        });
    }

    // +===============================================
    // +--------------- RELATION METHODS
    // +===============================================

    public static function storeRecord(Request $request, InfrastructureRecord $record)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        try {            

            File::ensureDirectoryExists(storage_path('app/infrastructure/deadline'));

            $model->record_id = $record->id;
            $model->user_id = $request->user()->id;        

            $model->name = $request->name;
            $model->paydate = $request->paydate;
            $model->payprice = $request->payprice;
            $model->description = $request->description;

            $model->proof_img_path = Storage::disk('infrastructure')->put('deadline', $request->proof_img);

            // default
            $model->status = $request->status;        

            $model->save();

            DB::connection($model->connection)->commit();

            return new RecordNoteResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // +===============================================
    // +--------------- UPDATE METHODS
    // +===============================================

    public static function updateRecord(Request $request, InfrastructureRecord $record, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            
            File::ensureDirectoryExists(storage_path('app/infrastructure/deadline'));

            $model->record_id = $record->id;

            $model->name = $request->name;
            $model->paydate = $request->paydate;
            $model->payprice = $request->payprice;
            $model->description = $request->description;

            if( !is_null( $request->proof_img ) ) {
                Storage::disk('infrastructure')->delete($model->proof_img_path);
                $model->proof_img_path = Storage::disk('infrastructure')->put('deadline', $request->proof_img);
            }

            $model->status = $request->status;     
            $model->save();

            DB::connection($model->connection)->commit();

            return new RecordNoteResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // +===============================================
    // +--------------- DELETE METHODS
    // +===============================================

    public static function deleteRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->delete();

            DB::connection($model->connection)->commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function restoreRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->restore();

            DB::connection($model->connection)->commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function destroyRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            // delete all the used asset 
            $note_uses = InfrastructureRecordNoteUsed::where([
                ['note_id','=',$model->id],
            ])->get();

            foreach ($note_uses as $key => $value) {
                $value->forceDelete();
            }

            Storage::disk('infrastructure')->delete('deadline/'.$model->proof_img_path);

            $model->forceDelete();

            DB::connection($model->connection)->commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
