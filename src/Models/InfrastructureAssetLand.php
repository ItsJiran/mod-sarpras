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

class InfrastructureAssetLand extends Model
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
    protected $table = 'infrastructure_asset_lands';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-asset-land'];

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
        'status',
        'atas_nama',
        'nop',
        'luas_bumi',
        'luas_bangunan',
        'njop_bumi',
        'njop_bangunan',
        'alamat_wajib_pajak',
        'alamat_objek_pajak',
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
            'receive_date' => $model->receive_date,
            'receive_price' => $model->receive_price,
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
            'dijual', //dijual
            'tersedia', //tersedia
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
            'receive_date' => 'required',
            'receive_price' => 'required',         
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
            'receive_date' => 'required',
            'receive_price' => 'required',         
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
            $model->receive_date = $request->receive_date;
            $model->receive_price = $request->receive_price;
            $model->status = $request->status;

            $model->atas_nama = $request->atas_nama;
            $model->nop = $request->nop;
            $model->luas_bumi = $request->luas_bumi;
            $model->luas_bangunan = $request->luas_bangunan;
            $model->njop_bumi = $request->njop_bumi;
            $model->njop_bangunan = $request->njop_bangunan;
            $model->alamat_wajib_pajak = $request->alamat_wajib_pajak;
            $model->alamat_objek_pajak = $request->alamat_objek_pajak;

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
            $model->receive_date = $request->receive_date;
            $model->receive_price = $request->receive_price;
            $model->status = $request->status;

            $model->atas_nama = $request->atas_nama;
            $model->nop = $request->nop;
            $model->luas_bumi = $request->luas_bumi;
            $model->luas_bangunan = $request->luas_bangunan;
            $model->njop_bumi = $request->njop_bumi;
            $model->njop_bangunan = $request->njop_bangunan;
            $model->alamat_wajib_pajak = $request->alamat_wajib_pajak;
            $model->alamat_objek_pajak = $request->alamat_objek_pajak;
            
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
