<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureDocumentDriverLicense;
use Module\Infrastructure\Http\Resources\DocumentDriverLicenseCollection;
use Module\Infrastructure\Http\Resources\DocumentDriverLicenseShowResource;

class InfrastructureDocumentDriverLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocumentDriverLicense::class);

        return new DocumentDriverLicenseCollection(
            InfrastructureDocumentDriverLicense::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureDocumentDriverLicense::class);

        $request->validate([]);

        return InfrastructureDocumentDriverLicense::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense)
    {
        Gate::authorize('show', $infrastructureDocumentDriverLicense);

        return new DocumentDriverLicenseShowResource($infrastructureDocumentDriverLicense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense)
    {
        Gate::authorize('update', $infrastructureDocumentDriverLicense);

        $request->validate([]);

        return InfrastructureDocumentDriverLicense::updateRecord($request, $infrastructureDocumentDriverLicense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense)
    {
        Gate::authorize('delete', $infrastructureDocumentDriverLicense);

        return InfrastructureDocumentDriverLicense::deleteRecord($infrastructureDocumentDriverLicense);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense)
    {
        Gate::authorize('restore', $infrastructureDocumentDriverLicense);

        return InfrastructureDocumentDriverLicense::restoreRecord($infrastructureDocumentDriverLicense);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocumentDriverLicense $infrastructureDocumentDriverLicense)
    {
        Gate::authorize('destroy', $infrastructureDocumentDriverLicense);

        return InfrastructureDocumentDriverLicense::destroyRecord($infrastructureDocumentDriverLicense);
    }
}
