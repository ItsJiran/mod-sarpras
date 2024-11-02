<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTaxUsedDocument;
use Module\Infrastructure\Http\Resources\TaxUsedDocumentCollection;
use Module\Infrastructure\Http\Resources\TaxUsedDocumentShowResource;

class InfrastructureTaxUsedDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTaxUsedDocument::class);

        return new TaxUsedDocumentCollection(
            InfrastructureTaxUsedDocument::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureTaxUsedDocument::class);

        $request->validate([]);

        return InfrastructureTaxUsedDocument::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument)
    {
        Gate::authorize('show', $infrastructureTaxUsedDocument);

        return new TaxUsedDocumentShowResource($infrastructureTaxUsedDocument);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument)
    {
        Gate::authorize('update', $infrastructureTaxUsedDocument);

        $request->validate([]);

        return InfrastructureTaxUsedDocument::updateRecord($request, $infrastructureTaxUsedDocument);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument)
    {
        Gate::authorize('delete', $infrastructureTaxUsedDocument);

        return InfrastructureTaxUsedDocument::deleteRecord($infrastructureTaxUsedDocument);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument)
    {
        Gate::authorize('restore', $infrastructureTaxUsedDocument);

        return InfrastructureTaxUsedDocument::restoreRecord($infrastructureTaxUsedDocument);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTaxUsedDocument $infrastructureTaxUsedDocument)
    {
        Gate::authorize('destroy', $infrastructureTaxUsedDocument);

        return InfrastructureTaxUsedDocument::destroyRecord($infrastructureTaxUsedDocument);
    }
}
