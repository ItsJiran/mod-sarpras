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

class InfrastructureRecordPeriodic extends Model
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
    protected $table = 'infrastructure_record_periodics';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-record-periodic'];

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
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $dates = ['duedate'];

    /**
     * ====================================================
     * +------------------- MAP REQUEST ------------------+
     * ====================================================
     */

    public static function mapStoreRequest(Request $request)
    {
        return [
            'duedate' => 'required|date',
            'period_number_day' => 'required|numeric',
            'period_number_month' => 'required|numeric',
            'period_number_year' => 'required|numeric',
        ];
    }

    public static function mapUpdateRequest(Request $request) : array
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
    public static function mapResourceShow(Request $request, $model = null) : array
    {
        return [
            'duedate' => $model->duedate,
            'period_number_day' => $model->period_number_day,
            'period_number_month' => $model->period_number_month,
            'period_number_year' => $model->period_number_year,
        ];
    }

    // + ====================================================
    // + ----------------- STORE RECORD
    // + ====================================================

    public static function storeRecord(Request $request, InfrastructureRecord $main_model) : InfrastructureRecordPeriodic
    {
        $model = new static();
        
        $model->record_id = $main_model->id;        
        $model->duedate = $request->duedate;        
        $model->period_number_day = $request->period_number_day;        
        $model->period_number_month = $request->period_number_month;        
        $model->period_number_year = $request->period_number_year;       
        $model->save();
            
        return $model;
    }

    // + ====================================================
    // + ----------------- UPDATE RECORD
    // + ====================================================

    public static function updateRecord(Request $request, InfrastructureRecord $main_model, $model = null) : InfrastructureRecordPeriodic
    {
        $model->tax_id = $main_model->id;        
        $model->duedate = $request->duedate;        
        $model->period_number_day = $request->period_number_day;        
        $model->period_number_month = $request->period_number_month;        
        $model->period_number_year = $request->period_number_year; 
        $model->save();
        return $model;
    }

    // + ====================================================
    // + ----------------- DELETE RECORD
    // + ====================================================

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

    // + ====================================================
    // + ----------------- RESTORE RECORD
    // + ====================================================

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

    // + ====================================================
    // + ----------------- DESTROY RECORD
    // + ====================================================

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
