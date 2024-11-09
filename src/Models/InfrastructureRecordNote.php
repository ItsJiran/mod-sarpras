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

use Module\Infrastructure\Models\InfrastructureRecord;

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

    /**
     * Get the model that the image belongs to.
     */
    public function record(): BelongsTo
    {
        return $this->belongsTo(InfrastructureRecord::class, 'record_id');
    } 

    /**
     * Get the model that the image belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(InfrastructureUser::class, 'user_id');
    } 

    /**
     * Get the model that the image belongs to.
     */
    public function uses(): HasMany 
    {
        return $this->hasMany(InfrastructureTaxRecordUsed::class, 'asset_id');
    }

    // +===============================================
    // +--------------- RESROUCE METHODS
    // +===============================================

    public static function mapResourceShow(Request $request, $model = null): array
    {
        $user = $model->user::class::mapResourceShow($request,$model->user);
        return [
            'id' => $model->id,
            'name' => $model->name, 
            'paydate' => $model->paydate,
            'payprice' => $model->payprice,
            'description' => $model->description,
            'proof_img_path' => $model->proof_img_path,

            'user' => $user,
            'status' => $model->status,
            'status_step' => self::mapStatusStep($request, $model),
            
            'is_admin' => $request->user()->id == 1,
            'is_creator' => $request->user()->id == $user['id'],
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

    // +------------------------------
    // +------------ STORE REQUEST

    public static function mapStoreRequest(Request $request, InfrastructureTax $tax)
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
            // 'proof_img' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ];

        return $array;
    }

    public static function mapStoreRequestValid(Request $request, InfrastructureTax $tax) : JsonResponse | null
    {
        if ( is_null($request->user()) ) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data karena user tidak ada..'
            ], 500);
        }

        if ( $tax->isTypeLog() ) 
            return self::mapStoreRequestLog($request, $tax);

        if ( $tax->isTypePeriodic() ) 
            return self::mapStoreRequestPeriodic($request, $tax);               
    }

    public static function mapStoreRequestLog(Request $request, InfrastructureTax $tax) : JsonResponse | null
    {
        return null;
    }

    public static function mapStoreRequestPeriodic(Request $request, InfrastructureTax $tax) : JsonResponse | null
    {
        if ( self::isOngoing($request, $tax) ) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data karena ada pajak yang masih berjalan..'
            ], 500);
        }

        return null;
    }

    public static function isOngoing( Request $request, InfrastructureRecord $record ) : bool
    {
        $wherePending = [
            ['record_id','=',$tax->id],
            ['status','=','pending'],
        ];

        $whereDraft = [
            ['record_id','=',$tax->id],
            ['status','=','draft'],
        ];

        $onGoingRecord = self::where($wherePending)
        ->orWhere($whereDraft)
        ->first();

        return !is_null($onGoingRecord);
    }

    // +------------------------------
    // +------------ UPDATE REQUEST

    public static function mapUpdateRequest(Request $request, InfrastructureRecord $record)
    {
        $array = [
            'name' => 'required',
            'description' => 'required',
            'paydate' => 'required',
            'payprice' => 'required|numeric',
            // 'proof_img' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ];

        return $array;
    }

    public static function mapUpdateToCancelled(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        // kalau bukan draft dan bukan admin
        if ( $model->status_step == '3' ) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah selesai!'
            ], 500);
        }

        return null;
    }

    public static function mapUpdateToVerified(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        // kalau bukan draft dan bukan admin
        if ( $model->status_step == '3' ) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah selesai!'
            ], 500);
        }

        return null;
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

        return null;
    }

    public static function mapUpdateToDraft(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        // kalau bukan draft dan bukan admin
        if ( $model->status != 'pending' && $request->user()->id != 1 ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berwenang!'
            ], 500);
        }

        return null;
    }

    public static function mapUpdateToPending(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        // kalau bukan draft dan bukan admin
        if ( $model->status != 'draft' && $request->user()->id != 1 ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berwenang!'
            ], 500);
        }

        return null;
    }

    public static function mapUpdateRequestValid(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        if ( is_null($request->user()) ) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data karena user tidak ada..'
            ], 500);
        }

        // kalau misalnya bukan user yang membuat dan bukan admin        
        if ( $model->user_id != $request->user()->id && $request->user()->id != 1 ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berwenang!'
            ], 500);
        }

        // kalau bukan draft dan bukan admin
        if ( $model->status != 'draft' && $request->user()->id != 1 ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berwenang!'
            ], 500);
        }

        if ( $record->isTypeLog() )
            return self::mapUpdateRequestLog($request, $record, $model);

        if ( $record->isTypePeriodic() )
            return self::mapUpdateRequestPeriodic($request, $record, $model); 
    }

    public static function mapUpdateRequestLog(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        return null;
    }

    public static function mapUpdateRequestPeriodic(Request $request, InfrastructureRecord $record, $model) : JsonResponse | null
    {
        return null;
    }

    // +===============================================
    // +--------------- STATUS METHODS
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

    public static function toPending(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        return self::changeStatuses($request, $recrod, $note, function( Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note ){
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
            
            if ( $record->isTypePeriodic() ) {
                $now = Carbon::now();
                $now->addDays($record->typeable->period_number_day);
                $now->addMonths($record->typeable->period_number_month);
                $now->addYear($record->typeable->period_number_year);

                $record->typeable->duedate = $now;
                $record->typeable->save();
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

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request, InfrastructureRecord $record)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        try {            
            if ( $record->isTypeLog() ) {
                self::storeAsLog($request, $record, $model);
            }
            if ( $record->isTypePeriodic() ) {
                self::storeAsPeriodic($request, $record, $model);        
            }

            $model->save();

            DB::connection($model->connection)->commit();

            // return new RecordNoteResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function storeAsLog(Request $request, InfrastructureRecord $record, $model) 
    {
        $model->record_id = $record->id;
        $model->user_id = $request->user()->id;

        $model->name = $request->name;
        $model->paydate = $request->paydate;
        $model->payprice = $request->payprice;
        $model->description = $request->description;
        $model->proof_img_path = 'temporary';

        // default
        $model->status = $request->status;
    }

    public static function storeAsPeriodic(Request $request, InfrastructureRecord $record, $model) 
    {
        $model->record_id = $record->id;
        $model->user_id = $request->user()->id;        

        $model->name = $request->name;
        $model->paydate = $request->paydate;
        $model->payprice = $request->payprice;
        $model->description = $request->description;
        $model->proof_img_path = 'temporary';

        // default
        $model->status = $request->status;
    }

    // +===============================================
    // +--------------- UPDATE METHODS
    // +===============================================

    public static function updateRecord(Request $request, InfrastructureRecord $record, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            
            if ( $record->isTypeLog() ) {
                self::updateAsLog($request, $record, $model);
            }

            if ( $record->isTypePeriodic() ) {
                self::updateAsPeriodic($request, $record, $model);        
            }

            $model->save();

            DB::connection($model->connection)->commit();

            // return new TaxRecordResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function updateAsLog(Request $request, InfrastructureRecord $record, $model) 
    {
        $model->record_id = $record->id;

        $model->name = $request->name;
        $model->paydate = $request->paydate;
        $model->payprice = $request->payprice;
        $model->description = $request->description;
        $model->proof_img_path = 'temporary';

        // default
        $model->status = $request->status;
    }

    public static function updateAsPeriodic(Request $request, InfrastructureRecord $record, $model) 
    {
        $model->record_id = $record->id;

        $model->name = $request->name;
        $model->paydate = $request->paydate;
        $model->payprice = $request->payprice;
        $model->description = $request->description;
        $model->proof_img_path = 'temporary';

        // default
        $model->status = $request->status;
    }

    // +===============================================
    // +--------------- DELETE METHODS
    // +===============================================


    /**
     * The model delete method
     *
     * @param [type] $model
     * @return void
     */
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

    /**
     * The model restore method
     *
     * @param [type] $model
     * @return void
     */
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

    /**
     * The model destroy method
     *
     * @param [type] $model
     * @return void
     */
    public static function destroyRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
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