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
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Relation Model
use Illuminate\Validation\Rule;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureUnit;

// type of the morph 
use Module\Infrastructure\Models\InfrastructureTaxLog;
use Module\Infrastructure\Models\InfrastructureTaxPeriodic;

// type of the target tax
use Module\Infrastructure\Models\InfrastructureTaxAsset;
use Module\Infrastructure\Models\InfrastructureTaxDocument;

class InfrastructureTax extends Model
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
    protected $table = 'infrastructure_taxes';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-tax'];

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
        'description',
        
        'targetable_id',
        'targetable_type',

        'taxable_id',
        'taxable_type',
    ];

    /**
     * ====================================================
     * +---------------- RELATION METHODS ----------------+
     * ====================================================
     */

    /**
     * Get the model that the image belongs to.
     */
    public function taxable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'taxable_type', 'taxable_id');
    }  

    /**
     * Get the model that the image belongs to.
     */
    public function targetable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'targetable_type', 'targetable_id');
    }  

    /**
     * ====================================================
     * +------------------- MAP REQUEST ------------------+
     * ====================================================
     */
    
    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mergeRequestAsset(Request $request, InfrastructureAsset $asset) : Request 
    {
        return $request->merge([ 
            'unit' => $asset->unit,
            'asset' => $asset,
            'targetable_type_key' => 'Asset',
        ]);
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mergeRequestDocument(Request $request, InfrastructureDocument $document) : Request 
    {
        return $request->merge([ 
            'unit' => $document->unit,
            'asset' => $document->asset,
            'document' => $document,
            'targetable_type_key' => 'Document',
        ]);
    }

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
             
            'taxable_id' => $model->taxable_id,
            'taxable_type' => $model->taxable_type,
            'taxable_type_key' => self::mapMorphTypeClass(true)[$model->taxable_type],

            'targetable_id' => $model->targetable_id,
            'targetable_type' => $model->targetable_type,
            'targetable_type_key' => self::mapMorphTargetClass(true)[$model->targetable_type],
        ];

        return array_merge(
            $properties,
            $model->taxable_type::mapResourceShow($request, $model->taxable),
            $model->targetable_type::mapResourceShow($request, $model->targetable),
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
        // convert to obj
        if( is_array($request->unit) )
            $request->unit = (object) $request->unit;

        if( is_array($request->asset) )
            $request->asset = (object) $request->asset;

        if( is_array($request->document) )
            $request->document = (object) $request->document;

        // validasi awal..
        $validation = [
            'name' => 'required',

            'taxable_type_key' => [
                'required', 
                Rule::in( self::mapMorphTypeKeyClass() )
            ],

            'targetable_type_key' => [
                'required', 
                Rule::in( self::mapMorphTargetKeyClass() )
            ],
        ];

        // mendapatkan request validasi dari morph nya..        
        $taxable_class = self::mapMorphTypeClass()[$request->taxable_type_key];
        $targetable_class = self::mapMorphTargetClass()[$request->targetable_type_key];

        $validation = array_merge( 
            $validation, 
            $taxable_class::mapStoreRequestValidation($request),
            $targetable_class::mapStoreRequestValidation($request),
        );

        return $validation;
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapUpdateRequestValidation(Request $request, $model = null):array
    {
        // convert to obj
        if( is_array($request->unit) )
            $request->unit = (object) $request->unit;

        if( is_array($request->asset) )
            $request->asset = (object) $request->asset;

        if( is_array($request->document) )
            $request->document = (object) $request->document;

        // validasi awal..
        $validation = [
            'name' => 'required',

            'taxable_type_key' => [
                'required', 
                Rule::in( self::mapMorphTypeKeyClass() )
            ],

            'targetable_type_key' => [
                'required', 
                Rule::in( self::mapMorphTargetKeyClass() )
            ],
        ];

        // mendapatkan request validasi dari morph nya..        
        $taxable_class = self::mapMorphTypeClass()[$request->taxable_type_key];
        $targetable_class = self::mapMorphTargetClass()[$request->targetable_type_key];

        $validation = array_merge( 
            $validation, 
            $taxable_class::mapUpdateRequestValidation($request),
            $targetable_class::mapUpdateRequestValidation($request),
        );

        return $validation;
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
    public static function mapCombos(Request $request, $model = null) : array 
    {
        return [            
            'types_documents' => self::mapTypeDocuments(),

            'morph_target' => self::mapMorphTargetClass(),
            'morph_target_keys' => self::mapMorphTargetKeyClass(),

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
    public static function mapMorphTargetClass($reverse = false) : array
    {
        if(!$reverse) {
            return [
                'Asset' => InfrastructureTaxAsset::class,
                'Document' => InfrastructureTaxDocument::class,
            ];
        } else {
            return [
                InfrastructureTaxAsset::class => 'Asset',
                InfrastructureTaxDocument::class => 'Document',
            ];
        }        
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapMorphTargetKeyClass() : array
    {
        return [
            'Asset',
            'Document',
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
                'Log' => InfrastructureTaxLog::class,
                'Periodic' => InfrastructureTaxPeriodic::class,
            ];
        } else {
            return [
                InfrastructureTaxLog::class => 'Log',
                InfrastructureTaxPeriodic::class => 'Periodic',
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
            'Log',
            'Periodic',             
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
        $latest_id = self::latest()->withTrashed()->pluck('id')->first();
        if ( is_null( $latest_id ) ) return 1;
        else                         return $latest_id + 1;        
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
    public static function storeRecord(Request $request)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        // class for each bla-bla
        $taxable_class = self::mapMorphTypeClass()[$request->taxable_type_key];
        $targetable_class = self::mapMorphTargetClass()[$request->targetable_type_key];

        try {
            $model->id = $model->getNewId();

            // basic props
            $model->name = $request->name;
            $model->description = $request->description;

            // save in morph class
            $taxable_model = $taxable_class::storeRecord($request, $model);
            $targetable_model = $targetable_class::storeRecord($request, $model);

            // morph class properties
            $model->targetable_id = $targetable_model->id;
            $model->targetable_type = $targetable_model::class;

            // morph class properties
            $model->taxable_id = $taxable_model->id;
            $model->taxable_type = $taxable_model::class;

            $model->save();

            DB::connection($model->connection)->commit();

            // return new TaxResource($model);
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

        // class for each bla-bla
        $taxable_class = self::mapMorphTypeClass()[$request->taxable_type_key];
        $targetable_class = self::mapMorphTargetClass()[$request->targetable_type_key];

        try {
            // basic props
            $model->name = $request->name;
            $model->type = $request->type;
            $model->duedate = $request->duedate;        
            $model->description = $request->description;        

            // -- morph class update            
            if( $taxable_class == $model->taxable_type ){

                // kalau sama maka jalankan model tipe method update record..
                $taxable_class::updateRecord($request, $model, $model->taxable);

            } else if ( $taxable_class != $model->taxable_type ) {

                // kalau ganti tipe maka delete dan buat record baru di type yang baru
                $new_taxable_model = $taxable_class::storeRecord($request, $model);

                // detroy record di maintenance type yang lama
                $model->taxable_type::destroyRecord( $model->taxable );

                // update maintenace dengna property yang baru
                $model->taxable_id = $new_taxable_model->id;
                $model->taxable_type = $new_taxable_model::class;

            }

            // kalau ganti tipe maka delete dan buat record baru di type yang baru
            if( $targetable_class == $model->targetable_type ){

                // kalau sama maka jalankan model tipe method update record..
                $targetable_class::updateRecord($request, $model, $model->targetable);

            } else if ( $targetable_class != $model->targetable_type ) {

                // kalau ganti tipe maka delete dan buat record baru di type yang baru
                $new_targetable_model = $targetable_class::storeRecord($request, $model);

                // detroy record di maintenance type yang lama
                $model->targetable_type::destroyRecord( $model->targetable );

                // update maintenace dengna property yang baru
                $model->targetable_id = $new_targetable_model->id;
                $model->targetable_type = $new_targetable_model::class;
                
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
