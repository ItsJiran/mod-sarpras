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

// relateds documents models type
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Module\Infrastructure\Models\InfrastructureDocumentLandCertificate;
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

    /**
     * Get the model that the image belongs to.
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'documentable_type', 'documentable_id');
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
    public function asset(): BelongsTo
    {
        return $this->belongsTo(InfrastructureAsset::class, 'asset_id');
    }

    /**
     * Get the model that the image belongs to.
     */
    public function taxes()
    {
        return InfrastructureRecord::where('targetable_id',$this->id)
        ->join('infrastructure_documents','infrastructure_documents.id', '=', 'infrastructure_records.targetable_id')
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
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan operator
        $isUserOperator = $request->user()->hasLicenseAs('infrastructure-operator');
        if (!$isUserOperator && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan operator.'
            ], 500);
        }

        return null;
    }

    public static function mapUpdateRequestValid(Request $request, InfrastructureDocument $document) : JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan operator
        $isUserOperator = $request->user()->hasLicenseAs('infrastructure-operator');
        if (!$isUserOperator && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan operator.'
            ], 500);
        }

        return null;
    }

    public static function mapDeleteRequestValid(Request $request, InfrastructureDocument $document) : JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan operator
        $isUserOperator = $request->user()->hasLicenseAs('infrastructure-operator');
        if (!$isUserOperator && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan operator.'
            ], 500);
        }

        return null;
    }

    public static function mapRestoreRequestValid(Request $request, InfrastructureDocument $document): JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan operator
        $isUserOperator = $request->user()->hasLicenseAs('infrastructure-operator');
        if (!$isUserOperator && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan operator.'
            ], 500);
        }

        return null;
    }

    public static function mapForceDeleteRequestValid(Request $request, InfrastructureDocument $document): JsonResponse | null
    {
        // apabila user bukan admin dan note status sudah bukan draft maka jangan tambah
        $isUserAdmin = $request->user()->hasLicenseAs('infrastructure-administrator');
        $isUserSuperAdmin = $request->user()->hasLicenseAs('infrastructure-superadmin');

        // kalau user bukan operator
        $isUserOperator = $request->user()->hasLicenseAs('infrastructure-operator');
        if (!$isUserOperator && !$isUserAdmin && !$isUserSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa mengubah karena anda bukan operator.'
            ], 500);
        }

        return null;
    }

    /**
     * =====================================================
     * +------------------ MAP RESOURCES ------------------+
     * =====================================================
     */
    
     /**
     * The model map combos to be consume for frontend on another page
     * but only connected to unit
     *
     * @param [type] $model
     * @return void
     */
    public static function mapCombosOnlyUnit(Request $request, $model = null) 
    {
        $documents = self::where([
            ['unit_id','=',$request->unit->id],
            ['asset_id','=',null],
        ])->get();

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
     * The model map combos to be consume for frontend on another page
     * but only connected to asset
     *
     * @param [type] $model
     * @return void
     */
    public static function mapCombosOnlyAsset(Request $request, $model = null) 
    {
        $documents = self::where([
            ['unit_id','=',$request->unit->id],
            ['asset_id','=',$request->asset->id],
        ])->get();

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
     * The model map combos method
     *
     * @param [type] $model
     * @return void
     */
    public static function mapCombos(Request $request, $model = null): array
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
            $units_ids[strval($value->id)] = $value;
        }

        return array_merge([
            'status' => self::mapStatus(),
            // type class
            'type' => self::mapTypeClass(),
            'type_key' => self::mapTypeKeyClass(),

            // units array merges
            'units' => $units,
            'units_ids' => $units_ids,

            'units_name' => $units_name,
            'units_slug' => $units_slug,
        ]);
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return void
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
     * The model map combos method
     *
     * @return array
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
                'LandCertificate' => InfrastructureDocumentLandCertificate::class,
            ];
        } else {
            return [
                InfrastructureDocumentLandCertificate::class => 'LandCertificate',
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
            'LandCertificate',              
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
