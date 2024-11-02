<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTaxUsedAsset;
use Module\Infrastructure\Http\Resources\TaxUsedAssetCollection;
use Module\Infrastructure\Http\Resources\TaxUsedAssetShowResource;

class InfrastructureTaxUsedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTaxUsedAsset::class);

        return new TaxUsedAssetCollection(
            InfrastructureTaxUsedAsset::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureTaxUsedAsset::class);

        $request->validate([]);

        return InfrastructureTaxUsedAsset::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset)
    {
        Gate::authorize('show', $infrastructureTaxUsedAsset);

        return new TaxUsedAssetShowResource($infrastructureTaxUsedAsset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset)
    {
        Gate::authorize('update', $infrastructureTaxUsedAsset);

        $request->validate([]);

        return InfrastructureTaxUsedAsset::updateRecord($request, $infrastructureTaxUsedAsset);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset)
    {
        Gate::authorize('delete', $infrastructureTaxUsedAsset);

        return InfrastructureTaxUsedAsset::deleteRecord($infrastructureTaxUsedAsset);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset)
    {
        Gate::authorize('restore', $infrastructureTaxUsedAsset);

        return InfrastructureTaxUsedAsset::restoreRecord($infrastructureTaxUsedAsset);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTaxUsedAsset $infrastructureTaxUsedAsset)
    {
        Gate::authorize('destroy', $infrastructureTaxUsedAsset);

        return InfrastructureTaxUsedAsset::destroyRecord($infrastructureTaxUsedAsset);
    }
}
