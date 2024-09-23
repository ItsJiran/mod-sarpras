<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Http\Resources\AssetCollection;
use Module\Infrastructure\Http\Resources\AssetShowResource;

class InfrastructureAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAsset::class);

        return new AssetCollection(
            InfrastructureAsset::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAsset::class);

        $request->validate([]);

        return InfrastructureAsset::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('show', $infrastructureAsset);

        return new AssetShowResource($infrastructureAsset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('update', $infrastructureAsset);

        $request->validate([]);

        return InfrastructureAsset::updateRecord($request, $infrastructureAsset);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('delete', $infrastructureAsset);

        return InfrastructureAsset::deleteRecord($infrastructureAsset);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('restore', $infrastructureAsset);

        return InfrastructureAsset::restoreRecord($infrastructureAsset);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('destroy', $infrastructureAsset);

        return InfrastructureAsset::destroyRecord($infrastructureAsset);
    }
}
