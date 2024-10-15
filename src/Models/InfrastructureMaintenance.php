<?php

namespace Module\Infrastructure\Models;

use Module\System\Traits\HasMeta;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Relation Model
use Illuminate\Validation\Rule;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;

class InfrastructureMaintenance extends Model
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
    protected $table = 'infrastructure_maintenances';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-maintenance'];

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
        'type',
        'description',
        'duedate', 
        
        'period_number_day',
        'period_number_month',
        'period_number_year',
               
        'maintenanceable_id',
        'maintenanceable_type',
    ];

    
    /**
     * The default key for the order.
     *
     * @var string
     */
    protected $defaultOrder = 'name';

    /**
     * ====================================================
     * +---------------- RELATION METHODS ----------------+
     * ====================================================
     */

    /**
     * Get the model that the image belongs to.
     */
    public function maintenanceable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'maintenanceable_type', 'maintenanceable_id');
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
     * @return array
     */
    public static function mapResourceShow(Request $request, $model = null) : array 
    {
        $properties = [
            'name' => $model->name,
            'description' => $model->description,
            
            'type' => $model->type,
            'period_number_day' => $model->period_number_day,
            'period_number_month' => $model->period_number_month,
            'period_number_year' => $model->period_number_year,
    
            'duedate' => $model->duedate,        
            'maintenanceable_id' => $model->maintenanceable_id,
            'maintenanceable_type' => $model->maintenanceable_type,
        ];

        return array_merge(
            $properties,
            $show_properties,
        );
    }    

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapStoreRequestValidation(Request $request, $model = null):array
    {
        // validasi awal..
        $validation = [
            'name' => 'required',
            'duedate' => 'required|date',
            'type' => [
                'required',
                Rule::in( self::mapType() )
            ],
            'maintenanceable_type' => [
                'required',
                Rule::in( self::mapMorphTypeKeyClass() )
            ],
        ];

        // kalau berkala check angka period nya terisi atau tidak..
        if ( $request->type == 'berkala' ) {
            $validation = array_merge( $validation, [
                'period_number_day' => 'required|numeric',
                'period_number_month' => 'required|numeric',
                'period_number_year' => 'required|numeric',
            ] );
        }

        // mendapatkan request validasi dari morph nya..
        $morph_type_class = self::mapMorphTypeClass()[$request->maintenanceable];

        $validation = array_merge( 
            $validation, 
            $morph_type_class::mapStoreRequestValidation($request) 
        );

        return $validation;
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapCombos(Request $request, $model = null) : array 
    {  
        return [
            'types' => self::mapType(),
            'types_documents' => self::mapTypeDocuments(),

            'morph_type' => self::mapMorphTypeClass(),
            'morph_type_keys' => self::mapMorphTypeKeyClass(),
        ];
    }   

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapType() : array
    {
        return [
            'berkala',
            'manual',
        ];
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapTypeDocuments() : array
    {
        return [
            'Unit',
            'Asset',
        ];
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapMorphTypeClass($reverse = false) : array
    {
        if(!$reverse) {
            return [
                'Asset' => InfrastructureMaintenanceAsset::class,
                'Document' => InfrastructureMaintenanceDocument::class,
            ];
        } else {
            return [
                InfrastructureMaintenanceAsset::class => 'Asset',
                InfrastructureMaintenanceDocument::class => 'Document',
            ];
        }
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapMorphTypeKeyClass() : array
    {
        return [
            'Asset',
            'Document',             
        ];
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
    public static function storeRecord(Request $request)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        $morph_class = self::mapMorphTypeClass()[$request->target_type];

        try {
            // basic props
            $model->name = $request->name;
            $model->type = $request->type;
            $model->description = $request->description;
            $model->duedate = $request->duedate;        

            // period day
            if ($request->period_number_day != null) 
                $model->period_number_day = $request->period_number_day;
            if ($request->period_number_month)
                $model->period_number_month = $request->period_number_month;
            if ($request->period_number_month)
                $model->period_number_year = $request->period_number_year;

            // morph class properties
            $model->maintenanceable_id = $request->target['id'];            
            $model->maintenanceable_type = $morph_class;

            $model->save();

            DB::connection($model->connection)->commit();

            // return new MaintenanceResource($model);
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
            // basic props
            $model->name = $request->name;
            $model->type = $request->type;
            $model->description = $request->description;
            $model->duedate = $request->duedate;        

            // period day
            if ($request->period_number_day != null) 
                $model->period_number_day = $request->period_number_day;
            if ($request->period_number_month)
                $model->period_number_month = $request->period_number_month;
            if ($request->period_number_month)
                $model->period_number_year = $request->period_number_year;

            // morph class store
            $morph_type_class::storeRecord($request);

            // store the morph class first
            $morph_class = self::mapMorphTypeClass()[$request->target_type];
            $morph_model = $morph_class::storeRecord($request);
            $model->maintenanceable_type = $morph_class;

            // save
            $model->save();

            // update

            DB::connection($model->connection)->commit();

            // return new MaintenanceResource($model);
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
