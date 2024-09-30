<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureMaintenanceRecord;
use Module\Infrastructure\Http\Resources\MaintenanceRecordCollection;
use Module\Infrastructure\Http\Resources\MaintenanceRecordShowResource;

class InfrastructureMaintenanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenanceRecord::class);

        return new MaintenanceRecordCollection(
            InfrastructureMaintenanceRecord::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureMaintenanceRecord::class);

        $request->validate([]);

        return InfrastructureMaintenanceRecord::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord)
    {
        Gate::authorize('show', $infrastructureMaintenanceRecord);

        return new MaintenanceRecordShowResource($infrastructureMaintenanceRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord)
    {
        Gate::authorize('update', $infrastructureMaintenanceRecord);

        $request->validate([]);

        return InfrastructureMaintenanceRecord::updateRecord($request, $infrastructureMaintenanceRecord);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord)
    {
        Gate::authorize('delete', $infrastructureMaintenanceRecord);

        return InfrastructureMaintenanceRecord::deleteRecord($infrastructureMaintenanceRecord);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord)
    {
        Gate::authorize('restore', $infrastructureMaintenanceRecord);

        return InfrastructureMaintenanceRecord::restoreRecord($infrastructureMaintenanceRecord);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenanceRecord $infrastructureMaintenanceRecord)
    {
        Gate::authorize('destroy', $infrastructureMaintenanceRecord);

        return InfrastructureMaintenanceRecord::destroyRecord($infrastructureMaintenanceRecord);
    }
}
