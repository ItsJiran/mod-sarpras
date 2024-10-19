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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Module\Infrastructure\Models\InfrastructureMaintenance;


class InfrastructureMaintenanceDocument extends Model
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
    protected $table = 'infrastructure_maintenancedocuments';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-maintenancedocument'];

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
        'maintenance_id',
        'unit_id',
        'asset_id',
        'document_id',
    ];

    /**
     * The default key for the order.
     *
     * @var string
     */
    protected $defaultOrder = 'name';

    /**
     * ====================================================
     * +-------------- MAP RELATIONSHIP ------------------+
     * ====================================================
     */

    /**
     * Get the model that the image belongs to.
     */
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(InfrastructureMaintenance::class, 'maintenance_id');
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
    public function document(): BelongsTo
    {
        return $this->belongsTo(InfrastructureDocument::class, 'document_id');
    }

    /**
     * ====================================================
     * +-------------- MAP RELATIONSHIP ------------------+
     * ====================================================
     */

    public static function mapStoreRequestValidation(Request $request) : array
    {
        $validation = [
            'unit' => 'required|array',
            'unit.id' => 'required|numeric|exists:human_units,id',

            'document' => 'required|array',
            'document.id' => 'required|numeric|exists:infrastructure_documents,id',
        ];

        if($request->asset != undefined){
            $validation = array_merge($validation, [
                'asset' => 'required|array',
                'asset.id' => 'required|numeric|exists:infrastructure_assets,id',
            ]);
        };

        if( is_array($request->unit) )
            $request->unit = (object) $request->unit;

        if( is_array($request->asset) )
            $request->asset = (object) $request->asset;

        if( is_array($request->document) )
            $request->document = (object) $request->document;

        return $validation;
    }

    public static function mapUpdateRequestValidation(Request $request) : array
    {
        $validation = [
            'unit' => 'required|array',
            'unit.id' => 'required|numeric|exists:human_units,id',

            'document' => 'required|array',
            'document.id' => 'required|numeric|exists:infrastructure_documents,id',
        ];

        if($request->asset != null){
            $validation = array_merge($validation, [
                'asset' => 'required|array',
                'asset.id' => 'required|numeric|exists:infrastructure_assets,id',
            ]);
        };

        if( is_array($request->unit) )
            $request->unit = (object) $request->unit;

        if( is_array($request->asset) )
            $request->asset = (object) $request->asset;

        if( is_array($request->document) )
            $request->document = (object) $request->document;

        return $validation;
    }

    /**
     * The model map combos method
     *
     * @param [type] $model
     * @return array
     */
    public static function mapResourceShow(Request $request, $model = null) : array 
    {
       return [
            'unit' => $model->unit::class::mapResourceShow( $request, $model->unit ),
            'asset' => $model->asset::class::mapResourceShow( $request, $model->asset ),
            'document' => $model->document::class::mapResourceShow( $request, $model->document ),
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
    public static function storeRecord(Request $request, InfrastructureMaintenance $main_model) : InfrastructureMaintenanceDocument
    {
        $model = new static();

        $model->maintenance_id = $main_model->id;
        $model->unit_id = $request->unit->id;
        $model->asset_id = $request->asset->id;
        $model->document_id = $request->document->id;
        $model->save();

        return $model;
    }

    /**
     * The model update method
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function updateRecord(Request $request,InfrastructureMaintenance $main_model, $model = null) : InfrastructureMaintenanceDocument
    {
        $model->maintenance_id = $main_model->id;   
        $model->unit_id = $request->unit->id;
        $model->asset_id = $request->asset->id;
        $model->document_id = $request->document->id;
        $model->save();
        return $model;
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
