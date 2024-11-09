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
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        return new RecordCollection(
            InfrastructureRecord::applyMode($request->mode)
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
        return new RecordCollection(
            $asset->taxes()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    public function indexFromDocument(Request $request, InfrastructureDocument $document){                
        Gate::authorize('view', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        return new RecordCollection(
            $document->taxes()
            ->applyMode($request->mode)
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
        $request = $this->determineRouteType($request);
        $request->validate( 
            InfrastructureRecord::mapStoreRequestValidation($request)
        );
        return InfrastructureRecord::storeRecord($request);
    }
    
    public function storeFromAsset(Request $request, InfrastructureAsset $asset)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        return $this->store($request);
    }

    public function storeFromDocument(Request $request, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        $request = InfrastructureRecord::mergeRequestDocument($request, $document);
        return InfrastructureRecord::storeRecord($request);
    }

    public function storeFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        return $this->storeFromDocument($request, $document);
    }

    public function storeFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        return $this->storeFromAsset($request, $asset);
    }

    public function storeFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        return $this->storeFromDocument($request, $document);
    }

    public function storeFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        $request = $this->determineRouteType($request);
        return $this->storeFromDocument($request, $document);
    }

    // + ===================================
    // + ----------- SHOW METHODS
    // + ===================================
    public function show(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);
        $request = $this->determineRouteType($request);
        return new RecordShowResource($infrastructureRecord);
    }

    public function showFromAsset(InfrastructureAsset $asset, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);
        return new RecordShowResource($infrastructureRecord);
    }  

    public function showFromUnitAsset(InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);
        return new RecordShowResource($infrastructureRecord);
    }

    public function showFromUnitAssetDocument(InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);
        return new RecordShowResource($infrastructureRecord);
    }

    public function showFromAssetDocument(InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);
        return new RecordShowResource($infrastructureRecord);
    }
    
    public function showFromDocument(InfrastructureDocument $document, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);
        return new RecordShowResource($infrastructureRecord);
    }

    public function showFromUnitDocument(InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);
        return new RecordShowResource($infrastructureRecord);
    }

    // + ===================================
    // + ----------- UPDATE METHODS
    // + ===================================
    public function update(Request $request, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('update', $infrastructureRecord);
        $request = $this->determineRouteType($request);
        $request->validate([]);
        return InfrastructureRecord::updateRecord($request, $infrastructureRecord);
    }

    // + ===================================
    // + ----------- DESTROY METHODS
    // + ===================================
    public function destroy(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('delete', $infrastructureRecord);
        $request = $this->determineRouteType($request);
        return InfrastructureRecord::deleteRecord($infrastructureRecord);
    }


    // + ===================================
    // + ----------- DESTROY METHODS
    // + ===================================
    public function restore(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('restore', $infrastructureRecord);
        $request = $this->determineRouteType($request);
        return InfrastructureRecord::restoreRecord($infrastructureRecord);
    }

    // + ===================================
    // + ----------- FORCE DESTROY METHODS
    // + ===================================
    public function forceDelete(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('destroy', $infrastructureRecord);
        $request = $this->determineRouteType($request);
        return InfrastructureRecord::destroyRecord($infrastructureRecord);
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
