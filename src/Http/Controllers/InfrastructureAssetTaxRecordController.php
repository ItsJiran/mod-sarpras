<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetTaxRecord;
use Module\Infrastructure\Http\Resources\AssetTaxRecordCollection;
use Module\Infrastructure\Http\Resources\AssetTaxRecordShowResource;

class InfrastructureAssetTaxRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetTaxRecord::class);

        return new AssetTaxRecordCollection(
            InfrastructureAssetTaxRecord::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetTaxRecord::class);

        $request->validate([]);

        return InfrastructureAssetTaxRecord::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord)
    {
        Gate::authorize('show', $infrastructureAssetTaxRecord);

        return new AssetTaxRecordShowResource($infrastructureAssetTaxRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord)
    {
        Gate::authorize('update', $infrastructureAssetTaxRecord);

        $request->validate([]);

        return InfrastructureAssetTaxRecord::updateRecord($request, $infrastructureAssetTaxRecord);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord)
    {
        Gate::authorize('delete', $infrastructureAssetTaxRecord);

        return InfrastructureAssetTaxRecord::deleteRecord($infrastructureAssetTaxRecord);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord)
    {
        Gate::authorize('restore', $infrastructureAssetTaxRecord);

        return InfrastructureAssetTaxRecord::restoreRecord($infrastructureAssetTaxRecord);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetTaxRecord $infrastructureAssetTaxRecord)
    {
        Gate::authorize('destroy', $infrastructureAssetTaxRecord);

        return InfrastructureAssetTaxRecord::destroyRecord($infrastructureAssetTaxRecord);
    }
}
