<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureDocumentOther;
use Module\Infrastructure\Http\Resources\DocumentOtherCollection;
use Module\Infrastructure\Http\Resources\DocumentOtherShowResource;

class InfrastructureDocumentOtherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocumentOther::class);

        return new DocumentOtherCollection(
            InfrastructureDocumentOther::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureDocumentOther::class);

        $request->validate([]);

        return InfrastructureDocumentOther::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentOther $infrastructureDocumentOther
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocumentOther $infrastructureDocumentOther)
    {
        Gate::authorize('show', $infrastructureDocumentOther);

        return new DocumentOtherShowResource($infrastructureDocumentOther);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentOther $infrastructureDocumentOther
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocumentOther $infrastructureDocumentOther)
    {
        Gate::authorize('update', $infrastructureDocumentOther);

        $request->validate([]);

        return InfrastructureDocumentOther::updateRecord($request, $infrastructureDocumentOther);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentOther $infrastructureDocumentOther
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocumentOther $infrastructureDocumentOther)
    {
        Gate::authorize('delete', $infrastructureDocumentOther);

        return InfrastructureDocumentOther::deleteRecord($infrastructureDocumentOther);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentOther $infrastructureDocumentOther
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocumentOther $infrastructureDocumentOther)
    {
        Gate::authorize('restore', $infrastructureDocumentOther);

        return InfrastructureDocumentOther::restoreRecord($infrastructureDocumentOther);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocumentOther $infrastructureDocumentOther
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocumentOther $infrastructureDocumentOther)
    {
        Gate::authorize('destroy', $infrastructureDocumentOther);

        return InfrastructureDocumentOther::destroyRecord($infrastructureDocumentOther);
    }
}
