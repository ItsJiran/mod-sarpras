<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureMaintenanceUsedDocument;
use Module\Infrastructure\Http\Resources\MaintenanceUsedDocumentCollection;
use Module\Infrastructure\Http\Resources\MaintenanceUsedDocumentShowResource;

class InfrastructureMaintenanceUsedDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenanceUsedDocument::class);

        return new MaintenanceUsedDocumentCollection(
            InfrastructureMaintenanceUsedDocument::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureMaintenanceUsedDocument::class);

        $request->validate([]);

        return InfrastructureMaintenanceUsedDocument::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument)
    {
        Gate::authorize('show', $infrastructureMaintenanceUsedDocument);

        return new MaintenanceUsedDocumentShowResource($infrastructureMaintenanceUsedDocument);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument)
    {
        Gate::authorize('update', $infrastructureMaintenanceUsedDocument);

        $request->validate([]);

        return InfrastructureMaintenanceUsedDocument::updateRecord($request, $infrastructureMaintenanceUsedDocument);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument)
    {
        Gate::authorize('delete', $infrastructureMaintenanceUsedDocument);

        return InfrastructureMaintenanceUsedDocument::deleteRecord($infrastructureMaintenanceUsedDocument);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument)
    {
        Gate::authorize('restore', $infrastructureMaintenanceUsedDocument);

        return InfrastructureMaintenanceUsedDocument::restoreRecord($infrastructureMaintenanceUsedDocument);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenanceUsedDocument $infrastructureMaintenanceUsedDocument)
    {
        Gate::authorize('destroy', $infrastructureMaintenanceUsedDocument);

        return InfrastructureMaintenanceUsedDocument::destroyRecord($infrastructureMaintenanceUsedDocument);
    }
}
