<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetElectronic;
use Module\Infrastructure\Http\Resources\AssetElectronicCollection;
use Module\Infrastructure\Http\Resources\AssetElectronicShowResource;

class InfrastructureAssetElectronicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetElectronic::class);

        return new AssetElectronicCollection(
            InfrastructureAssetElectronic::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetElectronic::class);

        $request->validate([]);

        return InfrastructureAssetElectronic::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetElectronic $infrastructureAssetElectronic
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetElectronic $infrastructureAssetElectronic)
    {
        Gate::authorize('show', $infrastructureAssetElectronic);

        return new AssetElectronicShowResource($infrastructureAssetElectronic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetElectronic $infrastructureAssetElectronic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetElectronic $infrastructureAssetElectronic)
    {
        Gate::authorize('update', $infrastructureAssetElectronic);

        $request->validate([]);

        return InfrastructureAssetElectronic::updateRecord($request, $infrastructureAssetElectronic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetElectronic $infrastructureAssetElectronic
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetElectronic $infrastructureAssetElectronic)
    {
        Gate::authorize('delete', $infrastructureAssetElectronic);

        return InfrastructureAssetElectronic::deleteRecord($infrastructureAssetElectronic);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetElectronic $infrastructureAssetElectronic
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetElectronic $infrastructureAssetElectronic)
    {
        Gate::authorize('restore', $infrastructureAssetElectronic);

        return InfrastructureAssetElectronic::restoreRecord($infrastructureAssetElectronic);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetElectronic $infrastructureAssetElectronic
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetElectronic $infrastructureAssetElectronic)
    {
        Gate::authorize('destroy', $infrastructureAssetElectronic);

        return InfrastructureAssetElectronic::destroyRecord($infrastructureAssetElectronic);
    }
}
