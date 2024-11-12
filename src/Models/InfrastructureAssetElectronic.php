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

class InfrastructureAssetElectronic extends Model
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
    protected $table = 'infrastructure_asset_electronics';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-asset-electronic'];

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
        'receive_date',
        'receive_price',
        'last_location',
        'status',

        'spesifikasi',
        'sale_price',
        'jumlah',
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
            'jumlah' => $model->jumlah,
            'sale_price' => $model->sale_price,
            'spesifikasi' => $model->spesifikasi,
            'receive_date' => $model->receive_date,
            'receive_price' => $model->receive_price,
            'last_location' => $model->last_location,
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
            'dijual', // dijual
            'rusak',  // rusak
            'dipinjam', // dipinjam
            'tersedia',    // tersedia
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
            'spesifikasi' => 'required',
            'sale_price' => 'required',
            'jumlah' => 'required',
            'receive_date' => 'required',
            'receive_price' => 'required',
            'last_location' => 'required',            
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
            'jumlah' => 'required',
            'spesifikasi' => 'required',
            'sale_price' => 'required',
            'receive_date' => 'required',
            'receive_price' => 'required',
            'last_location' => 'required',
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
            $model->jumlah = $request->jumlah;
            $model->sale_price = $request->sale_price;
            $model->spesifikasi = $request->spesifikasi;
            $model->receive_date = $request->receive_date;
            $model->receive_price = $request->receive_price;
            $model->last_location = $request->last_location;
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
            $model->jumlah = $request->jumlah;
            $model->sale_price = $request->sale_price;
            $model->spesifikasi = $request->spesifikasi;
            $model->receive_date = $request->receive_date;
            $model->receive_price = $request->receive_price;
            $model->last_location = $request->last_location;
            $model->status = $request->status;
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
