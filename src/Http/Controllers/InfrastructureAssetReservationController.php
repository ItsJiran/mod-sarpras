<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAssetReservation;
use Module\Infrastructure\Http\Resources\AssetReservationCollection;
use Module\Infrastructure\Http\Resources\AssetReservationShowResource;

class InfrastructureAssetReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAssetReservation::class);

        return new AssetReservationCollection(
            InfrastructureAssetReservation::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureAssetReservation::class);

        $request->validate([]);

        return InfrastructureAssetReservation::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetReservation $infrastructureAssetReservation
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAssetReservation $infrastructureAssetReservation)
    {
        Gate::authorize('show', $infrastructureAssetReservation);

        return new AssetReservationShowResource($infrastructureAssetReservation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAssetReservation $infrastructureAssetReservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureAssetReservation $infrastructureAssetReservation)
    {
        Gate::authorize('update', $infrastructureAssetReservation);

        $request->validate([]);

        return InfrastructureAssetReservation::updateRecord($request, $infrastructureAssetReservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetReservation $infrastructureAssetReservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAssetReservation $infrastructureAssetReservation)
    {
        Gate::authorize('delete', $infrastructureAssetReservation);

        return InfrastructureAssetReservation::deleteRecord($infrastructureAssetReservation);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetReservation $infrastructureAssetReservation
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAssetReservation $infrastructureAssetReservation)
    {
        Gate::authorize('restore', $infrastructureAssetReservation);

        return InfrastructureAssetReservation::restoreRecord($infrastructureAssetReservation);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAssetReservation $infrastructureAssetReservation
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAssetReservation $infrastructureAssetReservation)
    {
        Gate::authorize('destroy', $infrastructureAssetReservation);

        return InfrastructureAssetReservation::destroyRecord($infrastructureAssetReservation);
    }
}
