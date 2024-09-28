<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetTax;
use Module\Infrastructure\Http\Resources\AssetTaxCollection;
use Module\Infrastructure\Http\Resources\AssetTaxShowResource;

class InfrastructureAssetTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetTax::class);

        return new AssetTaxCollection(
            InfrastructureAssetTax::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetTax::class);

        $request->validate([]);

        return InfrastructureAssetTax::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTax $infrastructureAssetTax
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetTax $infrastructureAssetTax)
    {
        Gate::authorize('show', $infrastructureAssetTax);

        return new AssetTaxShowResource($infrastructureAssetTax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTax $infrastructureAssetTax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetTax $infrastructureAssetTax)
    {
        Gate::authorize('update', $infrastructureAssetTax);

        $request->validate([]);

        return InfrastructureAssetTax::updateRecord($request, $infrastructureAssetTax);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTax $infrastructureAssetTax
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetTax $infrastructureAssetTax)
    {
        Gate::authorize('delete', $infrastructureAssetTax);

        return InfrastructureAssetTax::deleteRecord($infrastructureAssetTax);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTax $infrastructureAssetTax
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetTax $infrastructureAssetTax)
    {
        Gate::authorize('restore', $infrastructureAssetTax);

        return InfrastructureAssetTax::restoreRecord($infrastructureAssetTax);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTax $infrastructureAssetTax
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetTax $infrastructureAssetTax)
    {
        Gate::authorize('destroy', $infrastructureAssetTax);

        return InfrastructureAssetTax::destroyRecord($infrastructureAssetTax);
    }
}
