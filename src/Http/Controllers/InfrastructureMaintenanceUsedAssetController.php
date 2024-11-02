<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureMaintenanceUsedAsset;
use Module\Infrastructure\Http\Resources\MaintenanceUsedAssetCollection;
use Module\Infrastructure\Http\Resources\MaintenanceUsedAssetShowResource;

class InfrastructureMaintenanceUsedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenanceUsedAsset::class);

        return new MaintenanceUsedAssetCollection(
            InfrastructureMaintenanceUsedAsset::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureMaintenanceUsedAsset::class);

        $request->validate([]);

        return InfrastructureMaintenanceUsedAsset::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset)
    {
        Gate::authorize('show', $infrastructureMaintenanceUsedAsset);

        return new MaintenanceUsedAssetShowResource($infrastructureMaintenanceUsedAsset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset)
    {
        Gate::authorize('update', $infrastructureMaintenanceUsedAsset);

        $request->validate([]);

        return InfrastructureMaintenanceUsedAsset::updateRecord($request, $infrastructureMaintenanceUsedAsset);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset)
    {
        Gate::authorize('delete', $infrastructureMaintenanceUsedAsset);

        return InfrastructureMaintenanceUsedAsset::deleteRecord($infrastructureMaintenanceUsedAsset);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset)
    {
        Gate::authorize('restore', $infrastructureMaintenanceUsedAsset);

        return InfrastructureMaintenanceUsedAsset::restoreRecord($infrastructureMaintenanceUsedAsset);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenanceUsedAsset $infrastructureMaintenanceUsedAsset)
    {
        Gate::authorize('destroy', $infrastructureMaintenanceUsedAsset);

        return InfrastructureMaintenanceUsedAsset::destroyRecord($infrastructureMaintenanceUsedAsset);
    }
}
