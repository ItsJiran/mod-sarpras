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

use Module\Infrastructure\Models\InfrastructureTax;
use Module\Infrastructure\Models\InfrastructureUnit;

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
        return $this->belongsTo(InfrastructureTax::class, 'user_id');
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
            'paydate' => 'required|numeric',            
            'status' => [
                'required',
                Rule::in( self::mapStatus($request) ),
            ],
            'payprice' => 'required|numeric',
            'proof_img' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ];

        dd($request->user());

        return $array;
    }

    public static function mapStoreRequestValid(Request $request, InfrastructureTax $tax) : Response | null
    {
        if ( $tax->isTypeLog() ) 
            return self::mapStoreRequestLog($request, $tax);

        if ( $tax->isTypePeriodic() ) 
            return self::mapStoreRequestPeriodic($request, $tax);               
    }

    public static function mapStoreRequestLog(Request $request, InfrastructureTax $tax) : Response | null
    {
        if ( is_null($request->user) ) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data karena user tidak ada..'
            ], 500);
        }

        if ( $request->status ) {

        }

    }

    public static function mapStoreRequestPeriodic(Request $request, InfrastructureTax $tax) : Response | null
    {

    }

    // +============= UPDATE

    public static function mapUpdateRequest(Request $request, InfrastructureTax $tax)
    {
        $array = [
            'name' => 'required',
            'description' => 'required',
            'paydate' => 'required|numeric',
            'payprice' => 'required|numeric',
            'proof_img' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ];

        return $array;
    }

    public static function mapUpdateRequestLog(Request $request) 
    {
        // REQUEST UNTUK LOG 
    }

    public static function mapUpdateRequestPeriodic(Request $request) 
    {
        // REQUEST UNTUK PERIODIK 
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
        self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    public static function toCancelled(Request $request, InfrastructureTaxRecord $model)
    {
        self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    public static function toDraft(Request $request, InfrastructureTaxRecord $record)
    {
        self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    public static function toVerified(Request $request, InfrastructureTaxRecord $record)
    {
        self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
        });
    }

    public static function toUnverified(Request $request, InfrastructureTaxRecord $record)
    {
        self::changeStatuses($request, $model, function( Request $request, InfrastructureTaxRecord $model ){
            
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
                $this->storeAsLog($request, $tax, $model);
            }

            if ( $tax->isTypePeriodic() ) {
                $this->storeAsPeriodic($request, $tax, $model);        
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
        $model->user_id = $request->user->id;

        $model->name = $request->name;
        $model->paydate = $request->paydate;
        $model->payprice = $request->payprice;
        $model->description = $request->description;
        $model->proof_img_path = $request->proof_img_path;

        // default
        $model->status = 'pending';
    }

    public static function storeAsPeriodic(Request $request, InfrastructureTax $tax, $model) 
    {
        $model->tax_id = $tax->id;
        $model->user_id = $request->user->id;        

        $model->name = $request->name;
        $model->paydate = $request->paydate;
        $model->payprice = $request->payprice;
        $model->description = $request->description;
        $model->proof_img_path = $request->proof_img_path;

        // default
        $model->status = 'pending';
    }

    // +===============================================
    // +--------------- UPDATE METHODS
    // +===============================================

    public static function updateRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            
            if ( $tax->isTypeLog() ) {
                $this->updateAsLog($request, $model);
            }

            if ( $tax->isTypePeriodic() ) {
                $this->updateAsPeriodic($request, $model);        
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
        $model->name = $request->name;
        $model->description = $request->description;
        $model->paydate = $request->paydate;
    }

    public static function updateAsPeriodic(Request $request, InfrastructureTax $tax, $model) 
    {
        $model->name = $request->name;
        $model->description = $request->description;
        $model->paydate = $request->paydate;
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
