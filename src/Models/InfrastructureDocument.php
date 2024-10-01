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

// relateds documents models type
use Module\Infrastructure\Models\InfrastructureDocumentLandCertificate;

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
     * =====================================================
     * +------------------ MAP RESOURCES ------------------+
     * =====================================================
     */
    
     /**
     * The model map combos method
     *
     * @param [type] $model
     * @return void
     */
    public static function mapCombos(Request $request, $model = null): array
    {
        return array_merge([
            'status' => self::mapStatus(),
            // type class
            'type' => self::mapTypeClass(),
            'type_key' => self::mapTypeKeyClass(),
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
            'name' => $model->name,
            'asset_id' => $model->asset_id,
            'description' => $model->description,
            'status' => $model->status,
            
            'documentable_id' => $model->documentable_id,
            'documentable_type' => $model->documentable_type,
            'documentable_key' => $documents_type_keys[$model->documentable_type],
        ];

        // documents type properties
        $documentable_type_properties = $model->documentable_type::mapResourceShow($request, $model->documentable);

        return array_merge($document_properties,$documentable_type_properties);
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
            $model->asset_id = $request->asset_id;            
            $model->name = $request->name;
            $model->description = $request->description;
            $model->status = $request->status;
        
            // handling morph
            $type_model = $type_model_class::storeRecord($request, $model);

            $model->documentable_id = $type_model->id;
            $model->documentable_type = $type_model::class;

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

        try {
            // ...
            $model->save();

            DB::connection($model->connection)->commit();

            // return new DocumentResource($model);
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
