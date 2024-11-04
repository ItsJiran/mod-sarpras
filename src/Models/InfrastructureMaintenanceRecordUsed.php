<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Module\System\Traits\HasMeta;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;

use Module\Infrastructure\Models\InfrastructureTax;
use Module\Infrastructure\Models\InfrastructureTaxRecord;
use Module\Infrastructure\Models\InfrastructureTaxRecordUsed;

class InfrastructureMaintenanceRecordUsed extends Model
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
    protected $table = 'infrastructure_maintenance_record_useds';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-maintenance-record-used'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * The default key for the order.
     *
     * @var string
     */
    protected $defaultOrder = 'name';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'maintenance_record_id',
        'unit_id',
        'target_id',
        'type',
        'is_freeze',
    ];

    /**
     * ====================================================
     * +---------------- RELATION METHODS ----------------+
     * ====================================================
     */

    /**
     * Get the model that the image belongs to.
     */
    public function record(): BelongsTo
    {
        return $this->belongsTo(InfrastructureTaxRecord::class, 'tax_record_id');
    } 

    /**
     * ====================================================
     * +---------------- MAP RESOURCE METHODS ------------+
     * ====================================================
     */

    public static function mapResourceShow(Request $request, $model = null): array
    {
        return [];
    }

    // +===============================================
    // +--------------- MAP OBJECT
    // +===============================================

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapCombos(Request $request, $model = null) : array 
    {
        return [            
            'types' => self::mapTypes(),
        ];
    }   

    // map request
    public static function mapStoreRequest(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
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

    // +===============================================
    // +--------------- MAP OBJECT
    // +===============================================

    public static function mapTypes(Request $request) : array
    {
        return [
            'asset',
            'document',
        ];
    }

    /**
     * ====================================================
     * +---------------- STATUSES METHODS ----------------+
     * ====================================================
     */

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        try {
            // ...
            $model->save();

            DB::connection($model->connection)->commit();

            // return new MaintenanceRecordUsedResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model update method
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function updateRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            // ...
            $model->save();

            DB::connection($model->connection)->commit();

            // return new MaintenanceRecordUsedResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

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
