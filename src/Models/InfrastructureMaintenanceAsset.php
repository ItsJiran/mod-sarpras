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

use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Module\Infrastructure\Models\InfrastructureMaintenance;

class InfrastructureMaintenanceAsset extends Model
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
    protected $table = 'infrastructure_maintenance_assets';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-maintenance-asset'];

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
        'maintenance_id',
        'unit_id',
        'asset_id',
    ];

    /**
     * The default key for the order.
     *
     * @var string
     */
    protected $defaultOrder = 'name';

    /**
     * ====================================================
     * +-------------- MAP RELATIONSHIP ------------------+
     * ====================================================
     */

     public static function mapStoreRequestValidation(Request $request) : array
     {
        if( is_array($request->unit) )
            $request->unit = (object) $request->unit;

        if( is_array($request->asset) )
            $request->asset = (object) $request->asset;

        return [
            'unit' => 'required|array',
            'unit.id' => 'required|numeric|exists:human_units,id',
            
            'asset' => 'required|array',
            'asset.id' => 'required|numeric|exists:infrastructure_assets,id',
        ];
     }
 
    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public function getNewId() 
    {   
        $latest = self::latest()->pluck('id')->first();
        if ( is_null( $latest ) ) return 1;
        else                      return $latest->id + 1;        
    }

   /**
     * ================================================
     * +------------------ MAP CRUD ------------------+
     * ================================================
     */

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request, InfrastructureMaintenance $main_model) : InfrastructureMaintenanceAsset
    {
        $model = new static();
        
        $model->maintenance_id = $main_model->id;
        $model->unit_id = $request->unit->id;
        $model->asset_id = $request->asset->id;
        $model->save();

        return $model;
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

            // return new MaintenanceAssetResource($model);
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
