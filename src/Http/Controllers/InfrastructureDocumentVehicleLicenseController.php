<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense;
use Module\Infrastructure\Http\Resources\DocumentVehicleLicenseCollection;
use Module\Infrastructure\Http\Resources\DocumentVehicleLicenseShowResource;

class InfrastructureDocumentVehicleLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocumentVehicleLicense::class);

        return new DocumentVehicleLicenseCollection(
            InfrastructureDocumentVehicleLicense::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureDocumentVehicleLicense::class);

        $request->validate([]);

        return InfrastructureDocumentVehicleLicense::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense)
    {
        Gate::authorize('show', $infrastructureDocumentVehicleLicense);

        return new DocumentVehicleLicenseShowResource($infrastructureDocumentVehicleLicense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense)
    {
        Gate::authorize('update', $infrastructureDocumentVehicleLicense);

        $request->validate([]);

        return InfrastructureDocumentVehicleLicense::updateRecord($request, $infrastructureDocumentVehicleLicense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense)
    {
        Gate::authorize('delete', $infrastructureDocumentVehicleLicense);

        return InfrastructureDocumentVehicleLicense::deleteRecord($infrastructureDocumentVehicleLicense);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense)
    {
        Gate::authorize('restore', $infrastructureDocumentVehicleLicense);

        return InfrastructureDocumentVehicleLicense::restoreRecord($infrastructureDocumentVehicleLicense);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocumentVehicleLicense $infrastructureDocumentVehicleLicense)
    {
        Gate::authorize('destroy', $infrastructureDocumentVehicleLicense);

        return InfrastructureDocumentVehicleLicense::destroyRecord($infrastructureDocumentVehicleLicense);
    }
}
