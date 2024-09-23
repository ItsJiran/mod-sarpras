<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetDocument;
use Module\Infrastructure\Http\Resources\AssetDocumentCollection;
use Module\Infrastructure\Http\Resources\AssetDocumentShowResource;

class InfrastructureAssetDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetDocument::class);

        return new AssetDocumentCollection(
            InfrastructureAssetDocument::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetDocument::class);

        $request->validate([]);

        return InfrastructureAssetDocument::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocument $infrastructureAssetDocument
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetDocument $infrastructureAssetDocument)
    {
        Gate::authorize('show', $infrastructureAssetDocument);

        return new AssetDocumentShowResource($infrastructureAssetDocument);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocument $infrastructureAssetDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetDocument $infrastructureAssetDocument)
    {
        Gate::authorize('update', $infrastructureAssetDocument);

        $request->validate([]);

        return InfrastructureAssetDocument::updateRecord($request, $infrastructureAssetDocument);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocument $infrastructureAssetDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetDocument $infrastructureAssetDocument)
    {
        Gate::authorize('delete', $infrastructureAssetDocument);

        return InfrastructureAssetDocument::deleteRecord($infrastructureAssetDocument);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocument $infrastructureAssetDocument
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetDocument $infrastructureAssetDocument)
    {
        Gate::authorize('restore', $infrastructureAssetDocument);

        return InfrastructureAssetDocument::restoreRecord($infrastructureAssetDocument);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetDocument $infrastructureAssetDocument
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetDocument $infrastructureAssetDocument)
    {
        Gate::authorize('destroy', $infrastructureAssetDocument);

        return InfrastructureAssetDocument::destroyRecord($infrastructureAssetDocument);
    }
}
