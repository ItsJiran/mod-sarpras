<?php

namespace Module\Infrastructure\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Module\System\Traits\HasMeta;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;

use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

use Module\Infrastructure\Models\InfrastructureRecordNoteUsed;
use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\Infrastructure\Models\InfrastructureRecordPeriodic;

use Module\Infrastructure\Http\Resources\RecordResource;

class InfrastructureRecord extends Model
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
    protected $table = 'infrastructure_records';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['infrastructure-record'];

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
        'type',
        'description',
        
        'recordable_id',
        'recordable_type',

        'targetable_id',
        'targetable_type',
    ];

    /**
     * ====================================================
     * +---------------- RELATION METHODS ----------------+
     * ====================================================
     */

    public function recordable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'recordable_type', 'recordable_id');
    }  

    public function targetable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'targetable_type', 'targetable_id');
    }  

    public function notes(): HasMany
    {
        return $this->hasMany(InfrastructureRecordNote::class, 'record_id');
    }

    public function record_key()
    {
        return self::mapMorphRecordClass(true)[$this->recordable_type];
    }

    public function target_key()
    {
        return self::mapMorphTargetClass(true)[$this->targetable_type];
    }

    /**
     * ====================================================
     * +---------------- STATUSES METHODS ----------------+
     * ====================================================
     */

    public function isRecordLog()
    {
        return $this->record_key() == 'Log';
    }
    
    public function isRecordPeriodic()
    {
        return $this->record_key() == 'Periodic';
    }
    
    public function isTargetAsset()
    {
        return $this->target_key() == 'Asset';
    }

    public function isTargetDocument()
    {
        return $this->target_key() == 'Document';
    }

    /**
     * ====================================================
     * +------------------- MAP REQUEST ------------------+
     * ====================================================
     */

    public static function mergeRequestTax(Request $request) : Request
    {
        return $request->merge([ 
            'type' => 'tax'
        ]);
    }

    public static function mergeRequestMaintenance(Request $request) : Request
    {
        return $request->merge([ 
            'type' => 'maintenance'
        ]);
    }

    public static function mergeRequestAsset(Request $request, InfrastructureAsset $asset) : Request 
    {
        return $request->merge([ 
            'unit' => $asset->unit,
            'asset' => $asset,
            'targetable_type_key' => 'Asset',
        ]);
    }

    public static function mergeRequestDocument(Request $request, InfrastructureDocument $document) : Request 
    {
        return $request->merge([ 
            'unit' => $document->unit,
            'asset' => $document->asset,
            'document' => $document,
            'targetable_type_key' => 'Document',
        ]);
    }

    /**
     * ====================================================
     * +----------------- MAP RESOURCES ------------------+
     * ====================================================
     */

    public static function mapResourceShow(Request $request , $model = null) : array 
    {        
        $record_properties = self::mapResourceForSelf($request, $model);
        $recordable_properties = self::mapResourceForRecordable($request, $model);
        $targetable_properties = self::mapResourceForTargetable($request, $model);

        return array_merge(
            $record_properties,
            $recordable_properties,
            $targetable_properties
        );
    }

    public static function mapResourceForSelf(Request $request, $model = null) : array 
    {
        return [
            'name' => $model->name,
            'description' => $model->description,                        
             
            'recordable_id' => $model->recordable_id,
            'recordable_type' => $model->recordable_type,
            'recordable_type_key' => self::mapMorphRecordClass(true)[$model->recordable_type],

            'targetable_id' => $model->targetable_id,
            'targetable_type' => $model->targetable_type,
            'targetable_type_key' => self::mapMorphTargetClass(true)[$model->targetable_type],
        ];
    }

    public static function mapResourceForRecordable(Request $request, $model = null) : array 
    {
        return $model->recordable_type::mapResourceShow($request, $model->recordable);
    }

    public static function mapResourceForTargetable(Request $request, $model = null) : array 
    {
        $targetable_key = self::mapMorphTargetClass(true)[$model->targetable_type];

        if($targetable_key == 'Asset')
            return self::mapResourceForTargetableAsset($request, $model);

        if($targetable_key == 'Document')
            return self::mapResourceForTargetableDocument($request, $model);
    }

    public static function mapResourceForTargetableAsset(Request $request, $model = null) : array 
    {
        return [
            'unit' => InfrastructureUnit::mapResourceShow($request, $model->targetable->unit),
            'asset' => InfrastructureAsset::mapResourceShow($request, $model->targetable),
        ]; 
    }
    
    public static function mapResourceForTargetableDocument(Request $request, $model = null) : array 
    {
        $properties = [
            'unit' => InfrastructureUnit::mapResourceShow($request, $model->targetable->unit),
            'asset' => InfrastructureAsset::mapResourceShow($request, $model->targetable->asset),
            'document' => InfrastructureDocument::mapResourceShow($request, $model->targetable),
        ];

        if ( !is_null($properties['asset']) ) {
            $properties['jenis'] = 'Iya';
        } else {
            $properties['jenis'] = 'Tidak';
        }

        return $properties;
    }

    // + ========================================================
    // + ----------------- MAP REQUEST VALIDATION
    // + ========================================================

    public static function mapDefaultObject( Request $request )
    {
        if( is_array($request->unit) )
            $request->unit = (object) $request->unit;

        if( is_array($request->asset) )
            $request->asset = (object) $request->asset;

        if( is_array($request->document) )
            $request->document = (object) $request->document;

        return $request;
    }

    public static function mapDefaultValidation( Request $request ) : array 
    {
        return [
            'name' => 'required',
            'type' => [
                'required',
                Rule::in( self::mapType() )
            ],
            'recordable_type_key' => [
                'required', 
                Rule::in( self::mapMorphRecordKeyClass() )
            ],            
            'targetable_type_key' => [
                'required', 
                Rule::in( self::mapMorphTargetKeyClass() )
            ],
        ];
    }

    public static function mapRequestMorphClass( Request $request ) : array 
    {
        $recordable_class = self::mapMorphRecordClass()[$request->recordable_type_key];
        $targetable_class = self::mapMorphTargetClass()[$request->targetable_type_key];
        
        return [
            'recordable' => $recordable_class,
            'targetable' => $targetable_class,
        ];
    }

    /**
     * =====================================================
     * +---------------------- MAP BASE -------------------+
     * =====================================================
     */

    public static function mapResource(Request $request, $model)
    {
        $target = $model->targetable_type::where('id',$model->targetable_id)->first();
        $record_deadline_status = self::mapDeadlineStatus($model);
        $record_deadline_tgl = $model->recordable_type::where('id',$model->recordable_id)->first()->duedate;
        
        return [
            'id' => $model->id,
            'name' => $model->name,
            'name_unit' => $target->unit->name,
            'name_target' => $target->name,
            'type_target' => self::mapMorphTargetClass(true)[$model->targetable_type],
            'record_deadline_status' => $record_deadline_status,
            'record_deadline_tgl' => $record_deadline_tgl,
        ];
    }

    public static function mapHeaders(Request $request): array 
    {
        return [
            ['title' => 'Nama', 'value' => 'name', 'sortable' => true],
            ['title' => 'Nama Tujuan', 'value' => 'name_target', 'sortable' => true],
            ['title' => 'Tipe Tujuan', 'value' => 'type_target', 'sortable' => true],
            ['title' => 'Unit Tujuan', 'value' => 'name_unit', 'sortable' => true],
            ['title' => 'Status Deadline', 'value' => 'record_deadline_status', 'sortable' => true],
            ['title' => 'Tanggal Deadline', 'value' => 'record_deadline_tgl', 'sortable' => true],
        ];
    }

    public static function mapDeadlineStatus($model) : string 
    {
        if ( self::mapMorphRecordClass(true)[$model->recordable_type] == 'Periodic' ) {
            $close = Carbon::today()->addMonth(3);
            $now = Carbon::now();
        
            $record_periodic = $model->recordable_type::where('id',$model->recordable_id)->first();
            $record_deadline = Carbon::parse($record_periodic->duedate);

            $exceedDeadline = $record_deadline->lt($now);
            if ( $exceedDeadline ) 
                return 'Melewati';

            $currentDeadline = $record_deadline->isSameDay( $now );
            if ( $currentDeadline )
                return 'Sekarang';

            $closeDeadline = $record_deadline->lte($close);
            if ( $closeDeadline )
                return 'Mendekati';

            $farDeadline = $record_deadline->gt($close);
            if ( $farDeadline )
                return 'Masih Lama';
        }

        return 'Tidak Ada Deadline';
    }

    // + ======================
    // + -------- STORE
    // + ======================

    public static function mapStoreRequest(Request $request):array
    {
        // convert 
        $request            = self::mapDefaultObject($request);
        $default_validation = self::mapDefaultValidation($request);
        $morph_class        = self::mapRequestMorphClass($request);

        // mendapatkan request validasi dari morph nya..        
        $validation = array_merge( 
            $default_validation, 
            $morph_class['recordable']::mapStoreRequest($request),       
        );

        return $validation;
    }

    public static function mapUpdateRequest(Request $request, $model = null):array
    {
        // convert 
        $request            = self::mapDefaultObject($request);
        $default_validation = self::mapDefaultValidation($request);
        $morph_class        = self::mapRequestMorphClass($request);

        $validation = array_merge( 
            $default_validation, 
            $morph_class['recordable']::mapUpdateRequest($request),
        );

        return $validation;
    }

    /**
     * ====================================================
     * +------------- MAP REQUEST VALID ------------------+
     * ====================================================
     */

    public static function mapStoreRequestValid(Request $request) : JsonResponse | null
    {
        return ensureRequestUserOperator($request);
    }

    public static function mapUpdateRequestValid(Request $request) : JsonResponse | null
    {
        return ensureRequestUserOperator($request);
    }

    public static function mapDestroyRequestValid(Request $request) : JsonResponse | null
    {
        return ensureRequestUserOperator($request);
    }

    public static function mapRestoreRequestValid(Request $request) : JsonResponse | null
    {
        return ensureRequestUserOperator($request);
    }

    public static function mapForceDeleteRequestValid(Request $request) : JsonResponse | null
    {
        return ensureRequestUserOperator($request);
    }

    /**
     * ====================================================
     * +------------------ MAP RESOURCE ------------------+
     * ====================================================
     */

    public static function mapCombos(Request $request, $model = null) : array 
    {
        return [            
            'types_documents' => self::mapTypeDocuments(),

            'morph_target' => self::mapMorphTargetClass(),
            'morph_target_keys' => self::mapMorphTargetKeyClass(),

            'morph_record' => self::mapMorphRecordClass(),
            'morph_record_keys' => self::mapMorphRecordKeyClass(),
        ];
    }   

    public static function mapTypeDocuments() : array
    {
        return [
            'Unit',
            'Asset',
        ];
    }

    public static function mapMorphTargetClass($reverse = false) : array
    {
        if(!$reverse) {
            return [
                'Asset' => InfrastructureAsset::class,
                'Document' => InfrastructureDocument::class,
            ];
        } else {
            return [
                InfrastructureAsset::class => 'Asset',
                InfrastructureDocument::class => 'Document',
            ];
        }        
    }

    public static function mapMorphTargetKeyClass() : array
    {
        return [
            'Asset',
            'Document',
        ];
    }

    public static function mapMorphRecordClass($reverse = false) : array
    {
        if(!$reverse) {
            return [
                'Log' => InfrastructureRecordLog::class,
                'Periodic' => InfrastructureRecordPeriodic::class,
            ];
        } else {
            return [
                InfrastructureRecordLog::class => 'Log',
                InfrastructureRecordPeriodic::class => 'Periodic',
            ];
        }
    }

    public static function mapMorphRecordKeyClass() : array
    {
        return [
            'Log',
            'Periodic',             
        ];
    }

    public static function mapType() : array
    {
        return [
            'tax',
            'maintenance',             
        ];
    }

    public function getNewId() 
    {   
        $latest_id = self::latest()->withTrashed()->pluck('id')->first();
        if ( is_null( $latest_id ) ) return 1;
        else                         return $latest_id + 1;        
    }

    /**
     * ====================================================
     * +------------------ CRUD METHODS ------------------+
     * ====================================================
     */

    // +-------------------------------
    // +--------- INDEX METHODS
    // +-------------------------------     
    public static function indexTax(Request $request) 
    {   
        return self::where('type','tax');
    }

    public static function indexMaintenance(Request $request) 
    {   
        return self::where('type','maintenance');
    }

    public static function indexDeadline(Request $request) 
    {          
        // ambil 3 bulan dari sekarang
        $deadline = Carbon::today()->addMonth(3);
        $deadline_queries = [
            ['infrastructure_records.recordable_type','=',InfrastructureRecordPeriodic::class],
            ['infrastructure_record_periodics.duedate','<=',$deadline],
        ];

        // eloquent
        $eloquent = self::leftJoin('infrastructure_record_periodics', function($join) {
            $join
            ->on('infrastructure_records.recordable_id', '=', 'infrastructure_record_periodics.id')
            ->where('infrastructure_records.recordable_type', '=', InfrastructureRecordPeriodic::class);
        })->where($deadline_queries)->select(
            'infrastructure_records.*'
        );

        return $eloquent;
    }


    // +-------------------------------
    // +--------- STORE METHODS
    // +-------------------------------
    public static function storeRecord(Request $request)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        try {
            $model->id = $model->getNewId();

            // basic props
            $model->name = $request->name;
            $model->type = $request->type;
            $model->description = $request->description;

            self::storeRecordable($request, $model);
            self::storeTargetable($request, $model);

            $model->save();

            DB::connection($model->connection)->commit();

            return new RecordResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function storeRecordable( Request $request, $model )
    {
        $recordable_class = self::mapMorphRecordClass()[$request->recordable_type_key];
        $recordable_model = $recordable_class::storeRecord($request, $model);

        // morph class properties
        $model->recordable_id   = $recordable_model->id;
        $model->recordable_type = $recordable_model::class;
    }

    public static function storeTargetable( Request $request, $model )
    {
        // set up morph target 
        $targetable_class = self::mapMorphTargetClass()[$request->targetable_type_key];
        $model->targetable_type = $targetable_class;

        if ( $request->targetable_type_key == 'Asset' ) 
            $model->targetable_id   = $request->asset->id; 

        if ( $request->targetable_type_key == 'Document' ) 
            $model->targetable_id   = $request->document->id;  
    }

    // +-------------------------------
    // +--------- UPDATE METHODS
    // +-------------------------------

    public static function updateRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            // update
            $model->name = $request->name;
            $model->type = $request->type;
            $model->description = $request->description;

            self::updateRecordable($request, $model);
            self::updateTargetable($request, $model);

            $model->save();

            DB::connection($model->connection)->commit();

            return new RecordResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function updateRecordable( Request $request, $model )
    {
        $recordable_class = self::mapMorphRecordClass()[$request->recordable_type_key];        

        if ( $recordable_class == $model->recordable_type ) {
            $recordable_class::updateRecord($request, $model, $model->recordable);
        } else {
            // kalau ganti tipe maka delete dan buat record baru di type yang baru
            $new_recordable_model = $recordable_class::storeRecord($request, $model);

            // detroy record di maintenance type yang lama
            $model->recordable_type::destroyRecord( $model->recordable );

            // update maintenace dengan property yang baru
            $model->recordable_id = $new_recordable_model->id;
            $model->recordable_type = $new_recordable_model::class;
        }
    }

    public static function updateTargetable( Request $request, $model )
    {
        // set up morph target 
        $targetable_class = self::mapMorphTargetClass()[$request->targetable_type_key];
        $model->targetable_type = $targetable_class;
        
        if ( $request->targetable_type_key == 'Asset' ) 
            $model->targetable_id = $request->asset->id; 

        if ( $request->targetable_type_key == 'Document' ) 
            $model->targetable_id = $request->document->id;  
        
    }

    // +-------------------------------
    // +--------- DELETE METHODS
    // +-------------------------------

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

    // +-------------------------------
    // +--------- RESTORE METHODS
    // +-------------------------------

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

    // +-------------------------------
    // +--------- DESTROY METHODS
    // +-------------------------------

    public static function destroyRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            // hapus notes dan notes used nya
            $notes = InfrastructureRecordNote::where('record_id',$model->id)->get();

            foreach ($notes as $key => $note) {
                InfrastructureRecordNoteUsed::where('note_id',$note->id)->forceDelete();
                $note->forceDelete();
            }

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
