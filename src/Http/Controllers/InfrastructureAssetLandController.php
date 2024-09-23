<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetLand;
use Module\Infrastructure\Http\Resources\AssetLandCollection;
use Module\Infrastructure\Http\Resources\AssetLandShowResource;

class InfrastructureAssetLandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetLand::class);

        return new AssetLandCollection(
            InfrastructureAssetLand::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetLand::class);

        $request->validate([]);

        return InfrastructureAssetLand::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetLand $infrastructureAssetLand
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetLand $infrastructureAssetLand)
    {
        Gate::authorize('show', $infrastructureAssetLand);

        return new AssetLandShowResource($infrastructureAssetLand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetLand $infrastructureAssetLand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetLand $infrastructureAssetLand)
    {
        Gate::authorize('update', $infrastructureAssetLand);

        $request->validate([]);

        return InfrastructureAssetLand::updateRecord($request, $infrastructureAssetLand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetLand $infrastructureAssetLand
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetLand $infrastructureAssetLand)
    {
        Gate::authorize('delete', $infrastructureAssetLand);

        return InfrastructureAssetLand::deleteRecord($infrastructureAssetLand);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetLand $infrastructureAssetLand
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetLand $infrastructureAssetLand)
    {
        Gate::authorize('restore', $infrastructureAssetLand);

        return InfrastructureAssetLand::restoreRecord($infrastructureAssetLand);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetLand $infrastructureAssetLand
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetLand $infrastructureAssetLand)
    {
        Gate::authorize('destroy', $infrastructureAssetLand);

        return InfrastructureAssetLand::destroyRecord($infrastructureAssetLand);
    }
}
