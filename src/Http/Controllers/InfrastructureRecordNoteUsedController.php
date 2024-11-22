<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Http\Resources\RecordNoteUsedCollection;
use Module\Infrastructure\Http\Resources\RecordNoteUsedShowResource;

use Module\Infrastructure\Models\InfrastructureRecordNoteUsed;
use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureDocument;

class InfrastructureRecordNoteUsedController extends Controller
{
    // + =======================================================
    // + ------------------ INDEX METHODS ----------------------
    // + =======================================================

    public function index(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('view', InfrastructureRecordNoteUsed::class);
        $request = $this->determineRouteType($request);
        return new RecordNoteUsedCollection(
            InfrastructureRecordNoteUsed::index( $request, $record, $note )
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    public function indexFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {        
        return $this->index($request, $record, $note);
    }

    public function indexFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {                
        return $this->index($request, $record, $note);
    }

    public function indexFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->indexFromAsset($request, $asset, $record, $note);
    }

    public function indexFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->indexFromDocument($request, $document, $record, $note);
    }

    public function indexFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->indexFromDocument($request, $document, $record, $note);
    }

    public function indexFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->indexFromDocument($request, $document, $record, $note);
    }

    // + =======================================================
    // + ------------------ STORE METHODS ----------------------
    // + =======================================================

    public function store(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('create', InfrastructureRecordNoteUsed::class);

        $request->validate( 
            InfrastructureRecordNoteUsed::mapStoreRequest($request, $record, $note) 
        );

        $isResquestValid = InfrastructureRecordNoteUsed::mapStoreRequestValid($request,$record,$note);
        if ( !is_null($isResquestValid) ) return $isResquestValid;

        return InfrastructureRecordNoteUsed::storeRecord($request, $record, $note);
    }

    public function storeFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {        
        return $this->store($request, $record, $note);
    }

    public function storeFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {                
        return $this->store($request, $record, $note);
    }

    public function storeFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->storeFromAsset($request, $asset, $record, $note);
    }

    public function storeFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->storeFromDocument($request, $document, $record, $note);
    }

    public function storeFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->storeFromDocument($request, $document, $record, $note);
    }

    public function storeFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note){
        return $this->storeFromDocument($request, $document, $record, $note);
    }

    // + =======================================================
    // + ------------------ SHOW METHODS ----------------------
    // + =======================================================

    public function show(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {
        Gate::authorize('show', InfrastructureRecordNoteUsed::class);
        return new RecordNoteUsedShowResource($used);
    }

    public function showFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {        
        return $this->show($request, $record, $note, $used);
    }

    public function showFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {                
        return $this->show($request, $record, $note, $used);
    }

    public function showFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->showFromAsset($request, $asset, $record, $note, $used);
    }

    public function showFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->showFromDocument($request, $document, $record, $note, $used);
    }

    public function showFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->showFromDocument($request, $document, $record, $note, $used);
    }

    public function showFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->showFromDocument($request, $document, $record, $note, $used);
    }

    // + =======================================================
    // + ---------------- DESTROY METHODS ----------------------
    // + =======================================================

    public function destroy(InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {
        Gate::authorize('delete', $used);

        return InfrastructureRecordNoteUsed::deleteRecord($used);
    }

    public function destroyFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {        
        return $this->destroy( $record, $note, $used);
    }

    public function destroyFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {                
        return $this->destroy( $record, $note, $used);
    }

    public function destroyFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->destroyFromAsset($request, $asset, $record, $note, $used);
    }

    public function destroyFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->destroyFromDocument($request, $document, $record, $note, $used);
    }

    public function destroyFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->destroyFromDocument($request, $document, $record, $note, $used);
    }

    public function destroyFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->destroyFromDocument($request, $document, $record, $note, $used);
    }

    // + =======================================================
    // + ---------------- RESTORE METHODS ----------------------
    // + =======================================================

    public function restore(InfrastructureRecord $record, InfrastructureRecordNote $note,InfrastructureRecordNoteUsed $used)
    {
        Gate::authorize('restore', $used);

        return InfrastructureRecordNoteUsed::restoreRecord($used);
    }

    public function restoreFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {        
        return $this->restore( $record, $note, $used);
    }

    public function restoreFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {                
        return $this->restore( $record, $note, $used);
    }

    public function restoreFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->restoreFromAsset($request, $asset, $record, $note, $used);
    }

    public function restoreFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->restoreFromDocument($request, $document, $record, $note, $used);
    }

    public function restoreFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->restoreFromDocument($request, $document, $record, $note, $used);
    }

    public function restoreFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->restoreFromDocument($request, $document, $record, $note, $used);
    }

    // + =======================================================
    // + ------------------ FORCE METHODS ----------------------
    // + =======================================================

    public function forceDelete(InfrastructureRecord $record, InfrastructureRecordNote $note,InfrastructureRecordNoteUsed $used)
    {
        Gate::authorize('destroy', $used);

        return InfrastructureRecordNoteUsed::destroyRecord($used);
    }

    public function forceDeleteFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {        
        return $this->forceDelete( $record, $note, $used);
    }

    public function forceDeleteFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {                
        return $this->forceDelete( $record, $note, $used);
    }

    public function forceDeleteFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->forceDeleteFromAsset($request, $asset, $record, $note, $used);
    }

    public function forceDeleteFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->forceDeleteFromDocument($request, $document, $record, $note, $used);
    }

    public function forceDeleteFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->forceDeleteFromDocument($request, $document, $record, $note, $used);
    }

    public function forceDeleteFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used){
        return $this->forceDeleteFromDocument($request, $document, $record, $note, $used);
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
}
