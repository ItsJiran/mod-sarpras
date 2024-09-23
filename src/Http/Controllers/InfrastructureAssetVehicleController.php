<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetVehicle;
use Module\Infrastructure\Http\Resources\AssetVehicleCollection;
use Module\Infrastructure\Http\Resources\AssetVehicleShowResource;

class InfrastructureAssetVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetVehicle::class);

        return new AssetVehicleCollection(
            InfrastructureAssetVehicle::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetVehicle::class);

        $request->validate([]);

        return InfrastructureAssetVehicle::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetVehicle $infrastructureAssetVehicle
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetVehicle $infrastructureAssetVehicle)
    {
        Gate::authorize('show', $infrastructureAssetVehicle);

        return new AssetVehicleShowResource($infrastructureAssetVehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetVehicle $infrastructureAssetVehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetVehicle $infrastructureAssetVehicle)
    {
        Gate::authorize('update', $infrastructureAssetVehicle);

        $request->validate([]);

        return InfrastructureAssetVehicle::updateRecord($request, $infrastructureAssetVehicle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetVehicle $infrastructureAssetVehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetVehicle $infrastructureAssetVehicle)
    {
        Gate::authorize('delete', $infrastructureAssetVehicle);

        return InfrastructureAssetVehicle::deleteRecord($infrastructureAssetVehicle);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetVehicle $infrastructureAssetVehicle
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetVehicle $infrastructureAssetVehicle)
    {
        Gate::authorize('restore', $infrastructureAssetVehicle);

        return InfrastructureAssetVehicle::restoreRecord($infrastructureAssetVehicle);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetVehicle $infrastructureAssetVehicle
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetVehicle $infrastructureAssetVehicle)
    {
        Gate::authorize('destroy', $infrastructureAssetVehicle);

        return InfrastructureAssetVehicle::destroyRecord($infrastructureAssetVehicle);
    }
}
