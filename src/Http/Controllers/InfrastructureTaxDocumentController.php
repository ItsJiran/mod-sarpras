<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTaxDocument;
use Module\Infrastructure\Http\Resources\TaxDocumentCollection;
use Module\Infrastructure\Http\Resources\TaxDocumentShowResource;

class InfrastructureTaxDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTaxDocument::class);

        return new TaxDocumentCollection(
            InfrastructureTaxDocument::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureTaxDocument::class);

        $request->validate([]);

        return InfrastructureTaxDocument::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxDocument $infrastructureTaxDocument
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTaxDocument $infrastructureTaxDocument)
    {
        Gate::authorize('show', $infrastructureTaxDocument);

        return new TaxDocumentShowResource($infrastructureTaxDocument);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxDocument $infrastructureTaxDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTaxDocument $infrastructureTaxDocument)
    {
        Gate::authorize('update', $infrastructureTaxDocument);

        $request->validate([]);

        return InfrastructureTaxDocument::updateRecord($request, $infrastructureTaxDocument);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxDocument $infrastructureTaxDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTaxDocument $infrastructureTaxDocument)
    {
        Gate::authorize('delete', $infrastructureTaxDocument);

        return InfrastructureTaxDocument::deleteRecord($infrastructureTaxDocument);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxDocument $infrastructureTaxDocument
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTaxDocument $infrastructureTaxDocument)
    {
        Gate::authorize('restore', $infrastructureTaxDocument);

        return InfrastructureTaxDocument::restoreRecord($infrastructureTaxDocument);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxDocument $infrastructureTaxDocument
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTaxDocument $infrastructureTaxDocument)
    {
        Gate::authorize('destroy', $infrastructureTaxDocument);

        return InfrastructureTaxDocument::destroyRecord($infrastructureTaxDocument);
    }
}
