<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureDocumentBPKB;
use Module\Infrastructure\Http\Resources\DocumentBPKBCollection;
use Module\Infrastructure\Http\Resources\DocumentBPKBShowResource;

class InfrastructureDocumentBPKBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocumentBPKB::class);

        return new DocumentBPKBCollection(
            InfrastructureDocumentBPKB::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureDocumentBPKB::class);

        $request->validate([]);

        return InfrastructureDocumentBPKB::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBPKB $infrastructureDocumentBPKB
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocumentBPKB $infrastructureDocumentBPKB)
    {
        Gate::authorize('show', $infrastructureDocumentBPKB);

        return new DocumentBPKBShowResource($infrastructureDocumentBPKB);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBPKB $infrastructureDocumentBPKB
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocumentBPKB $infrastructureDocumentBPKB)
    {
        Gate::authorize('update', $infrastructureDocumentBPKB);

        $request->validate([]);

        return InfrastructureDocumentBPKB::updateRecord($request, $infrastructureDocumentBPKB);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBPKB $infrastructureDocumentBPKB
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocumentBPKB $infrastructureDocumentBPKB)
    {
        Gate::authorize('delete', $infrastructureDocumentBPKB);

        return InfrastructureDocumentBPKB::deleteRecord($infrastructureDocumentBPKB);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBPKB $infrastructureDocumentBPKB
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocumentBPKB $infrastructureDocumentBPKB)
    {
        Gate::authorize('restore', $infrastructureDocumentBPKB);

        return InfrastructureDocumentBPKB::restoreRecord($infrastructureDocumentBPKB);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBPKB $infrastructureDocumentBPKB
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocumentBPKB $infrastructureDocumentBPKB)
    {
        Gate::authorize('destroy', $infrastructureDocumentBPKB);

        return InfrastructureDocumentBPKB::destroyRecord($infrastructureDocumentBPKB);
    }
}
