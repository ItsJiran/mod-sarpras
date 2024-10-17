<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureMaintenancePeriodic;
use Module\Infrastructure\Http\Resources\MaintenancePeriodicCollection;
use Module\Infrastructure\Http\Resources\MaintenancePeriodicShowResource;

class InfrastructureMaintenancePeriodicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenancePeriodic::class);

        return new MaintenancePeriodicCollection(
            InfrastructureMaintenancePeriodic::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureMaintenancePeriodic::class);

        $request->validate([]);

        return InfrastructureMaintenancePeriodic::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic)
    {
        Gate::authorize('show', $infrastructureMaintenancePeriodic);

        return new MaintenancePeriodicShowResource($infrastructureMaintenancePeriodic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic)
    {
        Gate::authorize('update', $infrastructureMaintenancePeriodic);

        $request->validate([]);

        return InfrastructureMaintenancePeriodic::updateRecord($request, $infrastructureMaintenancePeriodic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic)
    {
        Gate::authorize('delete', $infrastructureMaintenancePeriodic);

        return InfrastructureMaintenancePeriodic::deleteRecord($infrastructureMaintenancePeriodic);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic)
    {
        Gate::authorize('restore', $infrastructureMaintenancePeriodic);

        return InfrastructureMaintenancePeriodic::restoreRecord($infrastructureMaintenancePeriodic);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenancePeriodic $infrastructureMaintenancePeriodic)
    {
        Gate::authorize('destroy', $infrastructureMaintenancePeriodic);

        return InfrastructureMaintenancePeriodic::destroyRecord($infrastructureMaintenancePeriodic);
    }
}
