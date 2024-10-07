<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureMaintenanceRecordUsed;
use Module\Infrastructure\Http\Resources\MaintenanceRecordUsedCollection;
use Module\Infrastructure\Http\Resources\MaintenanceRecordUsedShowResource;

class InfrastructureMaintenanceRecordUsedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenanceRecordUsed::class);

        return new MaintenanceRecordUsedCollection(
            InfrastructureMaintenanceRecordUsed::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureMaintenanceRecordUsed::class);

        $request->validate([]);

        return InfrastructureMaintenanceRecordUsed::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed)
    {
        Gate::authorize('show', $infrastructureMaintenanceRecordUsed);

        return new MaintenanceRecordUsedShowResource($infrastructureMaintenanceRecordUsed);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed)
    {
        Gate::authorize('update', $infrastructureMaintenanceRecordUsed);

        $request->validate([]);

        return InfrastructureMaintenanceRecordUsed::updateRecord($request, $infrastructureMaintenanceRecordUsed);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed)
    {
        Gate::authorize('delete', $infrastructureMaintenanceRecordUsed);

        return InfrastructureMaintenanceRecordUsed::deleteRecord($infrastructureMaintenanceRecordUsed);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed)
    {
        Gate::authorize('restore', $infrastructureMaintenanceRecordUsed);

        return InfrastructureMaintenanceRecordUsed::restoreRecord($infrastructureMaintenanceRecordUsed);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenanceRecordUsed $infrastructureMaintenanceRecordUsed)
    {
        Gate::authorize('destroy', $infrastructureMaintenanceRecordUsed);

        return InfrastructureMaintenanceRecordUsed::destroyRecord($infrastructureMaintenanceRecordUsed);
    }
}
