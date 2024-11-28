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

use Module\Infrastructure\Models\InfrastructureDocumentLandCertificate;
use Module\Infrastructure\Models\InfrastructureDocumentBpkb;
use Module\Infrastructure\Models\InfrastructureDocumentStnk;
use Module\Infrastructure\Models\InfrastructureDocumentOther;

// relateds documents models type
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureAsset;

use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureTax;

use Module\Infrastructure\Http\Resources\DocumentResource;


class InfrastructureDocument extends Model
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
    protected $table = 'infrastructure_documents';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-document'];

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
        'unit_id',
        'asset_id',
        'name',
        'description',
        'status',
        'documentable',
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

    public function documentable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'documentable_type', 'documentable_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(InfrastructureUnit::class, 'unit_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(InfrastructureAsset::class, 'asset_id');
    }

    public function taxes()
    {
        return InfrastructureRecord::where('targetable_id',$this->id)
        ->join('infrastructure_documents','infrastructure_documents.id', '=', 'infrastructure_records.targetable_id')
        ->where('infrastructure_records.targetable_type',self::class)
        ->where('infrastructure_records.type','tax')
        ->select('infrastructure_records.*');
    }

    public function maintenances()
    {
        return InfrastructureRecord::where('targetable_id',$this->id)
        ->join('infrastructure_documents','infrastructure_documents.id', '=', 'infrastructure_records.targetable_id')        
        ->where('infrastructure_records.targetable_type',self::class)
        ->where('infrastructure_records.type','maintenance')           
        ->select('infrastructure_records.*');
    }

    /**
     * =========================================================
     * +------------------ MAP REQUEST VALID ------------------+
     * =========================================================
     */

    public static function mapStoreRequestValid(Request $request) : JsonResponse | null
    {
       return ensureRequestUserOperator($request); 
    }

    public static function mapUpdateRequestValid(Request $request, InfrastructureDocument $document) : JsonResponse | null
    {
       return ensureRequestUserOperator($request); 
    }

    public static function mapDeleteRequestValid(Request $request, InfrastructureDocument $document) : JsonResponse | null
    {
       return ensureRequestUserOperator($request); 
    }

    public static function mapRestoreRequestValid(Request $request, InfrastructureDocument $document): JsonResponse | null
    {
       return ensureRequestUserOperator($request); 
    }

    public static function mapForceDeleteRequestValid(Request $request, InfrastructureDocument $document): JsonResponse | null
    {
       return ensureRequestUserOperator($request); 
    }

    /**
     * =====================================================
     * +--------------------- MAP SCOPE -------------------+
     * =====================================================
     */

    public function scopeUnit(InfrastructureUnit $unit)
    {
        $this->where([
            'unit_id', '=', $unit->id
        ]);

        return $this;
    }

    public function scopeAsset(InfrastructureAsset $asset)
    {
        $this->where([
            'asset_id', '=', $asset->id
        ]);

        return $this;
    }

    public function scopeAssetNull()
    {
        $this->where([
            'asset_id', '=', null
        ]);

        return $this;
    }

    /**
     * =====================================================
     * +-------------------- MAP COMBOS -------------------+
     * =====================================================
     */

    public static function mapCombos(Request $request, $model = null): array
    {
        $mapCombosUnit = InfrastructureUnit::mapCombosConsume();

        $mapCombosSelf = [
            'status' => self::mapStatus(),
            'type' => self::mapTypeClass(),
            'type_key' => self::mapTypeKeyClass(),
        ];

        return array_merge( $mapCombosUnit, $mapCombosSelf );
    }

    public static function mapCombosOnlyUnit(Request $request, InfrastructureUnit $unit) 
    {
        $documents = (new static())
        ->scopeUnit($unit)
        ->scopeAssetNull()
        ->get();

        return self::mapDocumentCombos($documents);

    }

    public static function mapCombosOnlyAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset) 
    {
        $documents = (new static())
        ->scopeUnit($unit)
        ->scopeAsset($asset)
        ->get();

        return self::mapDocumentCombos($documents);
    }

    public static function mapDocumentCombos($documents) 
    {
        $documents_ids = [];
        $documents_ids_combos = [];

        foreach ($documents as $key => $value) {
            $documents_ids[ $value->id ] = $value;
            array_push( $documents_ids_combos, $value->id );
        }

        return [
            'documents' => $documents,
            'documents_ids' => $documents_ids,
            'documents_ids_combos' => $documents_ids_combos,
        ];
    }

    /**
     * =======================================================
     * +-------------------- MAP RESOURCE -------------------+
     * =======================================================
     */
    
    public static function mapResourceShow(Request $request, $model = null): array
    {
        // documents key type
        $documents_type_keys = self::mapTypeClass(true);

        $document_properties = [
            'id' => $model->id,
            'name' => $model->name,
            'asset_id' => $model->asset_id,
            'description' => $model->description,
            'status' => $model->status,

            'documentable_id' => $model->documentable_id,
            'documentable_type' => $model->documentable_type,
            'documentable_type_key' => $documents_type_keys[$model->documentable_type],
        ];

        // documents type properties
        $documentable_type_properties = $model->documentable_type::mapResourceShow($request, $model->documentable);

        // assets documents type properties 
        $document_asset_properties = [ 'asset' => [] ];
        if ( !is_null($model->asset_id) ) {
            $document_asset_properties['asset'] = $model->asset::mapResourceShow( 
                $request,
                $model->asset,
            );
        } 

        // unist documents properties
        $document_unit_properties = [ 'unit' => [] ];
        if ( !is_null($model->unit_id) ) {
            $document_unit_properties['unit'] = $model->unit::mapResourceShow( 
                $request,
                $model->unit,
            );
        } 

        return array_merge(
            $document_properties,
            $documentable_type_properties,
            $document_asset_properties,
            $document_unit_properties
        );
    }

    /**
     * =========================================================
     * +-------------------- MAP STATUS ETC -------------------+
     * =========================================================
     */

    public static function mapStatus(): array 
    {
        return [
            'tersedia',
            'perubahan',
            'pembaharuan',
            'mutasi',
            'pinjam',
        ];
    }

    public static function mapTypeClass($reverse = false) : array
    {
        if(!$reverse) {
            return [
                'LandCertificate' => InfrastructureDocumentLandCertificate::class,
                'Bpkb' => InfrastructureDocumentBpkb::class,
                'Stnk' => InfrastructureDocumentStnk::class,
                'Other' => InfrastructureDocumentOther::class,
            ];
        } else {
            return [
                InfrastructureDocumentLandCertificate::class => 'LandCertificate',
                InfrastructureDocumentBpkb::class => 'Bpkb',
                InfrastructureDocumentStnk::class => 'Stnk',
                InfrastructureDocumentOther::class => 'Other',
            ];
        }
    }

    public static function mapTypeKeyClass() : array
    {
        return [
            'LandCertificate',              
            'Bpkb',              
            'Stnk',              
            'Other',              
        ];
    }

    /**
     * ================================================
     * +------------------ MAP CRUD ------------------+
     * ================================================
     */

    public static function storeRecord(Request $request, $type_model_class)
    {
        $model = new static();
        
        DB::connection($model->connection)->beginTransaction();

        try {
            if( isset($request->unit) && isset($request->unit->id) )
                $model->unit_id = $request->unit->id;

            if( isset($request->asset) && isset($request->asset->id) )
                $model->asset_id = $request->asset->id;
            else 
                $model->asset_id = null;

            $model->name = $request->name;
            $model->description = $request->description;
            $model->status = $request->status;
        
            // handling morph
            $type_model = $type_model_class::storeRecord($request, $model);

            $model->documentable_id = $type_model->id;
            $model->documentable_type = $type_model::class;

            $model->save();

            DB::connection($model->connection)->commit();

            return new DocumentResource($model);
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

        try {
            if( isset($request->unit) && isset($request->unit->id) )
                $model->unit_id = $request->unit->id;

            if( isset($request->asset) && isset($request->asset->id) )
                $model->asset_id = $request->asset->id;
            else 
                $model->asset_id = null;

            $model->name = $request->name;
            $model->description = $request->description;
            $model->status = $request->status;

            $model->documentable::updateRecord($request, $model->documentable);
            $model->save();

            DB::connection($model->connection)->commit();

            return new DocumentResource($model);
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
