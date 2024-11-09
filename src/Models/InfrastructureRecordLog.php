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

class InfrastructureRecordLog extends Model
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
    protected $table = 'infrastructure_record_logs';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-record-log'];

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
    public static function mapResourceShow(Request $request, $model = null) : array 
    {
       return [
       ];
    }

    /**
     * The model store method
     *
     * @param Request $request
     * @return array
     */
    public static function mapStoreRequestValidation(Request $request)
    {
        return [
        ];
    }

    /**
     * The model store method
     *
     * @param Request $request
     * @return array
     */
    public static function mapUpdateRequestValidation(Request $request) : array
    {
        return [
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
    public static function storeRecord(Request $request) : InfrastructureRecordLog 
    {
        $model = new static();
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
    public static function updateRecord(Request $request, $model = null) : InfrastructureRecordLog
    {
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
       $model->delete();
    }

    /**
     * The model restore method
     *
     * @param [type] $model
     * @return void
     */
    public static function restoreRecord($model)
    {
        $model->restore();
    }

    /**
     * The model destroy method
     *
     * @param [type] $model
     * @return void
     */
    public static function destroyRecord($model)
    {
        $model->forceDelete();
    }
}