<?php

namespace Module\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Module\Infrastructure\Http\Resources\RecordNoteCollection;
use Module\Infrastructure\Http\Resources\RecordNoteShowResource;

use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureUnit;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InfrastructureRecordNoteController extends Controller
{
 
    public function getImage(Request $request, $path) 
    {

        $path_file = Storage::disk('infrastructure')->path($path);

        if (!File::exists($path_file)) {
            abort(404);
        }
    
        $file = File::get($path_file);
        $type = File::mimeType($path_file);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    }

    public function index(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('view', InfrastructureRecordNote::class);

        return new RecordNoteCollection(
            $record->notes()
                ->applyMode($request->mode)
                ->filter($request->filters)
                ->search($request->findBy)
                ->sortBy($request->sortBy)
                ->paginate($request->itemsPerPage)
        );
    }

    public function indexFromUnit(Request $request, InfrastructureUnit $unit)
    {        
        // temporary
    }

    public function indexFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record)
    {        
        return $this->index($request, $record);
    }

    public function indexFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record)
    {                
        return $this->index($request, $record);
    }

    public function indexFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record){
        return $this->indexFromAsset($request, $asset);
    }

    public function indexFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->indexFromDocument($request, $document);
    }

    public function indexFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->indexFromDocument($request, $document);
    }

    public function indexFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->indexFromDocument($request, $document);
    }

    // + ================================================ +
    // + -------------- SHOW METHODS -------------------- +

    public function store(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('create', InfrastructureRecordNote::class);

        $request->validate( InfrastructureRecordNote::mapStoreRequest($request, $record) );
        $isResponseValid = InfrastructureRecordNote::mapStoreRequestValid($request, $record);
        
        if ( !is_null($isResponseValid) ) return $isResponseValid;
        return InfrastructureRecordNote::storeRecord($request, $record);
    }

    // + ================================================ +
    // + -------------- SHOW METHODS -------------------- +

    public function show(InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('show', $note);
        return new RecordNoteShowResource($note);
    }

    // + ================================================== +
    // + -------------- UPDATE METHODS -------------------- +

    public function update(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('update', $note);

        $request->validate( InfrastructureRecordNote::mapUpdateRequest($request, $record) );
        $isResponseValid = InfrastructureRecordNote::mapUpdateRequestValid($request, $record, $record);

        if ( !is_null($isResponseValid) ) {
            return $isResponseValid;   
        }

        return InfrastructureRecordNote::updateRecord($request, $record, $note);
    }

    // + ================================================== +
    // + -------------- DESTROY METHODS -------------------- +

    public function destroy(InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('delete', $note);

        return InfrastructureRecordNote::deleteRecord($note);
    }

    // + ================================================== +
    // + -------------- RETORE METHODS -------------------- +

    public function restore(InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('restore', $note);

        return InfrastructureRecordNote::restoreRecord($note);
    }

    // + ================================================== +
    // + -------------- FORCEDDEL METHODS -------------------- +


    public function forceDelete(InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('destroy', $note);

        return InfrastructureRecordNote::destroyRecord($note);
    }


    // + ===================================
    // + ----------- UTILITIES
    // + ===================================
    public function determineRouteType(Request $request) : Request
    {
        if ( $this->determineRouteName() == 'tax' )
            $request = InfrastructureRecord::mergeRequestTax($request);
        
        if ( $this->determineRouteName() == 'maintenance' ) 
            $request = InfrastructureRecord::mergeRequestMaintenance($request);

        return $request;
    }
    
    public function determineRouteName()
    {   
        $routeName = \Illuminate\Support\Facades\Route::current()->getName();
        return explode('::',$routeName)[0];
    }

    // + ===================================
    // + ----------- CHANGE
    // + ===================================

    public function changeToPending(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('update', $note);

        $isResponseValid = InfrastructureRecordNote::mapUpdateToPending($request, $record, $note);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureRecordNote::toPending($request, $record, $note);
    }


    public function changeToDraft(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('update', $note);

        $isResponseValid = InfrastructureRecordNote::mapUpdateToDraft($request, $record, $note);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureRecordNote::toDraft($request, $record, $note);
    }


    public function changeToVerified(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('update', $note);

        $isResponseValid = InfrastructureRecordNote::mapUpdateToVerified($request, $record, $note);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureRecordNote::toVerified($request, $record, $note);
    }

    public function changeToUnVerified(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('update', $note);

        $isResponseValid = InfrastructureRecordNote::mapUpdateToUnVerified($request, $record, $note);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureRecordNote::toUnVerified($request, $record, $note);
    }

    public function changeToCancelled(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('update', $note);

        $isResponseValid = InfrastructureRecordNote::mapUpdateToCancelled($request, $record, $note);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureRecordNote::toCancelled($request, $record, $note);
    }
}
