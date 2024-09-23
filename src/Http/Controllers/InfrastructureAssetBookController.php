<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetBook;
use Module\Infrastructure\Http\Resources\AssetBookCollection;
use Module\Infrastructure\Http\Resources\AssetBookShowResource;

class InfrastructureAssetBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetBook::class);

        return new AssetBookCollection(
            InfrastructureAssetBook::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetBook::class);

        $request->validate([]);

        return InfrastructureAssetBook::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBook $infrastructureAssetBook
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetBook $infrastructureAssetBook)
    {
        Gate::authorize('show', $infrastructureAssetBook);

        return new AssetBookShowResource($infrastructureAssetBook);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBook $infrastructureAssetBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetBook $infrastructureAssetBook)
    {
        Gate::authorize('update', $infrastructureAssetBook);

        $request->validate([]);

        return InfrastructureAssetBook::updateRecord($request, $infrastructureAssetBook);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBook $infrastructureAssetBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetBook $infrastructureAssetBook)
    {
        Gate::authorize('delete', $infrastructureAssetBook);

        return InfrastructureAssetBook::deleteRecord($infrastructureAssetBook);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBook $infrastructureAssetBook
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetBook $infrastructureAssetBook)
    {
        Gate::authorize('restore', $infrastructureAssetBook);

        return InfrastructureAssetBook::restoreRecord($infrastructureAssetBook);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetBook $infrastructureAssetBook
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetBook $infrastructureAssetBook)
    {
        Gate::authorize('destroy', $infrastructureAssetBook);

        return InfrastructureAssetBook::destroyRecord($infrastructureAssetBook);
    }
}
