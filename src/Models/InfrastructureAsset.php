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

// relatedm models morph
use Module\Infrastructure\Models\InfrastructureAssetVehicle;
use Module\Infrastructure\Models\InfrastructureAssetFurniture;
use Module\Infrastructure\Models\InfrastructureAssetElectronic;
use Module\Infrastructure\Models\InfrastructureAssetDocument;
use Module\Infrastructure\Models\InfrastructureAssetLand;
use Module\Infrastructure\Models\InfrastructureUnit;

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
     * ====================================================
     * +------------------ MAP RESOURCE ------------------+
     * ====================================================
     */

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return void
     */
    public static function mapResourceShow(Request $request, $model = null): array
    {
        // asset key type
        $asset_type_keys = self::mapTypeClass(true);

        // moprh
        $unit = InfrastructureUnit::where('slug',$model->slug_unit)->first();

        $asset_property = [
            'name' => $model->name,
            'slug' => $model->slug,
            'slug_unit' => $model->slug_unit,
            'slug_type' => $model->slug_type,

            'unit_id' => $model->unit_id,   
            'unit_name' => $unit->name,    
            'assetable_id' => $model->assetable_id,
            'assetable_type' => $model->assetable_type,
            'asset_type_key' => $asset_type_keys[$model->assetable_type],
        ];

        // assetable morph
        $asset_type_properties = $model->assetable_type::mapResourceShow($request, $model->assetable);

        return array_merge($asset_property, $asset_type_properties);
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return void
     */
    public static function mapCombos(Request $request, $model = null): array
    {
        $human = InfrastructureUnit::get(['id','name','slug']);
        $units = [];
        $units_name = [];
        $units_slug = [];

        foreach ($human as $key => $value) {
            array_push( $units_name, $value->name );
            array_push( $units_slug, $value->slug );
            $units[$value->slug] = $value;
        }

        return array_merge([
            // type class
            'type' => self::mapTypeClass(),
            'type_key' => self::mapTypeKeyClass(),
            'type_slug' => self::mapTypeSlug(),
            'type_status_map' => self::mapTypeStatusClass(),         
            // units array merges
            'units' => $units,
            'units_name' => $units_name,
            'units_slug' => $units_slug,
        ]);
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapTypeClass($reverse = false) : array
    {
        if(!$reverse) {
            return [
                'Vehicle' => InfrastructureAssetVehicle::class,
                'Furniture' => InfrastructureAssetFurniture::class,
                'Electronic' => InfrastructureAssetElectronic::class,
                'Document' => InfrastructureAssetDocument::class,
                'Land' => InfrastructureAssetLand::class,
            ];
        } else {
            return [
                InfrastructureAssetVehicle::class => 'Vehicle',
                InfrastructureAssetFurniture::class => 'Furniture',
                InfrastructureAssetElectronic::class => 'Electronic',
                InfrastructureAssetDocument::class => 'Document',
                InfrastructureAssetLand::class => 'Land',
            ];
        }
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapTypeKeyClass() : array
    {
        return [
            'Vehicle',
            'Furniture',
            'Electronic',
            'Document',
            'Land',                
        ];
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapTypeSlug() : array
    {
        return [
            'Vehicle' => 'VHC',
            'Furniture' => 'FNT',
            'Electronic' => 'ELC',
            'Document' => 'DMT',
            'Land' => 'LND',                
        ];
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapTypeStatusClass() : array
    {
        return [
            'Vehicle' => InfrastructureAssetVehicle::mapStatus(),
            'Furniture' => InfrastructureAssetFurniture::mapStatus(),
            'Electronic' => InfrastructureAssetElectronic::mapStatus(),
            'Document' => InfrastructureAssetDocument::mapStatus(),
            'Land' => InfrastructureAssetLand::mapStatus(),
        ];
    }

    /**
     * ====================================================
     * +------------------ CRUD METHODS ------------------+
     * ====================================================
     */

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request, $type_asset_class)
    {
        $model = new static();
        $type_asset_model = new $type_asset_class();

        DB::connection($model->connection)->beginTransaction();

        // NOTES : Ambil data unit berdasarkan slug dari si unit..
        $unit = InfrastructureUnit::where('slug',$request->slug_unit)->first();

        // NOTES : Mapping setiap slug..
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
