<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Module\Infrastructure\Http\Resources\MaintenanceDocumentCollection;
use Module\Infrastructure\Http\Resources\MaintenanceDocumentShowResource;

class InfrastructureMaintenanceDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenanceDocument::class);

        return new MaintenanceDocumentCollection(
            InfrastructureMaintenanceDocument::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureMaintenanceDocument::class);

        $request->validate([]);

        return InfrastructureMaintenanceDocument::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument)
    {
        Gate::authorize('show', $infrastructureMaintenanceDocument);

        return new MaintenanceDocumentShowResource($infrastructureMaintenanceDocument);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument)
    {
        Gate::authorize('update', $infrastructureMaintenanceDocument);

        $request->validate([]);

        return InfrastructureMaintenanceDocument::updateRecord($request, $infrastructureMaintenanceDocument);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument)
    {
        Gate::authorize('delete', $infrastructureMaintenanceDocument);

        return InfrastructureMaintenanceDocument::deleteRecord($infrastructureMaintenanceDocument);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument)
    {
        Gate::authorize('restore', $infrastructureMaintenanceDocument);

        return InfrastructureMaintenanceDocument::restoreRecord($infrastructureMaintenanceDocument);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenanceDocument $infrastructureMaintenanceDocument)
    {
        Gate::authorize('destroy', $infrastructureMaintenanceDocument);

        return InfrastructureMaintenanceDocument::destroyRecord($infrastructureMaintenanceDocument);
    }
}
