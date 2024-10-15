<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Module\Infrastructure\Http\Resources\MaintenanceAssetCollection;
use Module\Infrastructure\Http\Resources\MaintenanceAssetShowResource;

class InfrastructureMaintenanceAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureMaintenanceAsset::class);

        return new MaintenanceAssetCollection(
            InfrastructureMaintenanceAsset::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureMaintenanceAsset::class);

        $request->validate([]);

        return InfrastructureMaintenanceAsset::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset)
    {
        Gate::authorize('show', $infrastructureMaintenanceAsset);

        return new MaintenanceAssetShowResource($infrastructureMaintenanceAsset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset)
    {
        Gate::authorize('update', $infrastructureMaintenanceAsset);

        $request->validate([]);

        return InfrastructureMaintenanceAsset::updateRecord($request, $infrastructureMaintenanceAsset);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset)
    {
        Gate::authorize('delete', $infrastructureMaintenanceAsset);

        return InfrastructureMaintenanceAsset::deleteRecord($infrastructureMaintenanceAsset);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset)
    {
        Gate::authorize('restore', $infrastructureMaintenanceAsset);

        return InfrastructureMaintenanceAsset::restoreRecord($infrastructureMaintenanceAsset);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureMaintenanceAsset $infrastructureMaintenanceAsset)
    {
        Gate::authorize('destroy', $infrastructureMaintenanceAsset);

        return InfrastructureMaintenanceAsset::destroyRecord($infrastructureMaintenanceAsset);
    }
}
