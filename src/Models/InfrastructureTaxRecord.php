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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Module\Infrastructure\Models\InfrastructureTax;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureUser;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class InfrastructureTaxRecord extends Model
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
    protected $table = 'infrastructure_tax_records';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-tax-record'];

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
        'tax_id',
        'user_id',
        'name',
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
    public function tax(): BelongsTo
    {
        return $this->belongsTo(InfrastructureTax::class, 'tax_id');
    } 

        /**
     * Get the model that the image belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(InfrastructureUser::class, 'user_id');
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

    public static function mapStatusStep(Request $request, $model) 
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

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return void
     */
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

    public static function mapStoreRequestValid(Request $request, InfrastructureTax $tax) : JsonJson
    {
        if ( is_null($request->user) ) {
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

    public static function isOngoing( Request $request, InfrastructureTax $tax ) : boolean
    {
        $wherePending = [
            ['tax_id','=',$tax->id],
            ['status','=','pending'],
        ];

        $whereDraft = [
            ['tax_id','=',$tax->id],
            ['status','=','draft'],
        ];

        $onGoingRecord = self::where($wherePending)
        ->orWhere($whereDraft)
        ->first();

        return !is_null($onGoingRecord);
    }

    // +============= UPDATE

    public static function mapUpdateRequest(Request $request, InfrastructureTax $tax)
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

    public static function mapUpdateToDraft(Request $request, InfrastructureTax $tax, $model) : JsonResponse | null
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

    public static function mapUpdateToPending(Request $request, InfrastructureTax $tax, $model) : JsonResponse | null
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

    public static function mapUpdateRequestValid(Request $request, InfrastructureTax $tax, $model) : JsonResponse | null
    {
        if ( is_null($request->user) ) {
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

        if ( $tax->isTypeLog() )
            return self::mapUpdateRequestLog($request, $tax, $model);

        if ( $tax->isTypePeriodic() )
            return self::mapUpdateRequestPeriodic($request, $tax, $model); 
    }

    public static function mapUpdateRequestLog(Request $request, InfrastructureTax $tax, $model) : JsonResponse | null
    {
        return null;
    }

    public static function mapUpdateRequestPeriodic(Request $request, InfrastructureTax $tax, $model) : JsonResponse | null
    {
        return null;
    }

    // +===============================================
    // +--------------- STATUS METHODS
    // +===============================================

    public static function changeStatuses(Request $request, InfrastructureTaxRecord $model, $callback) {
        DB::connection($model->connection)->beginTransaction();
        try {
            $callback($request, $model);

            DB::connection($model->connection)->commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah status..'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status..'
            ], 500);
        }
    }

    public static function toPending(Request $request, InfrastructureTaxRecord $model)
    {
        return self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    public static function toCancelled(Request $request, InfrastructureTaxRecord $model)
    {
        return self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    public static function toDraft(Request $request, InfrastructureTaxRecord $record)
    {
        return self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    public static function toVerified(Request $request, InfrastructureTaxRecord $record)
    {
        return self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    public static function toUnverified(Request $request, InfrastructureTaxRecord $record)
    {
        return self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    // +===============================================
    // +--------------- STORE METHODS
    // +===============================================

    public static function storeRecord(Request $request, InfrastructureTax $tax) 
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        try {

            if ( $tax->isTypeLog() ) {
                self::storeAsLog($request, $tax, $model);
            }

            if ( $tax->isTypePeriodic() ) {
                self::storeAsPeriodic($request, $tax, $model);        
            }

            $model->save();

            DB::connection($model->connection)->commit();
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function storeAsLog(Request $request, InfrastructureTax $tax, $model) 
    {
        $model->tax_id = $tax->id;
        $model->user_id = $request->user()->id;

        $model->name = $request->name;
        $model->paydate = $request->paydate;
        $model->payprice = $request->payprice;
        $model->description = $request->description;
        $model->proof_img_path = 'temporary';

        // default
        $model->status = $request->status;
    }

    public static function storeAsPeriodic(Request $request, InfrastructureTax $tax, $model) 
    {
        $model->tax_id = $tax->id;
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

    public static function updateRecord(Request $request, InfrastructureTax $tax, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            
            if ( $tax->isTypeLog() ) {
                self::updateAsLog($request, $tax, $model);
            }

            if ( $tax->isTypePeriodic() ) {
                self::updateAsPeriodic($request, $tax, $model);        
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

    public static function updateAsLog(Request $request, InfrastructureTax $tax, $model) 
    {
        $model->tax_id = $tax->id;      

        $model->name = $request->name;
        $model->paydate = $request->paydate;
        $model->payprice = $request->payprice;
        $model->description = $request->description;
        $model->proof_img_path = 'temporary';

        // default
        $model->status = $request->status;
    }

    public static function updateAsPeriodic(Request $request, InfrastructureTax $tax, $model) 
    {
        $model->tax_id = $tax->id;      

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
