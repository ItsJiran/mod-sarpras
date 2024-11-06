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
use Module\Infrastructure\Models\InfrastructureTaxRecord;
use Module\Infrastructure\Models\InfrastructureTaxRecordUsed;

use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;

class InfrastructureTaxRecordUsed extends Model
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
    protected $table = 'infrastructure_tax_record_useds';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-tax-record-used'];

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
        'tax_record_id',
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
     * Get the model that the image belongs to.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(InfrastructureTaxRecord::class, 'unit_id');        
    }   

    /**
     * Get the model that the image belongs to.
     */
    public function target(): BelongsTo
    {
        if($this->type == 'asset')
            return $this->belongsTo(InfrastructureTaxRecord::class, 'target_id');

        if($this->type == 'document')
            return $this->belongsTo(InfrastructureTaxRecord::class, 'target_id');
    }   

    public function target_class()
    {
        if($this->type == 'asset')
            return InfrastructureAsset::class;

        if($this->type == 'document')
            return InfrastructureDocument::class;
    }

    /**
     * ====================================================
     * +---------------- MAP RESOURCE METHODS ------------+
     * ====================================================
     */

     public static function mapResourceShow(Request $request, $model = null): array
     {
        $additional = [];

        if ($type == 'asset') {
            $additional = [
                'unit' => $this->target->unit::class()::mapResourceShow( $request, $this->target->unit ),
                'asset' => $this->target_class()::mapResourceShow( $request, $this->target ),
            ];
        } 
        if ($type == 'document') {
            $additional = [
                'unit' => $this->target->unit::class()::mapResourceShow( $request, $this->target->unit ),
                'document' => $this->target_class()::mapResourceShow( $request, $this->target ),
            ];
        } 

         return array_merge( [
            'target' => $this->target_class()::mapResourceShow( $request, $this->target ),
            'type' => $model->type,
         ], $additional );
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
            'types' => self::mapTypes()
        ];
    }   

    // map request
    public static function mapStoreRequest(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        $array = [
            'type' => [
                'required',
                Rule::in( self::mapTypes() ),
            ]
        ];

        if ( $request->type == 'asset' ) {
            $array = array_merge($array, [
                'asset.id' => 'required|exists:infrastructure_assets,id',                
            ]);
        }

        if ( $request->type == 'document' ) {
            $array = array_merge($array, [
                'document.id' => 'required|exists:infrastructure_documents,id',                
            ]);
        }

        return $array;
    }

    // +===============================================
    // +--------------- MAP OBJECT
    // +===============================================

    public static function mapTypes() : array
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
    public static function index(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {   
        $where_queries = [
            ['infrastructure_tax_record_useds.tax_record_id','=',$record->id]
        ];  

        $query = DB::table('infrastructure_tax_record_useds');

        // Conditionally join based on the user_type column
        $query->leftJoin('infrastructure_assets', function($join) {
            $join
            ->on('infrastructure_tax_record_useds.target_id', '=', 'infrastructure_assets.id')
            ->where('infrastructure_tax_record_useds.type', '=', 'asset');
        });        

        // Conditionally join based on the user_type column
        $query->leftJoin('infrastructure_documents', function($join) {
            $join
            ->on('infrastructure_tax_record_useds.target_id', '=', 'infrastructure_documents.id')
            ->where('infrastructure_tax_record_useds.type', '=', 'document');
        });

        // Select columns from users, employees, and ceo
        $query->select(
            'infrastructure_tax_record_useds.*', 
            \DB::raw("
                CASE
                    WHEN infrastructure_tax_record_useds.type = 'asset' THEN infrastructure_assets.name
                    WHEN infrastructure_tax_record_useds.type = 'document' THEN infrastructure_documents.name                    
                END AS name
            ")
        );

        return $query->paginate(15);
        // $join_asset = self::where('infrastructure_tax_record_useds.type', '=', 'asset')
        // ->join('infrastructure_assets', 'infrastructure_assets.id', '=', 'infrastructure_tax_record_useds.target_id')
        // ->where($where_queries)
        // ->applyMode($request->mode)
        // ->filter($request->filters)
        // ->search($request->findBy)
        // ->sortBy($request->sortBy)
        // ->paginate($request->itemsPerPage);        

        // $join_document = self::where('infrastructure_tax_record_useds.type', '=', 'document')
        // ->join('infrastructure_documents', 'infrastructure_documents.id', '=', 'infrastructure_tax_record_useds.target_id')
        // ->where($where_queries)
        // ->applyMode($request->mode)
        // ->filter($request->filters)
        // ->search($request->findBy)
        // ->sortBy($request->sortBy)
        // ->paginate($request->itemsPerPage);        

        return $query->where($where_queries)->paginate(15);
        // return $join_asset->merge($join_document);
    }

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();
        
        try {
            $model->type = $request['type']; 
            $model->tax_record_id = $record->id;

            if ($request['type'] == 'asset') {                
                $model->target_id = $request['asset']['id'];
                $model->is_freeze = false;
            }   

            if ($request['type'] == 'document') {
                $model->target_id = $request['document']['id'];
                $model->is_freeze = false;
            }

            $model->save();

            DB::connection($model->connection)->commit();

            // return new TaxRecordUsedResource($model);
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

            // return new TaxRecordUsedResource($model);
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
