<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureRecordNoteUsed;
use Module\Infrastructure\Http\Resources\RecordNoteUsedCollection;
use Module\Infrastructure\Http\Resources\RecordNoteUsedShowResource;

class InfrastructureRecordNoteUsedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureRecordNoteUsed::class);

        return new RecordNoteUsedCollection(
            InfrastructureRecordNoteUsed::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureRecordNoteUsed::class);

        $request->validate([]);

        return InfrastructureRecordNoteUsed::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('show', $infrastructureRecordNoteUsed);

        return new RecordNoteUsedShowResource($infrastructureRecordNoteUsed);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('update', $infrastructureRecordNoteUsed);

        $request->validate([]);

        return InfrastructureRecordNoteUsed::updateRecord($request, $infrastructureRecordNoteUsed);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('delete', $infrastructureRecordNoteUsed);

        return InfrastructureRecordNoteUsed::deleteRecord($infrastructureRecordNoteUsed);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('restore', $infrastructureRecordNoteUsed);

        return InfrastructureRecordNoteUsed::restoreRecord($infrastructureRecordNoteUsed);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('destroy', $infrastructureRecordNoteUsed);

        return InfrastructureRecordNoteUsed::destroyRecord($infrastructureRecordNoteUsed);
    }
}
