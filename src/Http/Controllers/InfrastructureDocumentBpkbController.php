<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureDocumentBpkb;
use Module\Infrastructure\Http\Resources\DocumentBpkbCollection;
use Module\Infrastructure\Http\Resources\DocumentBpkbShowResource;

class InfrastructureDocumentBpkbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocumentBpkb::class);

        return new DocumentBpkbCollection(
            InfrastructureDocumentBpkb::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureDocumentBpkb::class);

        $request->validate([]);

        return InfrastructureDocumentBpkb::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBpkb $infrastructureDocumentBpkb
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocumentBpkb $infrastructureDocumentBpkb)
    {
        Gate::authorize('show', $infrastructureDocumentBpkb);

        return new DocumentBpkbShowResource($infrastructureDocumentBpkb);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBpkb $infrastructureDocumentBpkb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocumentBpkb $infrastructureDocumentBpkb)
    {
        Gate::authorize('update', $infrastructureDocumentBpkb);

        $request->validate([]);

        return InfrastructureDocumentBpkb::updateRecord($request, $infrastructureDocumentBpkb);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBpkb $infrastructureDocumentBpkb
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocumentBpkb $infrastructureDocumentBpkb)
    {
        Gate::authorize('delete', $infrastructureDocumentBpkb);

        return InfrastructureDocumentBpkb::deleteRecord($infrastructureDocumentBpkb);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBpkb $infrastructureDocumentBpkb
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocumentBpkb $infrastructureDocumentBpkb)
    {
        Gate::authorize('restore', $infrastructureDocumentBpkb);

        return InfrastructureDocumentBpkb::restoreRecord($infrastructureDocumentBpkb);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentBpkb $infrastructureDocumentBpkb
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocumentBpkb $infrastructureDocumentBpkb)
    {
        Gate::authorize('destroy', $infrastructureDocumentBpkb);

        return InfrastructureDocumentBpkb::destroyRecord($infrastructureDocumentBpkb);
    }
}
