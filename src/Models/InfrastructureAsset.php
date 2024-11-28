<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Module\System\Traits\HasMeta;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// related assets models type
use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Module\Infrastructure\Models\InfrastructureMaintenance;
use Module\Infrastructure\Models\InfrastructureAssetVehicle;
use Module\Infrastructure\Models\InfrastructureAssetFurniture;
use Module\Infrastructure\Models\InfrastructureAssetElectronic;
use Module\Infrastructure\Models\InfrastructureAssetLand;
use Module\Infrastructure\Models\InfrastructureUnit;

use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureTaxDocument;
use Module\Infrastructure\Models\InfrastructureTax;

use Module\Infrastructure\Http\Resources\AssetResource;
use Illuminate\Http\JsonResponse;

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
        'slug_unit',
        'slug_type',
        'unit_id',
        'assetable_id',
        'assetable_type',
    ];

    /**
     * countOfSlugType function
     *
     * @return int
     */
    public static function countOfSlug($slug_unit, $type_slug) : int 
    {
        if ($lastRecord = (static::where([
            ['slug_unit', '=', $slug_unit],
            ['slug_type', '=', $type_slug],
        ]))
        ->withTrashed()
        ->orderBy('id', 'DESC')
        ->first()
        ) {
            return intval(substr($lastRecord->slug, 11, 3));
        }

        return 0;
    }

    /**
     * generateSlug function
     *
     * @param [type] $type
     * @param [type] $date
     * @return string
     */
    public static function generateSlug($slug_unit, $type_slug): string
    {
        $count = (new self())->countOfSlug($slug_unit, $type_slug);
        return $slug_unit . '-' . 'SP'. '-' . $type_slug . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    /**
     * ====================================================
     * +---------------- RELATION METHODS ----------------+
     * ====================================================
     */

    /**
     * Get the model that the image belongs to.
     */
    public function assetable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'assetable_type', 'assetable_id');
    }   
    
    /**
     * Get the model that the image belongs to.
     */
    public function unit(): BelongsTo 
    {
        return $this->belongsTo(InfrastructureUnit::class, 'unit_id');
    }

    /**
     * Get the model that the image belongs to.
     */
    public function documents(): HasMany 
    {
        return $this->hasMany(InfrastructureDocument::class, 'asset_id');
    }

    /**
     * Get the model that the image belongs to.
     */
    public function taxes()
    {
        return InfrastructureRecord::where('targetable_id',$this->id)
        ->join('infrastructure_assets','infrastructure_assets.id', '=', 'infrastructure_records.targetable_id')
        ->where('infrastructure_records.targetable_type',self::class)
        ->where('infrastructure_records.type','tax')
        ->select('infrastructure_records.*');
    }

    /**
     * Get the model that the image belongs to.
     */
    public function maintenances()
    {
        return InfrastructureRecord::where('targetable_id',$this->id)
        ->join('infrastructure_assets','infrastructure_assets.id', '=', 'infrastructure_records.targetable_id')        
        ->where('infrastructure_records.targetable_type',self::class)
        ->where('infrastructure_records.type','maintenance')           
        ->select('infrastructure_records.*');
    }

    /**
     * ====================================================
     * +------------------- MAP COMBOS -------------------+
     * ====================================================
     */

    public static function mapCombos(Request $request, $model = null): array
    {
        $mapCombosUnit = InfrastructureUnit::mapCombosConsume();

        $mapCombosSelf = [
            // type class
            'type' => self::mapTypeClass(),
            'type_key' => self::mapTypeKeyClass(),
            'type_slug' => self::mapTypeSlug(),
            'type_status_map' => self::mapTypeStatusClass(),      
        ];

        return array_merge($mapCombosUnit, $mapCombosSelf);
    }

    /**
     * ====================================================
     * +------------------ MAP RESOURCE ------------------+
     * ====================================================
     */

    public static function mapResourceShow(Request $request, $model = null) : array
    {
        $asset_properties = self::mapResourceForSelf($request,$model);
        $asset_unit_properties = self::mapResourceForUnit($request,$model);
        $assetable_properties = self::mapResourceForAssetable($request,$model);
        return array_merge($asset_properties,$asset_unit_properties,$assetable_properties);
    }

    public static function mapResourceForSelf(Request $request, $model = null) : array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'slug' => $model->slug,
            'slug_unit' => $model->slug_unit,
            'slug_type' => $model->slug_type,
            'assetable_id' => $model->assetable_id,
            'assetable_type' => $model->assetable_type,
        ];
    }

    public static function mapResourceForUnit(Request $request, $model = null) : array 
    {
        return [
            'unit_id' => $model->unit->id,   
            'unit_name' => $model->unit->name,   
        ];
    }

    public static function mapResourceForAssetable(Request $request, $model = null) : array 
    {
        // asset key type
        $asset_type_keys = self::mapTypeClass(true);
        $asset_type_properties = $model->assetable_type::mapResourceShow($request, $model->assetable);

        return array_merge([
            'assetable_type_key' => $asset_type_keys[$model->assetable_type],
            'asset_type_key' => $asset_type_keys[$model->assetable_type],
        ], $asset_type_properties);
    }

    /**
     * ====================================================
     * +-------------------- MAP MISC --------------------+
     * ====================================================
     */

    public static function mapTypeClass($reverse = false) : array
    {
        if(!$reverse) {
            return [
                'Vehicle' => InfrastructureAssetVehicle::class,
                'Furniture' => InfrastructureAssetFurniture::class,
                'Electronic' => InfrastructureAssetElectronic::class,
                'Land' => InfrastructureAssetLand::class,
            ];
        } else {
            return [
                InfrastructureAssetVehicle::class => 'Vehicle',
                InfrastructureAssetFurniture::class => 'Furniture',
                InfrastructureAssetElectronic::class => 'Electronic',
                InfrastructureAssetLand::class => 'Land',
            ];
        }
    }

    public static function mapTypeKeyClass() : array
    {
        return [
            'Vehicle',
            'Furniture',
            'Electronic',
            'Land',                
        ];
    }

    public static function mapTypeSlug() : array
    {
        return [
            'Vehicle' => 'VHC',
            'Furniture' => 'FNT',
            'Electronic' => 'ELC',
            'Land' => 'LND',                
        ];
    }

    public static function mapTypeStatusClass() : array
    {
        return [
            'Vehicle' => InfrastructureAssetVehicle::mapStatus(),
            'Furniture' => InfrastructureAssetFurniture::mapStatus(),
            'Electronic' => InfrastructureAssetElectronic::mapStatus(),
            'Land' => InfrastructureAssetLand::mapStatus(),
        ];
    }

    /**
     * ============================================================
     * +------------------ MAP REQUEST RESOURCE ------------------+
     * ============================================================
     */

    public static function mapStoreRequestValid(Request $request) : JsonResponse | null
    {
        return ensureRequestUserOperator($request); 
    }

    public static function mapUpdateRequestValid(Request $request, InfrastructureAsset $asset) : JsonResponse | null
    {
        return ensureRequestUserOperator($request); 
    }

    public static function mapDeleteRequestValid(Request $request, InfrastructureAsset $asset) : JsonResponse | null
    {
        return ensureRequestUserOperator($request); 
    }

    public static function mapRestoreRequestValid(Request $request, InfrastructureAsset $asset): JsonResponse | null
    {
        return ensureRequestUserOperator($request); 
    }

    public static function mapForceDeleteRequestValid(Request $request, InfrastructureAsset $asset): JsonResponse | null
    {
        return ensureRequestUserOperator($request); 
    }

    /**
     * ====================================================
     * +------------------ CRUD METHODS ------------------+
     * ====================================================
     */

    public static function storeRecord(Request $request, $type_asset_class)
    {
        $model = new static();
        $type_asset_model = new $type_asset_class();

        DB::connection($model->connection)->beginTransaction();

        $unit = InfrastructureUnit::where('slug',$request->slug_unit)->first();

        $slug_unit = $request->slug_unit;
        $slug_type = self::mapTypeSlug()[$request->asset_type_key];
        $slug = self::generateSlug($slug_unit, $slug_type);      

        try {            
            // assign properties
            $model->unit_id = $unit->id;
            $model->name = $request->name;
            
            $model->slug = $slug;
            $model->slug_unit = $slug_unit;
            $model->slug_type = $slug_type;

            // store type model morph
            $model->assetable_type = $type_asset_class;           
            $type_model = $type_asset_model->storeRecord( $request, $model );

            // save
            $model->assetable_id = $type_model->id;
            $model->save();

            DB::connection($model->connection)->commit();

            return new AssetResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function updateRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        // type class
        $map_type_class = self::mapTypeClass();
        $type_model_class = $map_type_class[ $request->asset_type_key ];

        // type model
        $type_model = $model->assetable;

        // units slugs
        $unit = InfrastructureUnit::where('slug',$request->slug_unit)->first();
        $slug_unit = $request->slug_unit;
        $slug_type = self::mapTypeSlug()[$request->asset_type_key];
        $slug = self::generateSlug($slug_unit, $slug_type);      

        try {
            $type_model_class::updateRecord($request, $type_model);
            
            // update for main models class
            $model->name = $request->name;
            $model->slug = $slug;
            $model->slug_unit = $slug_unit;
            $model->slug_type = $slug_type;
            $model->unit_id = $unit->id;

            $model->save();

            DB::connection($model->connection)->commit();

            return new AssetResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

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
