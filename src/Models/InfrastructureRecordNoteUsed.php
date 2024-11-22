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

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;

use Module\Infrastructure\Http\Resources\RecordNoteUsedResource;

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
        'note_id',
        'targetable_id',        
        'targetable_type',        
        'dibekukan',
    ];

    /**
     * ====================================================
     * +---------------- RELATION METHODS ----------------+
     * ====================================================
     */

     public function note(): BelongsTo
     {
        return $this->belongsTo(InfrastructureRecordNote::class, 'note_id');
     } 

     public function target(): MorphTo
     {
        return $this->morphTo(__FUNCTION__, 'targetable_type', 'targetable_id');
     }

    /**
     * ================================================
     * +---------------- MAP STATUSES ----------------+
     * ================================================
     */

     public function isAsset() : bool
     {
        return $this->targetable_type == InfrastructureAsset::class;
     }

     public function isDocument() : bool
     {
        return $this->targetable_type == InfrastructureDocument::class;
     }

    /**
     * ===============================================
     * +---------------- MAP METHODS ----------------+
     * ===============================================
     */

     public static function mapResourceShow(Request $request, $model = null) : array 
     {
        $properties = [
            'id' => $model->id,
            'name' => $model->target->name,
        ];

        $additional = [];

        if ( !is_null($model->target->unit) ) {
            $additional['unit'] = InfrastructureUnit::mapResourceShow($request, $model->target->unit);
        }

        if ($model->isAsset()) {
            $additional['asset'] = $model->targetable_type::mapResourceShow($request, $model->target);
            $additional['type'] = 'asset';
        }

        if ($model->isDocument()) {
            $additional['document'] = $model->targetable_type::mapResourceShow($request, $model->target);
            $additional['type'] = 'document';

            if ( !is_null($model->target->asset) ) {
                $additional['asset'] = InfrastructureAsset::mapResourceShow($request, $model->target->asset);
                $additional['jenis'] = 'iya';
            }
        }

        return array_merge($properties, $additional);
     }

     public static function mapCombos(Request $request, $model = null) : array 
     {
         return [            
             'types' => self::mapTypes()
         ];
     }   

     public static function mapTypes() : array
     {
         return [
             'asset',
             'document',
         ];
     }

    // +------------------------------
    // +------------ STORE REQUEST

     public static function mapStoreRequest(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
     {
         $array = [
             'type' => [
                 'required',
                 Rule::in( self::mapTypes() ),
             ]
         ];
 
         if ( $request->type == 'asset' ) {
             $array = array_merge($array, [
                 'asset.id' => 'required|exists:infrastructure_assets,id',                
             ]);
         }
 
         if ( $request->type == 'document' ) {
             $array = array_merge($array, [
                 'document.id' => 'required|exists:infrastructure_documents,id',                
             ]);
         }
 
         return $array;
     }

     public static function mapStoreRequestValid(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note) : JsonResponse | null
     {
        // queri untuk menentukan apakah user sudah memasukkan target yang sama
        $isExistQueries = [
            ['note_id','=',$note->id],
        ];

        // buat validasi detect apakah asset / dokumen adalah yang 
        // sama dengan yang ditujukan ke record
        
        if ($request->type == 'asset') {
            $recordIsAsset = $record->targetable_type == InfrastructureAsset::class;
            $recordIsSame  = $record->targetable_id == $request['asset']['id'];

            $isExistQueries = array_merge($isExistQueries,[ ['targetable_type','=', InfrastructureAsset::class] ]);
            $isExistQueries = array_merge($isExistQueries,[ ['targetable_id','=', $request['asset']['id']] ]);

            if ( $recordIsAsset && $recordIsSame ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa memasukkan yang digunakan adalah target yang sama..'
                ], 500);
            }
        }

        if ($request->type == 'document') {
            $recordIsDocument = $record->targetable_type == InfrastructureDocument::class;
            $recordIsSame  = $record->targetable_id == $request['document']['id'];
            
            $isExistQueries = array_merge($isExistQueries,[ ['targetable_type','=', InfrastructureDocument::class] ]);
            $isExistQueries = array_merge($isExistQueries,[ ['targetable_id','=', $request['document']['id']] ]);

            if ( $recordIsAsset && $recordIsSame ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tujuan asset / dokumen tidak bisa 
                    sama dengan catatan tujuan..'
                ], 500);
            }
        }

        // buat validasi deteksi apakah yang diinput sudah ada dalam catatan ini

        $isExist = !is_null( InfrastructureRecordNoteUsed::where($isExistQueries)->first() );

        if($isExist){
            return response()->json([
                'success' => false,
                'message' => 'Tujuan asset / dokumen sudah ada..'
            ], 500);
        }

        return null;
     }

    public static function mapUpdateRequestValid(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note, $model) : JsonResponse | null
    {
        // buat validasi kalau misalnya asset 
        // sama atau kalau misalnya sudah ada disini..



        return null;
    }

    /**
     * =================================================
     * +---------------- INDEX METHODS ----------------+
     * =================================================
     */

     public static function index(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
     {   
         $where_queries = [
             ['infrastructure_record_note_useds.note_id','=',$note->id]             
         ];  
 
        //  $query = DB::table('infrastructure_record_note_useds')
        //  ->where($where_queries);

         $query = InfrastructureRecordNoteUsed::where($where_queries);
 
         // Conditionally join based on the user_type column
         $query->leftJoin('infrastructure_assets', function($join) {
             $join
             ->on('infrastructure_record_note_useds.targetable_id', '=', 'infrastructure_assets.id')
             ->where('infrastructure_record_note_useds.targetable_type', '=', InfrastructureAsset::class);
         });        
 
         // Conditionally join based on the user_type column
         $query->leftJoin('infrastructure_documents', function($join) {
             $join
             ->on('infrastructure_record_note_useds.targetable_id', '=', 'infrastructure_documents.id')
             ->where('infrastructure_record_note_useds.targetable_type', '=', InfrastructureDocument::class);             
         });
 
         // Select columns from users, employees, and ceo
         $query->select(
             'infrastructure_record_note_useds.*', 
             \DB::raw("
                 CASE
                     WHEN infrastructure_record_note_useds.targetable_type = '" 
                     . InfrastructureAsset::class ."' 
                     THEN infrastructure_assets.name
                     
                     WHEN infrastructure_record_note_useds.targetable_type = '" 
                     . InfrastructureDocument::class ."' 
                     THEN infrastructure_documents.name                    
                 END AS name
             ")
         );
 
         return $query;
     }

    /**
     * =================================================
     * +---------------- STORE METHODS ----------------+
     * =================================================
     */

     public static function storeRecord(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
     {
         $model = new static();
 
         DB::connection($model->connection)->beginTransaction();
         
         try {
            $model->note_id = $note->id;

            if(!is_null($request->dibekukan))            
                $model->dibekukan = $request->dibekukan;

            if ($request['type'] == 'asset') {                
                $returned_name = $request['asset']['name'];
                $model->targetable_id = $request['asset']['id'];
                $model->targetable_type = InfrastructureAsset::class;
            }   

            if ($request['type'] == 'document') {
                $returned_name = $request['document']['name'];
                $model->targetable_id = $request['document']['id'];
                $model->targetable_type = InfrastructureDocument::class;
            }

            $model->save();

            DB::connection($model->connection)->commit();

            $target_return = $model->target;
            $target_return->id = $model->id;

            return new RecordNoteUsedResource($target_return);
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

            return new RecordNoteUsedResource($model);
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
