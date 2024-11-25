<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureDocumentStnk;
use Module\Infrastructure\Http\Resources\DocumentStnkCollection;
use Module\Infrastructure\Http\Resources\DocumentStnkShowResource;

class InfrastructureDocumentStnkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocumentStnk::class);

        return new DocumentStnkCollection(
            InfrastructureDocumentStnk::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureDocumentStnk::class);

        $request->validate([]);

        return InfrastructureDocumentStnk::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentStnk $infrastructureDocumentStnk
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocumentStnk $infrastructureDocumentStnk)
    {
        Gate::authorize('show', $infrastructureDocumentStnk);

        return new DocumentStnkShowResource($infrastructureDocumentStnk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentStnk $infrastructureDocumentStnk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocumentStnk $infrastructureDocumentStnk)
    {
        Gate::authorize('update', $infrastructureDocumentStnk);

        $request->validate([]);

        return InfrastructureDocumentStnk::updateRecord($request, $infrastructureDocumentStnk);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentStnk $infrastructureDocumentStnk
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocumentStnk $infrastructureDocumentStnk)
    {
        Gate::authorize('delete', $infrastructureDocumentStnk);

        return InfrastructureDocumentStnk::deleteRecord($infrastructureDocumentStnk);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentStnk $infrastructureDocumentStnk
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocumentStnk $infrastructureDocumentStnk)
    {
        Gate::authorize('restore', $infrastructureDocumentStnk);

        return InfrastructureDocumentStnk::restoreRecord($infrastructureDocumentStnk);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentStnk $infrastructureDocumentStnk
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocumentStnk $infrastructureDocumentStnk)
    {
        Gate::authorize('destroy', $infrastructureDocumentStnk);

        return InfrastructureDocumentStnk::destroyRecord($infrastructureDocumentStnk);
    }
}
