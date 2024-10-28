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

use Module\Infrastructure\Models\InfrastructureTax;
use Module\Infrastructure\Models\InfrastructureUnit;

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

    public static function mapStoreRequest(Request $request, InfrastructureTax $tax)
    {
        $array = [

        ];

        return $array;
    }

    public static function mapStoreRequestLog(Request $request) 
    {
        // REQUEST UNTUK LOG 
    }

    public static function mapStoreRequestPeriodic(Request $request) 
    {
        // REQUEST UNTUK PERIODIK 
    }

    public static function mapUpdateRequest(Request $request, InfrastructureTax $tax)
    {
        $array = [

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

    public static function toPending(Request $request, InfrastructureTaxRecord $record)
    {

    }

    public static function toCancelled(Request $request, InfrastructureTaxRecord $record)
    {

    }

    public static function toDraft(Request $request, InfrastructureTaxRecord $record)
    {

    }

    public static function toVerified(Request $request, InfrastructureTaxRecord $record)
    {

    }

    public static function toUnverified(Request $request, InfrastructureTaxRecord $record)
    {

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
        $model->description = $request->description;
        $model->paydate = $request->paydate;
        $model->proof_img_path = $request->proof_img_path;
    }

    public static function storeAsPeriodic(Request $request, InfrastructureTax $tax, $model) 
    {
        $model->tax_id = $tax->id;
        $model->user_id = $request->user->id;        

        $model->name = $request->name;
        $model->description = $request->description;
        $model->paydate = $request->paydate;
        $model->proof_img_path = $request->proof_img_path;
    }

    // +===============================================
    // +--------------- UPDATE METHODS
    // +===============================================

    public static function updateRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            
            if ( $tax->isTypeLog() ) {
                // $this->storeAsLog($request, $model);
            }

            if ( $tax->isTypePeriodic() ) {
                // $this->storeAsPeriodic($request, $model);        
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
