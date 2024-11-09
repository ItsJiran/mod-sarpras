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

class InfrastructureTaxController extends Controller
{

    // +================================================
    // +-------------------- INDEX METHODS
    // +================================================

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureRecord::class);

        return new RecordCollection(
            InfrastructureRecord::applyMode($request->mode)
                ->filter($request->filters)
                ->search($request->findBy)
                ->sortBy($request->sortBy)
                ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnit(Request $request, InfrastructureUnit $unit){        
        return new RecordCollection(
            $unit->taxes()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromAsset(Request $request, InfrastructureAsset $asset){        
        return new RecordCollection(
            $asset->taxes()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset){
        return $this->indexFromAsset($request, $asset);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromDocument(Request $request, InfrastructureDocument $document){        
        return new RecordCollection(
            $document->taxes()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }
    
    // +================================================
    // +-------------------- STORE METHODS
    // +================================================

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create', InfrastructureRecord::class);

        $request = InfrastructureRecord::mergeRequestTax($request);
        $request->validate( InfrastructureTax::mapStoreRequestValidation($request) );        

        return InfrastructureTax::storeRecord($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromAsset(Request $request, InfrastructureAsset $asset)
    {
        Gate::authorize('create', InfrastructureRecord::class);

        $request = InfrastructureRecord::mergeRequestAsset($request, $asset);

        return InfrastructureRecord::storeRecord($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        return $this->storeFromAsset($request, $asset);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        return $this->storeFromDocument($request, $document);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureRecord::class);
        return $this->storeFromDocument($request, $document);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromDocument(Request $request, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureRecord::class);

        $request = InfrastructureRecord::mergeRequestDocument($request, $document);

        return InfrastructureRecord::storeRecord($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureRecord::class);

        return $this->storeFromDocument($request, $document);
    }

    // +================================================
    // +-------------------- SHOW METHODS
    // +================================================

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);

        return new RecordShowResource($infrastructureRecord);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function showFromDocument(InfrastructureDocument $document, InfrastructureRecord $record)
    {
        Gate::authorize('show', $record);
        return new RecordShowResource($record);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function showFromUnitDocument(InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record)
    {
        Gate::authorize('show', $record);
        return new RecordShowResource($record);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function showFromAsset(InfrastructureAsset $asset, InfrastructureRecord $tax)
    {
        Gate::authorize('show', $tax);
        return new RecordShowResource($tax);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function showFromAssetDocument(InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $tax)
    {
        Gate::authorize('show', $tax);
        return new RecordShowResource($tax);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function showFromUnitAsset(InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $tax)
    {
        Gate::authorize('show', $tax);
        return new RecordShowResource($tax);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function showFromUnitAssetDocument(InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $tax)
    {
        Gate::authorize('show', $tax);
        return new RecordShowResource($tax);
    }

    // +================================================
    // +-------------------- UPDATE METHODS
    // +================================================

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('update', $infrastructureRecord);

        $request->validate( InfrastructureRecord::mapUpdateRequestValidation($request) );        

        return InfrastructureRecord::updateRecord($request, $infrastructureRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function updateFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $tax)    
    {   
        Gate::authorize('update', $tax);
        return $this->update($request, $tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function updateFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $tax)    
    {   
        Gate::authorize('update', $tax);
        return $this->update($request, $tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function updateFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $tax)    
    {   
        Gate::authorize('update', $tax);
        return $this->update($request, $tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function updateFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $tax)    
    {   
        Gate::authorize('update', $tax);
        return $this->update($request, $tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function updateFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $tax)    
    {   
        Gate::authorize('update', $tax);
        return $this->update($request, $tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function updateFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('update', $record);
        return $this->update($request, $record);
    }

    // +================================================
    // +-------------------- DESTROY METHODS
    // +================================================

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('delete', $infrastructureRecord);

        return InfrastructureRecord::deleteRecord($infrastructureRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroyFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        Gate::authorize('delete', $record);
        return $this->destroy($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroyFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureRecord $record)    
    {   
        Gate::authorize('delete', $record);
        return $this->destroy($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroyFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('delete', $record);
        return $this->destroy($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroyFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('delete', $record);
        return $this->destroy($record);
    }

    /**
     * destroy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroyFromDocument(Request $request, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('delete', $record);
        return $this->destroy($record);
    }

    /**
     * destroy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroyFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document, InfrastructureRecord $record)    
    {   
        Gate::authorize('delete', $record);
        return $this->destroy($record);
    }

    // +================================================
    // +-------------------- RESTORE METHODS
    // +================================================

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTax $infrastructureTax)
    {
        Gate::authorize('restore', $infrastructureTax);

        return InfrastructureTax::restoreRecord($infrastructureTax);
    }

    // +================================================
    // +-------------------- DELETE METHODS
    // +================================================

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTax $infrastructureTax
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTax $infrastructureTax)
    {
        Gate::authorize('destroy', $infrastructureTax);

        return InfrastructureTax::destroyRecord($infrastructureTax);
    }
}
