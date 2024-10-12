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

// Relation Model
use Illuminate\Validation\Rule;
use App\Models\InfrastructureAsset;
use App\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureUnit;

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
        'description',
        
        'type',
        'period_number_day',
        'period_number_month',
        'period_number_year',

        'duedate',        
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
    public static function mapRequestValidation(Request $request, $model = null):array
    {
        $validation = [
            'name' => 'required',
            'duedate' => 'required|date',
            'type' => [
                'required',
                Rule::in( self::mapType() )
            ],
            'target' => 'required',
            'target_type' => [
                'required',
                Rule::in( self::mapMorphTypeKeyClass() )
            ],
        ];

        if ( $request->type == 'berkala' ) {
            $validation = array_merge( $validation, [
                'period_number_day' => 'required|numeric',
                'period_number_month' => 'required|numeric',
                'period_number_year' => 'required|numeric',
            ] );
        }

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
        // temporary
        $human = InfrastructureUnit::get(['id','name','slug']);

        // notes : assign units into properties
        $units = [];
        $units_ids = [];

        $units_name = [];
        $units_slug = [];

        // notes : mapping to the array so frontend can consume..
        foreach ($human as $key => $value) {
            array_push( $units_name, $value->name );
            array_push( $units_slug, $value->slug );

            $units[$value->slug] = $value;
            $units_id[$value->id] = $value;
        }

        return [
            // units array merges
            'units' => $units,
            'units_ids' => $units_ids,

            'units_name' => $units_name,
            'units_slug' => $units_slug,

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
                'Asset' => InfrastructureAsset::class,
                'Document' => InfrastructureDocument::class,
            ];
        } else {
            return [
                InfrastructureAsset::class => 'Asset',
                InfrastructureDocument::class => 'Document',
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

        try {
            // ...
            $model->save();
            $model->name = $request->name;
            $model->type = $request->type;
            $model->description = $request->description;
            $model->period_number_day = $request->period_number_day;
            $model->period_number_month = $request->period_number_month;
            $model->period_number_year = $request->period_number_year;
            $model->duedate = $request->duedate;
            $model->maintenanceable_id = $request->target['id'];
            $model->maintenanceable_type = self::mapMorphTypeClass(true)[$request->target_type];

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
            // ...
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
