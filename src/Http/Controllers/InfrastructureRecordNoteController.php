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
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;

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
        return $this->indexFromAsset($request, $asset, $record);
    }

    public function indexFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->indexFromDocument($request, $document, $record);
    }

    public function indexFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->indexFromDocument($request, $document, $record);
    }

    public function indexFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->indexFromDocument($request, $document, $record);
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

    public function storeFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record)
    {        
        return $this->store($request, $record);
    }

    public function storeFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record)
    {                
        return $this->store($request, $record);
    }

    public function storeFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record){
        return $this->storeFromAsset($request, $asset, $record);
    }

    public function storeFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->storeFromDocument($request, $document, $record);
    }

    public function storeFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->storeFromDocument($request, $document, $record);
    }

    public function storeFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record){
        return $this->storeFromDocument($request, $document, $record);
    }

    // + ================================================ +
    // + -------------- SHOW METHODS -------------------- +

    public function show(InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('show', $note);
        return new RecordNoteShowResource($note);
    }

    public function showFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {        
        return $this->show($record, $note);
    }

    public function showFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {                
        return $this->show($record, $note);
    }

    public function showFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->showFromAsset($request, $asset, $record, $note);
    }

    public function showFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->showFromDocument($request, $document, $record, $note);
    }

    public function showFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->showFromDocument($request, $document, $record, $note);
    }

    public function showFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->showFromDocument($request, $document, $record, $note);
    }

    // + ================================================== +
    // + -------------- UPDATE METHODS -------------------- +

    public function update(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('update', $note);

        $request->validate( InfrastructureRecordNote::mapUpdateRequest($request, $record) );
        $isResponseValid = InfrastructureRecordNote::mapUpdateRequestValid($request, $record, $note);

        if ( !is_null($isResponseValid) ) {
            return $isResponseValid;   
        }

        return InfrastructureRecordNote::updateRecord($request, $record, $note);
    }

    public function updateFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {        
        return $this->update($request, $record, $note);
    }

    public function updateFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {                
        return $this->update($request, $record, $note);
    }

    public function updateFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->updateFromAsset($request, $asset, $record, $note);
    }

    public function updateFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->updateFromDocument($request, $document, $record, $note);
    }

    public function updateFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->updateFromDocument($request, $document, $record, $note);
    }

    public function updateFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->updateFromDocument($request, $document, $record, $note);
    }

    // + ================================================== +
    // + -------------- DESTROY METHODS -------------------- +

    public function destroy(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('delete', $note);

        $isResponseValid = InfrastructureRecordNote::mapDeleteRequestValid($request, $record, $note);

        if ( !is_null($isResponseValid) ) {
            return $isResponseValid;   
        }


        return InfrastructureRecordNote::deleteRecord($request, $record, $note);
    }

    public function destroyFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {        
        return $this->destroy($request, $record, $note);
    }

    public function destroyFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {                
        return $this->destroy($request, $record, $note);
    }

    public function destroyFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->destroyFromAsset($request, $asset, $record, $note);
    }

    public function destroyFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->destroyFromDocument($request, $document, $record, $note);
    }

    public function destroyFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->destroyFromDocument($request, $document, $record, $note);
    }

    public function destroyFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->destroyFromDocument($request, $document, $record, $note);
    }

    // + ================================================== +
    // + -------------- RETORE METHODS -------------------- +

    public function restore(InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('restore', $note);

        return InfrastructureRecordNote::restoreRecord($note);
    }

    public function restoreFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {        
        return $this->restore($record, $note);
    }

    public function restoreFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {                
        return $this->restore($record, $note);
    }

    public function restoreFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->restoreFromAsset($request, $asset, $record, $note);
    }

    public function restoreFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->restoreFromDocument($request, $document, $record, $note);
    }

    public function restoreFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->restoreFromDocument($request, $document, $record, $note);
    }

    public function restoreFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->restoreFromDocument($request, $document, $record, $note);
    }

    // + ================================================== +
    // + -------------- FORCEDDEL METHODS -------------------- +


    public function forceDelete(InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('destroy', $note);

        return InfrastructureRecordNote::destroyRecord($note);
    }

    public function forceDeleteFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {        
        return $this->forceDelete($record, $note);
    }

    public function forceDeleteFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {                
        return $this->forceDelete($record, $note);
    }

    public function forceDeleteFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->forceDeleteFromAsset($request, $asset, $record, $note);
    }

    public function forceDeleteFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->forceDeleteFromDocument($request, $document, $record, $note);
    }

    public function forceDeleteFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->forceDeleteFromDocument($request, $document, $record, $note);
    }

    public function forceDeleteFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->forceDeleteFromDocument($request, $document, $record, $note);
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
