<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetMaintenance;
use Module\Infrastructure\Http\Resources\AssetMaintenanceCollection;
use Module\Infrastructure\Http\Resources\AssetMaintenanceShowResource;

class InfrastructureAssetMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetMaintenance::class);

        return new AssetMaintenanceCollection(
            InfrastructureAssetMaintenance::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetMaintenance::class);

        $request->validate([]);

        return InfrastructureAssetMaintenance::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenance $infrastructureAssetMaintenance
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetMaintenance $infrastructureAssetMaintenance)
    {
        Gate::authorize('show', $infrastructureAssetMaintenance);

        return new AssetMaintenanceShowResource($infrastructureAssetMaintenance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenance $infrastructureAssetMaintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetMaintenance $infrastructureAssetMaintenance)
    {
        Gate::authorize('update', $infrastructureAssetMaintenance);

        $request->validate([]);

        return InfrastructureAssetMaintenance::updateRecord($request, $infrastructureAssetMaintenance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenance $infrastructureAssetMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetMaintenance $infrastructureAssetMaintenance)
    {
        Gate::authorize('delete', $infrastructureAssetMaintenance);

        return InfrastructureAssetMaintenance::deleteRecord($infrastructureAssetMaintenance);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenance $infrastructureAssetMaintenance
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetMaintenance $infrastructureAssetMaintenance)
    {
        Gate::authorize('restore', $infrastructureAssetMaintenance);

        return InfrastructureAssetMaintenance::restoreRecord($infrastructureAssetMaintenance);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetMaintenance $infrastructureAssetMaintenance
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetMaintenance $infrastructureAssetMaintenance)
    {
        Gate::authorize('destroy', $infrastructureAssetMaintenance);

        return InfrastructureAssetMaintenance::destroyRecord($infrastructureAssetMaintenance);
    }
}
