<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Http\Resources\RecordNoteUsedCollection;
use Module\Infrastructure\Http\Resources\RecordNoteUsedShowResource;

use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\Infrastructure\Models\InfrastructureRecordNoteUsed;

class InfrastructureRecordNoteUsedController extends Controller
{
    // + =======================================================
    // + ------------------ INDEX METHODS ----------------------
    // + =======================================================

    public function index(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('view', InfrastructureRecordNoteUsed::class);
    
        return new RecordNoteUsedCollection(
            InfrastructureRecordNoteUsed::index( $request, $record, $note ),
            // InfrastructureRecordNoteUsed::applyMode($request->mode)
            //     ->filter($request->filters)
            //     ->search($request->findBy)
            //     ->sortBy($request->sortBy)
            //     ->paginate($request->itemsPerPage)
        );
    }

    // + =======================================================
    // + ------------------ STORE METHODS ----------------------
    // + =======================================================

    public function store(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('create', InfrastructureRecordNoteUsed::class);

        $request->validate( 
            InfrastructureRecordNoteUsed::mapStoreRequest($request, $record, $note) 
        );

        return InfrastructureRecordNoteUsed::storeRecord($request);
    }

    // + =======================================================
    // + ------------------ SHOW METHODS ----------------------
    // + =======================================================

    public function show(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {
        Gate::authorize('show', $used);
        return new RecordNoteUsedShowResource($used);
    }

    // + =======================================================
    // + ----------------- UPDATE METHODS ----------------------
    // + =======================================================

    public function update(Request $request, InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('update', $infrastructureRecordNoteUsed);

        $request->validate([]);

        return InfrastructureRecordNoteUsed::updateRecord($request, $infrastructureRecordNoteUsed);
    }

    // + =======================================================
    // + ---------------- DESTROY METHODS ----------------------
    // + =======================================================

    public function destroy(InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('delete', $infrastructureRecordNoteUsed);

        return InfrastructureRecordNoteUsed::deleteRecord($infrastructureRecordNoteUsed);
    }

    // + =======================================================
    // + ---------------- RESTORE METHODS ----------------------
    // + =======================================================

    public function restore(InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('restore', $infrastructureRecordNoteUsed);

        return InfrastructureRecordNoteUsed::restoreRecord($infrastructureRecordNoteUsed);
    }

    // + =======================================================
    // + ------------------ FORCE METHODS ----------------------
    // + =======================================================

    public function forceDelete(InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('destroy', $infrastructureRecordNoteUsed);

        return InfrastructureRecordNoteUsed::destroyRecord($infrastructureRecordNoteUsed);
    }
}
