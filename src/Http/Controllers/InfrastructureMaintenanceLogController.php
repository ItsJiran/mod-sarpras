<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureMaintenanceLog;
use Module\Infrastructure\Http\Resources\MaintenanceLogCollection;
use Module\Infrastructure\Http\Resources\MaintenanceLogShowResource;

class InfrastructureMaintenanceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenanceLog::class);

        return new MaintenanceLogCollection(
            InfrastructureMaintenanceLog::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureMaintenanceLog::class);

        $request->validate([]);

        return InfrastructureMaintenanceLog::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceLog $infrastructureMaintenanceLog
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenanceLog $infrastructureMaintenanceLog)
    {
        Gate::authorize('show', $infrastructureMaintenanceLog);

        return new MaintenanceLogShowResource($infrastructureMaintenanceLog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceLog $infrastructureMaintenanceLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenanceLog $infrastructureMaintenanceLog)
    {
        Gate::authorize('update', $infrastructureMaintenanceLog);

        $request->validate([]);

        return InfrastructureMaintenanceLog::updateRecord($request, $infrastructureMaintenanceLog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceLog $infrastructureMaintenanceLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenanceLog $infrastructureMaintenanceLog)
    {
        Gate::authorize('delete', $infrastructureMaintenanceLog);

        return InfrastructureMaintenanceLog::deleteRecord($infrastructureMaintenanceLog);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceLog $infrastructureMaintenanceLog
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenanceLog $infrastructureMaintenanceLog)
    {
        Gate::authorize('restore', $infrastructureMaintenanceLog);

        return InfrastructureMaintenanceLog::restoreRecord($infrastructureMaintenanceLog);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceLog $infrastructureMaintenanceLog
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenanceLog $infrastructureMaintenanceLog)
    {
        Gate::authorize('destroy', $infrastructureMaintenanceLog);

        return InfrastructureMaintenanceLog::destroyRecord($infrastructureMaintenanceLog);
    }
}
