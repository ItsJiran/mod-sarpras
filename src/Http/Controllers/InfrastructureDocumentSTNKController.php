<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureDocumentSTNK;
use Module\Infrastructure\Http\Resources\DocumentSTNKCollection;
use Module\Infrastructure\Http\Resources\DocumentSTNKShowResource;

class InfrastructureDocumentSTNKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocumentSTNK::class);

        return new DocumentSTNKCollection(
            InfrastructureDocumentSTNK::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureDocumentSTNK::class);

        $request->validate([]);

        return InfrastructureDocumentSTNK::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentSTNK $infrastructureDocumentSTNK
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocumentSTNK $infrastructureDocumentSTNK)
    {
        Gate::authorize('show', $infrastructureDocumentSTNK);

        return new DocumentSTNKShowResource($infrastructureDocumentSTNK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentSTNK $infrastructureDocumentSTNK
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocumentSTNK $infrastructureDocumentSTNK)
    {
        Gate::authorize('update', $infrastructureDocumentSTNK);

        $request->validate([]);

        return InfrastructureDocumentSTNK::updateRecord($request, $infrastructureDocumentSTNK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentSTNK $infrastructureDocumentSTNK
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocumentSTNK $infrastructureDocumentSTNK)
    {
        Gate::authorize('delete', $infrastructureDocumentSTNK);

        return InfrastructureDocumentSTNK::deleteRecord($infrastructureDocumentSTNK);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentSTNK $infrastructureDocumentSTNK
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocumentSTNK $infrastructureDocumentSTNK)
    {
        Gate::authorize('restore', $infrastructureDocumentSTNK);

        return InfrastructureDocumentSTNK::restoreRecord($infrastructureDocumentSTNK);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentSTNK $infrastructureDocumentSTNK
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocumentSTNK $infrastructureDocumentSTNK)
    {
        Gate::authorize('destroy', $infrastructureDocumentSTNK);

        return InfrastructureDocumentSTNK::destroyRecord($infrastructureDocumentSTNK);
    }
}
