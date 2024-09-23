<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetBookInfo;
use Module\Infrastructure\Http\Resources\AssetBookInfoCollection;
use Module\Infrastructure\Http\Resources\AssetBookInfoShowResource;

class InfrastructureAssetBookInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetBookInfo::class);

        return new AssetBookInfoCollection(
            InfrastructureAssetBookInfo::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetBookInfo::class);

        $request->validate([]);

        return InfrastructureAssetBookInfo::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBookInfo $infrastructureAssetBookInfo
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetBookInfo $infrastructureAssetBookInfo)
    {
        Gate::authorize('show', $infrastructureAssetBookInfo);

        return new AssetBookInfoShowResource($infrastructureAssetBookInfo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBookInfo $infrastructureAssetBookInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetBookInfo $infrastructureAssetBookInfo)
    {
        Gate::authorize('update', $infrastructureAssetBookInfo);

        $request->validate([]);

        return InfrastructureAssetBookInfo::updateRecord($request, $infrastructureAssetBookInfo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBookInfo $infrastructureAssetBookInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetBookInfo $infrastructureAssetBookInfo)
    {
        Gate::authorize('delete', $infrastructureAssetBookInfo);

        return InfrastructureAssetBookInfo::deleteRecord($infrastructureAssetBookInfo);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBookInfo $infrastructureAssetBookInfo
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetBookInfo $infrastructureAssetBookInfo)
    {
        Gate::authorize('restore', $infrastructureAssetBookInfo);

        return InfrastructureAssetBookInfo::restoreRecord($infrastructureAssetBookInfo);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBookInfo $infrastructureAssetBookInfo
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetBookInfo $infrastructureAssetBookInfo)
    {
        Gate::authorize('destroy', $infrastructureAssetBookInfo);

        return InfrastructureAssetBookInfo::destroyRecord($infrastructureAssetBookInfo);
    }
}
