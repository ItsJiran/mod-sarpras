<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTaxAsset;
use Module\Infrastructure\Http\Resources\TaxAssetCollection;
use Module\Infrastructure\Http\Resources\TaxAssetShowResource;

class InfrastructureTaxAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTaxAsset::class);

        return new TaxAssetCollection(
            InfrastructureTaxAsset::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureTaxAsset::class);

        $request->validate([]);

        return InfrastructureTaxAsset::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxAsset $infrastructureTaxAsset
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTaxAsset $infrastructureTaxAsset)
    {
        Gate::authorize('show', $infrastructureTaxAsset);

        return new TaxAssetShowResource($infrastructureTaxAsset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxAsset $infrastructureTaxAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTaxAsset $infrastructureTaxAsset)
    {
        Gate::authorize('update', $infrastructureTaxAsset);

        $request->validate([]);

        return InfrastructureTaxAsset::updateRecord($request, $infrastructureTaxAsset);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxAsset $infrastructureTaxAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTaxAsset $infrastructureTaxAsset)
    {
        Gate::authorize('delete', $infrastructureTaxAsset);

        return InfrastructureTaxAsset::deleteRecord($infrastructureTaxAsset);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxAsset $infrastructureTaxAsset
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTaxAsset $infrastructureTaxAsset)
    {
        Gate::authorize('restore', $infrastructureTaxAsset);

        return InfrastructureTaxAsset::restoreRecord($infrastructureTaxAsset);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxAsset $infrastructureTaxAsset
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTaxAsset $infrastructureTaxAsset)
    {
        Gate::authorize('destroy', $infrastructureTaxAsset);

        return InfrastructureTaxAsset::destroyRecord($infrastructureTaxAsset);
    }
}
