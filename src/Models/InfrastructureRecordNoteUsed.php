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
use Illuminate\Validation\Rule;

use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureRecordNote;

use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;

class InfrastructureRecordNoteUsed extends Model
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
    protected $table = 'infrastructure_record_note_useds';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-record-note-used'];

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
        'name',
        'tax_record_id',
        'target_id',
        'type',
        'is_freeze',
    ];

    /**
     * ====================================================
     * +---------------- RELATION METHODS ----------------+
     * ====================================================
     */



    /**
     * =================================================
     * +---------------- STORE METHODS ----------------+
     * =================================================
     */


    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        try {
            // ...
            $model->save();

            DB::connection($model->connection)->commit();

            // return new RecordNoteUsedResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ==================================================
     * +---------------- UPDATE METHODS ----------------+
     * ==================================================
     */


    public static function updateRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            // ...
            $model->save();

            DB::connection($model->connection)->commit();

            // return new RecordNoteUsedResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ==================================================
     * +---------------- DELETE METHODS ----------------+
     * ==================================================
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
     * ===================================================
     * +---------------- RESTORE METHODS ----------------+
     * ===================================================
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
     * ===================================================
     * +---------------- DESTROY METHODS ----------------+
     * ===================================================
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
