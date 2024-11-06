<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\Infrastructure\Http\Resources\RecordNoteCollection;
use Module\Infrastructure\Http\Resources\RecordNoteShowResource;

class InfrastructureRecordNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureRecordNote::class);

        return new RecordNoteCollection(
            InfrastructureRecordNote::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureRecordNote::class);

        $request->validate([]);

        return InfrastructureRecordNote::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNote $infrastructureRecordNote
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('show', $infrastructureRecordNote);

        return new RecordNoteShowResource($infrastructureRecordNote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNote $infrastructureRecordNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('update', $infrastructureRecordNote);

        $request->validate([]);

        return InfrastructureRecordNote::updateRecord($request, $infrastructureRecordNote);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNote $infrastructureRecordNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('delete', $infrastructureRecordNote);

        return InfrastructureRecordNote::deleteRecord($infrastructureRecordNote);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNote $infrastructureRecordNote
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('restore', $infrastructureRecordNote);

        return InfrastructureRecordNote::restoreRecord($infrastructureRecordNote);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNote $infrastructureRecordNote
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('destroy', $infrastructureRecordNote);

        return InfrastructureRecordNote::destroyRecord($infrastructureRecordNote);
    }
}
