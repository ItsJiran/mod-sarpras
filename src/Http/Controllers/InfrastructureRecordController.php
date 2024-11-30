<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Http\Resources\RecordCollection;
use Module\Infrastructure\Http\Resources\RecordShowResource;

use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureRecordNote;

class InfrastructureRecordController extends Controller
{
    // + ===================================
    // + ----------- INDEX METHODS
    // + ===================================

    public function indexDeadline(Request $request)
    {
        Gate::authorize('view', InfrastructureRecord::class);

        return new RecordCollection(
            InfrastructureRecord::indexDeadline($request)
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );        
    }

    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureRecord::class);

        $request = $this->determineRouteType($request);

        if($request->type == 'tax')
            $eloqueint = InfrastructureRecord::indexTax($request);

        if($request->type == 'maintenance')
            $eloqueint = InfrastructureRecord::indexMaintenance($request);

        return new RecordCollection(
            $eloqueint->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    public function indexFromUnit(Request $request, InfrastructureUnit $unit)
    {        
        Gate::authorize('view', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        return new RecordCollection(
            $unit->taxes()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    public function indexFromAsset(Request $request, InfrastructureAsset $asset)
    {        
        Gate::authorize('view', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);

        if($request->type == 'tax')
            $eloqueint = $asset->taxes();

        if($request->type == 'maintenance')
            $eloqueint = $asset->maintenances();

        return new RecordCollection(
            $eloqueint->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    public function indexFromDocument(Request $request, InfrastructureDocument $document){                
        Gate::authorize('view', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);

        if($request->type == 'tax')
            $eloqueint = $document->taxes();

        if($request->type == 'maintenance')
            $eloqueint = $document->maintenances();

        return new RecordCollection(
            $eloqueint->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    public function indexFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset){
        return $this->indexFromAsset($request, $asset);
    }

    public function indexFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }

    public function indexFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }

    public function indexFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }

    // + ===================================
    // + ----------- STORE METHODS
    // + ===================================
    public function store(Request $request)
    {
        Gate::authorize('create', InfrastructureRecord::class);

        // Check apakah requesrt requirement ada
        $request = $this->determineRouteType($request);
        $request->validate( InfrastructureRecord::mapStoreRequest($request) );

        // Check apakah request valid
        $isRequestValid = InfrastructureRecord::mapStoreRequestValid($request);
        if( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureRecord::storeRecord($request);
    }
    
    public function storeFromAsset(Request $request, InfrastructureAsset $asset)
    {
        $request = InfrastructureRecord::mergeRequestAsset($request, $asset);
        return $this->store($request);
    }

    public function storeFromDocument(Request $request, InfrastructureDocument $document)
    {
        $request = InfrastructureRecord::mergeRequestDocument($request, $document);
        return $this->store($request);
    }

    public function storeFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->storeFromDocument($request, $document);
    }

    public function storeFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        return $this->storeFromAsset($request, $asset);
    }

    public function storeFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->storeFromDocument($request, $document);
    }

    public function storeFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document)
    {
        return $this->storeFromDocument($request, $document);
    }

    // + ===================================
    // + ----------- SHOW METHODS
    // + ===================================
    public function showDeadline( Request $request, $deadline_id )  
    {
        return new RecordShowResource( InfrastructureRecord::where('id',$deadline_id)->first() );        
    }

    public function show(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('show', $record);
        $request = $this->determineRouteType($request);
        return new RecordShowResource($record);
    }

    public function showFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record)
    {
        return $this->show($request, $record);
    }  

    public function showFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record)
    {
        return $this->show($request, $record);
    }

    public function showFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)
    {
        return $this->show($request, $record);
    }

    public function showFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)
    {
        return $this->show($request, $record);
    }
    
    public function showFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record)
    {
        return $this->show($request, $record);
    }

    public function showFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record)
    {
        return $this->show($request, $record);
    }

    // + ===================================
    // + ----------- UPDATE METHODS
    // + ===================================
    public function update(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('update', $record);

        // Check apakah requesrt requirement ada
        $request = $this->determineRouteType($request);
        $request->validate( InfrastructureRecord::mapUpdateRequest($request, $record) );

        // Check apakah request valid
        $isRequestValid = InfrastructureRecord::mapUpdateRequestValid($request);
        if( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureRecord::updateRecord($request, $record);
    }

    public function updateFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        Gate::authorize('update', $record);
        return $this->update($request, $record);
    }

    public function updateFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('update', $record);
        return $this->update($request, $record);
    }

    public function updateFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('update', $record);
        return $this->update($request, $record);
    }

    public function updateFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        Gate::authorize('update', $record);
        return $this->update($request, $record);
    }

    public function updateFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('update', $record);
        return $this->update($request, $record);
    }

    public function updateFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('update', $record);
        return $this->update($request, $record);
    }


    // + ===================================
    // + ----------- DESTROY METHODS
    // + ===================================
    public function destroy(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('delete', $record);

        // Check apakah request valid
        $isRequestValid = InfrastructureRecord::mapDestroyRequestValid($request);
        if( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureRecord::deleteRecord($record);
    }

    public function destroyFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        return $this->destroy($request, $record);
    }

    public function destroyFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->destroy($request, $record);
    }

    public function destroyFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->destroy($request, $record);
    }

    public function destroyFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        return $this->destroy($request, $record);
    }

    public function destroyFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->destroy($request, $record);
    }

    public function destroyFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->destroy($request, $record);
    }

    // + ===================================
    // + ----------- RESTORE METHODS
    // + ===================================
    public function restore(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('restore', $record);

        $isRequestValid = InfrastructureRecord::mapRestoreRequestValid($request);
        if( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureRecord::restoreRecord($record);
    }

    public function restoreFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        return $this->restore($request, $record);
    }

    public function restoreFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->restore($request, $record);

    }

    public function restoreFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->restore($request, $record);
    }

    public function restoreFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        return $this->restore($request, $record);
    }

    public function restoreFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->restore($request, $record);
    }

    public function restoreFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->restore($request, $record);
    }

    // + ===================================
    // + ----------- FORCE DESTROY METHODS
    // + ===================================
    public function forceDelete(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('destroy', $record);

        $isRequestValid = InfrastructureRecord::mapForceDeleteRequestValid($request);
        if( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureRecord::destroyRecord($record);
    }

    public function forceDeleteFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        return $this->forceDelete($request, $record);
    }

    public function forceDeleteFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->forceDelete($request, $record);
    }

    public function forceDeleteFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->forceDelete($request, $record);
    }

    public function forceDeleteFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        return $this->forceDelete($request, $record);
    }

    public function forceDeleteFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->forceDelete($request, $record);
    }

    public function forceDeleteFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        return $this->forceDelete($request, $record);
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
