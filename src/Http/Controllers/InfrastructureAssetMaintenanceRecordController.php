<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetMaintenanceRecord;
use Module\Infrastructure\Http\Resources\AssetMaintenanceRecordCollection;
use Module\Infrastructure\Http\Resources\AssetMaintenanceRecordShowResource;

class InfrastructureAssetMaintenanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetMaintenanceRecord::class);

        return new AssetMaintenanceRecordCollection(
            InfrastructureAssetMaintenanceRecord::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetMaintenanceRecord::class);

        $request->validate([]);

        return InfrastructureAssetMaintenanceRecord::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord)
    {
        Gate::authorize('show', $infrastructureAssetMaintenanceRecord);

        return new AssetMaintenanceRecordShowResource($infrastructureAssetMaintenanceRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord)
    {
        Gate::authorize('update', $infrastructureAssetMaintenanceRecord);

        $request->validate([]);

        return InfrastructureAssetMaintenanceRecord::updateRecord($request, $infrastructureAssetMaintenanceRecord);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord)
    {
        Gate::authorize('delete', $infrastructureAssetMaintenanceRecord);

        return InfrastructureAssetMaintenanceRecord::deleteRecord($infrastructureAssetMaintenanceRecord);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord)
    {
        Gate::authorize('restore', $infrastructureAssetMaintenanceRecord);

        return InfrastructureAssetMaintenanceRecord::restoreRecord($infrastructureAssetMaintenanceRecord);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord)
    {
        Gate::authorize('destroy', $infrastructureAssetMaintenanceRecord);

        return InfrastructureAssetMaintenanceRecord::destroyRecord($infrastructureAssetMaintenanceRecord);
    }
}
