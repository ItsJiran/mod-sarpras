<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureVehicleLicense;
use Module\Infrastructure\Http\Resources\VehicleLicenseCollection;
use Module\Infrastructure\Http\Resources\VehicleLicenseShowResource;

class InfrastructureVehicleLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureVehicleLicense::class);

        return new VehicleLicenseCollection(
            InfrastructureVehicleLicense::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureVehicleLicense::class);

        $request->validate([]);

        return InfrastructureVehicleLicense::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureVehicleLicense $infrastructureVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureVehicleLicense $infrastructureVehicleLicense)
    {
        Gate::authorize('show', $infrastructureVehicleLicense);

        return new VehicleLicenseShowResource($infrastructureVehicleLicense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureVehicleLicense $infrastructureVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureVehicleLicense $infrastructureVehicleLicense)
    {
        Gate::authorize('update', $infrastructureVehicleLicense);

        $request->validate([]);

        return InfrastructureVehicleLicense::updateRecord($request, $infrastructureVehicleLicense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureVehicleLicense $infrastructureVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureVehicleLicense $infrastructureVehicleLicense)
    {
        Gate::authorize('delete', $infrastructureVehicleLicense);

        return InfrastructureVehicleLicense::deleteRecord($infrastructureVehicleLicense);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureVehicleLicense $infrastructureVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureVehicleLicense $infrastructureVehicleLicense)
    {
        Gate::authorize('restore', $infrastructureVehicleLicense);

        return InfrastructureVehicleLicense::restoreRecord($infrastructureVehicleLicense);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureVehicleLicense $infrastructureVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureVehicleLicense $infrastructureVehicleLicense)
    {
        Gate::authorize('destroy', $infrastructureVehicleLicense);

        return InfrastructureVehicleLicense::destroyRecord($infrastructureVehicleLicense);
    }
}
