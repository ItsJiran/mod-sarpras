<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetDocumentInfo;
use Module\Infrastructure\Http\Resources\AssetDocumentInfoCollection;
use Module\Infrastructure\Http\Resources\AssetDocumentInfoShowResource;

class InfrastructureAssetDocumentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetDocumentInfo::class);

        return new AssetDocumentInfoCollection(
            InfrastructureAssetDocumentInfo::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetDocumentInfo::class);

        $request->validate([]);

        return InfrastructureAssetDocumentInfo::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo)
    {
        Gate::authorize('show', $infrastructureAssetDocumentInfo);

        return new AssetDocumentInfoShowResource($infrastructureAssetDocumentInfo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo)
    {
        Gate::authorize('update', $infrastructureAssetDocumentInfo);

        $request->validate([]);

        return InfrastructureAssetDocumentInfo::updateRecord($request, $infrastructureAssetDocumentInfo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo)
    {
        Gate::authorize('delete', $infrastructureAssetDocumentInfo);

        return InfrastructureAssetDocumentInfo::deleteRecord($infrastructureAssetDocumentInfo);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo)
    {
        Gate::authorize('restore', $infrastructureAssetDocumentInfo);

        return InfrastructureAssetDocumentInfo::restoreRecord($infrastructureAssetDocumentInfo);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetDocumentInfo $infrastructureAssetDocumentInfo)
    {
        Gate::authorize('destroy', $infrastructureAssetDocumentInfo);

        return InfrastructureAssetDocumentInfo::destroyRecord($infrastructureAssetDocumentInfo);
    }
}
