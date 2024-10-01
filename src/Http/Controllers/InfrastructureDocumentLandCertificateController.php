<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureDocumentLandCertificate;
use Module\Infrastructure\Http\Resources\DocumentLandCertificateCollection;
use Module\Infrastructure\Http\Resources\DocumentLandCertificateShowResource;

class InfrastructureDocumentLandCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocumentLandCertificate::class);

        return new DocumentLandCertificateCollection(
            InfrastructureDocumentLandCertificate::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureDocumentLandCertificate::class);

        $request->validate([]);

        return InfrastructureDocumentLandCertificate::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate)
    {
        Gate::authorize('show', $infrastructureDocumentLandCertificate);

        return new DocumentLandCertificateShowResource($infrastructureDocumentLandCertificate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate)
    {
        Gate::authorize('update', $infrastructureDocumentLandCertificate);

        $request->validate([]);

        return InfrastructureDocumentLandCertificate::updateRecord($request, $infrastructureDocumentLandCertificate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate)
    {
        Gate::authorize('delete', $infrastructureDocumentLandCertificate);

        return InfrastructureDocumentLandCertificate::deleteRecord($infrastructureDocumentLandCertificate);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate)
    {
        Gate::authorize('restore', $infrastructureDocumentLandCertificate);

        return InfrastructureDocumentLandCertificate::restoreRecord($infrastructureDocumentLandCertificate);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocumentLandCertificate $infrastructureDocumentLandCertificate)
    {
        Gate::authorize('destroy', $infrastructureDocumentLandCertificate);

        return InfrastructureDocumentLandCertificate::destroyRecord($infrastructureDocumentLandCertificate);
    }
}
