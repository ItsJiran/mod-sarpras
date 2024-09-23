<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetFurniture;
use Module\Infrastructure\Http\Resources\AssetFurnitureCollection;
use Module\Infrastructure\Http\Resources\AssetFurnitureShowResource;

class InfrastructureAssetFurnitureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetFurniture::class);

        return new AssetFurnitureCollection(
            InfrastructureAssetFurniture::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetFurniture::class);

        $request->validate([]);

        return InfrastructureAssetFurniture::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetFurniture $infrastructureAssetFurniture
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetFurniture $infrastructureAssetFurniture)
    {
        Gate::authorize('show', $infrastructureAssetFurniture);

        return new AssetFurnitureShowResource($infrastructureAssetFurniture);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetFurniture $infrastructureAssetFurniture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetFurniture $infrastructureAssetFurniture)
    {
        Gate::authorize('update', $infrastructureAssetFurniture);

        $request->validate([]);

        return InfrastructureAssetFurniture::updateRecord($request, $infrastructureAssetFurniture);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetFurniture $infrastructureAssetFurniture
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetFurniture $infrastructureAssetFurniture)
    {
        Gate::authorize('delete', $infrastructureAssetFurniture);

        return InfrastructureAssetFurniture::deleteRecord($infrastructureAssetFurniture);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetFurniture $infrastructureAssetFurniture
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetFurniture $infrastructureAssetFurniture)
    {
        Gate::authorize('restore', $infrastructureAssetFurniture);

        return InfrastructureAssetFurniture::restoreRecord($infrastructureAssetFurniture);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetFurniture $infrastructureAssetFurniture
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetFurniture $infrastructureAssetFurniture)
    {
        Gate::authorize('destroy', $infrastructureAssetFurniture);

        return InfrastructureAssetFurniture::destroyRecord($infrastructureAssetFurniture);
    }
}
