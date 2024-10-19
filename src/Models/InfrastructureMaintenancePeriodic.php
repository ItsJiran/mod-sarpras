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

class InfrastructureMaintenancePeriodic extends Model
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
    protected $table = 'infrastructure_maintenance_periodics';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-maintenance-periodic'];

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
        'maintenance_id', 
        'duedate',
        'period_number_day',
        'period_number_month',
        'period_number_year',               
    ];

    /**
     * ====================================================
     * +------------------ MAP RELATION ------------------+
     * ====================================================
     */
    

    /**
     * ====================================================
     * +------------------- MAP REQUEST ------------------+
     * ====================================================
     */

    /**
     * The model store method
     *
     * @param Request $request
     * @return array
     */
    public static function mapStoreRequestValidation(Request $request)
    {
        return [
            'duedate' => 'required|date',
            'period_number_day' => 'required|numeric',
            'period_number_month' => 'required|numeric',
            'period_number_year' => 'required|numeric',
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
            'duedate' => 'required|date',
            'period_number_day' => 'required|numeric',
            'period_number_month' => 'required|numeric',
            'period_number_year' => 'required|numeric',
        ];
    }

    /**
     * ====================================================
     * +------------------ MAP RESOURCE ------------------+
     * ====================================================
     */

    /**
     * The model store method
     *
     * @param Request $request
     * @return array
     */
    public static function mapResourceShow(Request $request, $model = null) : array
    {
        return [
            'duedate' => $model->duedate,
            'period_number_day' => $model->period_number_day,
            'period_number_month' => $model->period_number_month,
            'period_number_year' => $model->period_number_year,
        ];
    }

    /**
     * =================================================
     * +------------------ CRUD METHODS ---------------+
     * =================================================
     */

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request, InfrastructureMaintenance $main_model) : InfrastructureMaintenancePeriodic
    {
        $model = new static();
        
        $model->maintenance_id = $main_model->id;        
        $model->duedate = $request->duedate;        
        $model->period_number_day = $request->period_number_day;        
        $model->period_number_month = $request->period_number_month;        
        $model->period_number_year = $request->period_number_year;       
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
    public static function updateRecord(Request $request,InfrastructureMaintenance $main_model, $model = null) : InfrastructureMaintenanceAsset
    {
        $model->maintenance_id = $main_model->id;        
        $model->duedate = $request->duedate;        
        $model->period_number_day = $request->period_number_day;        
        $model->period_number_month = $request->period_number_month;        
        $model->period_number_year = $request->period_number_year; 
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
