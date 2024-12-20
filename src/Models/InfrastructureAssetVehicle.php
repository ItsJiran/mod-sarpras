<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Module\System\Traits\HasMeta;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;

use Module\Infrastructure\Models\InfrastructureAsset;

class InfrastructureAssetVehicle extends Model
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
    protected $table = 'infrastructure_asset_vehicles';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-asset-vehicle'];

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
        'brand',
        'receive_date',
        'receive_price',
        'last_location',

        'pic',
        'no_pol',
        'production_date',
        'sale_price',

        'status',
    ];

    /**
     * ====================================================
     * +------------------ MAPS METHODS ------------------+
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
        return array_merge([
            'brand' => $model->brand,
            'receive_date' => $model->receive_date,
            'receive_price' => $model->receive_price,
            'last_location' => $model->last_location,
            'pic' => $model->pic,
            'no_pol' => $model->no_pol,
            'production_date' => $model->production_date,
            'sale_price' => $model->sale_price,
            'status' => $model->status,
        ]);
    }

    /**
     * The model destroy method
     *
     * @param [type] $model
     * @return void
     */
    public static function mapStatus()
    {
        return [
            'dijual',     // dijual
            'dipinjam', // dipinjam
            'rusak',  // rusak
            'tersedia',  // tersedia
        ];
    }

    /**
     * The model destroy method
     *
     * @param [type] $model
     * @return void
     */
    public static function mapStoreValidation()
    {
        return [
            'brand' => 'required',
            'receive_date' => 'required',
            'receive_price' => 'required',         
            'last_location' => 'required',     
            
            'pic' => 'required',            
            'no_pol' => 'required',
            'production_date' => 'required',
            'sale_price' => 'required',

            'status' => [
                'required',
                Rule::in( self::mapStatus() ),
            ],
        ];
    }

    /**
     * The model destroy method
     *
     * @param [type] $model
     * @return void
     */
    public static function mapUpdateValidation()
    {
        return [
            'brand' => 'required',
            'receive_date' => 'required',
            'receive_price' => 'required',         
            'last_location' => 'required',   

            'pic' => 'required',            
            'no_pol' => 'required',
            'production_date' => 'required',
            'sale_price' => 'required',
            
            'status' => [
                'required',
                Rule::in( self::mapStatus() ),
            ],
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
    public static function storeRecord(Request $request, InfrastructureAsset $asset_model )
    {
        $model = new static();

        try {
            $model->brand = $request->brand;
            $model->asset_id = $asset_model->id;
            $model->receive_date = $request->receive_date;
            $model->receive_price = $request->receive_price;
            $model->last_location = $request->last_location;

            $model->pic = $request->pic;
            $model->no_pol = $request->no_pol;
            $model->production_date = $request->production_date;
            $model->sale_price = $request->sale_price;

            $model->status = $request->status;
            $model->save();

            return $model;
        } catch (\Exception $e) {
            throw $e;
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
        try {
            $model->brand = $request->brand;
            $model->receive_date = $request->receive_date;
            $model->receive_price = $request->receive_price;
            $model->last_location = $request->last_location;
            $model->status = $request->status;

            $model->pic = $request->pic;
            $model->no_pol = $request->no_pol;
            $model->production_date = $request->production_date;
            $model->sale_price = $request->sale_price;

            $model->save();
        } catch (\Exception $e) {
            throw $e;
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
