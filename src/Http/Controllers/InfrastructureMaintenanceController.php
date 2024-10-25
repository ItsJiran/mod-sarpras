<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Http\Resources\MaintenanceCollection;
use Module\Infrastructure\Http\Resources\MaintenanceShowResource;

use Module\Infrastructure\Models\InfrastructureMaintenance;
use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureUnit;

class InfrastructureMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenance::class);

        return new MaintenanceCollection(
            InfrastructureMaintenance::applyMode($request->mode)
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
        return new MaintenanceCollection(
            $unit->maintenances()
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
        return new MaintenanceCollection(
            $asset->maintenances()
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
    public function indexFromDocument(Request $request, InfrastructureDocument $document){        
        return new MaintenanceCollection(
            $document->maintenances()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create', InfrastructureMaintenance::class);

        $request->validate( InfrastructureMaintenance::mapStoreRequestValidation($request) );

        return InfrastructureMaintenance::storeRecord($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function storeFromAsset(Request $request, InfrastructureAsset $asset)
    {
        Gate::authorize('create', InfrastructureMaintenance::class);

        $request = InfrastructureMaintenance::mergeRequestAsset($request, $asset);

        return InfrastructureMaintenance::storeRecord($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromDocument(Request $request, InfrastructureDocument $document)
    {
        Gate::authorize('create', InfrastructureMaintenance::class);

        $request = InfrastructureMaintenance::mergeRequestDocument($request, $document);

        return InfrastructureMaintenance::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenance $infrastructureMaintenance)
    {
        Gate::authorize('show', $infrastructureMaintenance);

        return new MaintenanceShowResource($infrastructureMaintenance);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function showFromDocument(InfrastructureDocument $document, InfrastructureMaintenance $maintenance)
    {
        Gate::authorize('show', $maintenance);
        return new MaintenanceShowResource($maintenance);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function showFromAsset(InfrastructureAsset $asset, InfrastructureMaintenance $maintenance)
    {
        Gate::authorize('show', $maintenance);
        return new MaintenanceShowResource($maintenance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenance $infrastructureMaintenance)
    {
        Gate::authorize('update', $infrastructureMaintenance);

        $request->validate( InfrastructureMaintenance::mapUpdateRequestValidation($request) );

        return InfrastructureMaintenance::updateRecord($request, $infrastructureMaintenance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function updateFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureMaintenance $maintenance)    
    {   
        Gate::authorize('update', $maintenance);
        return $this->update($request, $maintenance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function updateFromDocument(Request $request, InfrastructureDocument $document, InfrastructureMaintenance $maintenance)    
    {   
        Gate::authorize('update', $maintenance);
        return $this->update($request, $maintenance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenance $infrastructureMaintenance)
    {
        Gate::authorize('delete', $infrastructureMaintenance);

        return InfrastructureMaintenance::deleteRecord($infrastructureMaintenance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroyFromAsset(Request $request, InfrastructureAsset $asset, InfrastructureMaintenance $maintenance)    
    {   
        Gate::authorize('delete', $maintenance);
        return $this->destroy($maintenance);
    }

    /**
     * destroy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroyFromDocument(Request $request, InfrastructureDocument $document, InfrastructureMaintenance $maintenance)    
    {   
        Gate::authorize('delete', $maintenance);
        return $this->destroy($maintenance);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenance $infrastructureMaintenance)
    {
        Gate::authorize('restore', $infrastructureMaintenance);

        return InfrastructureMaintenance::restoreRecord($infrastructureMaintenance);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenance $infrastructureMaintenance
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenance $infrastructureMaintenance)
    {
        Gate::authorize('destroy', $infrastructureMaintenance);

        return InfrastructureMaintenance::destroyRecord($infrastructureMaintenance);
    }
}
