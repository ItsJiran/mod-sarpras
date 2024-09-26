<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\System\Traits\HasMeta;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// relatedm models morph
use Module\Human\Models\HumanUnit;
use Module\Infrastructure\Models\InfrastructureAssetVehicle;
use Module\Infrastructure\Models\InfrastructureAssetFurniture;
use Module\Infrastructure\Models\InfrastructureAssetElectronic;
use Module\Infrastructure\Models\InfrastructureAssetDocument;
use Module\Infrastructure\Models\InfrastructureAssetLand;

class InfrastructureAsset extends Model
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
    protected $table = 'infrastructure_assets';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-asset'];

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
        'name',
        'slug',
        'unit_id',
        'assetable',
    ];

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

            // return new AssetResource($model);
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

            // return new AssetResource($model);
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

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return void
     */
    public static function mapCombos(Request $request, $model = null): array
    {
        $human = HumanUnit::get(['id','name','slug']);
        $units = [];
        $units_name = [];
        $units_slug = [];

        foreach ($human as $key => $value) {
            array_push( $units_name, $value->name );
            array_push( $units_slug, $value->slug );
            $units[$value->slug] = $value;
        }

        return array_merge([

            'type' => [
                'Vehicle' => InfrastructureAssetVehicle::class,
                'Furniture' => InfrastructureAssetFurniture::class,
                'Electronic' => InfrastructureAssetElectronic::class,
                'Document' => InfrastructureAssetDocument::class,
                'Land' => InfrastructureAssetLand::class,
            ],

            'type_key' => [
                'Vehicle',
                'Furniture',
                'Electronic',
                'Document',
                'Land',                
            ],

            'units' => $units,
            'units_name' => $units_name,
            'units_slug' => $units_slug,

            'units_status_map' => [
                'Vehicle' => InfrastructureAssetVehicle::mapStatus(),
                'Furniture' => InfrastructureAssetFurniture::mapStatus(),
                'Electronic' => InfrastructureAssetElectronic::mapStatus(),
                'Document' => InfrastructureAssetDocument::mapStatus(),
                'Land' => InfrastructureAssetLand::mapStatus(),
            ]
            
        ]);
    }

}
