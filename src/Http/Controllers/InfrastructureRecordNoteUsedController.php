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
        $request = $this->determineRouteType($request);
        return new RecordNoteUsedCollection(
            InfrastructureRecordNoteUsed::index( $request, $record, $note )
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
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

        $isResquestValid = InfrastructureRecordNoteUsed::mapStoreRequestValid($request,$record,$note);
        if ( !is_null($isResquestValid) ) return $isResquestValid;

        return InfrastructureRecordNoteUsed::storeRecord($request, $record, $note);
    }

    // + =======================================================
    // + ------------------ SHOW METHODS ----------------------
    // + =======================================================

    public function show(Request $request, InfrastructureRecord $record, InfrastructureRecordNote $note, InfrastructureRecordNoteUsed $used)
    {
        Gate::authorize('show', InfrastructureRecordNoteUsed::class);
        
        return new RecordNoteUsedShowResource($used);
    }

    // + =======================================================
    // + ----------------- UPDATE METHODS ----------------------
    // + =======================================================

    public function update(Request $request, InfrastructureRecordNoteUsed $infrastructureRecordNoteUsed)
    {
        Gate::authorize('update', $infrastructureRecordNoteUsed);

        $request->validate( 
            InfrastructureRecordNoteUsed::mapUpdateRequest($request, $record, $note) 
        );

        // $isResquestValid = InfrastructureRecordNoteUsed::mapUpdateRequestValid($request,$record,$note);
        // if ( !is_null($isResquestValid) ) return $isResquestValid;

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

        // + ===================================
    // + ----------- UTILITIES
    // + ===================================
    public function determineRouteType(Request $request) : Request
    {
        if ( $this->determineRouteName() == 'tax' )
            $request = InfrastructureRecord::mergeRequestTax($request);
        
        if ( $this->determineRouteName() == 'maintenance' ) 
            $request = InfrastructureRecord::mergeRequestMaintenance($request);

        return $request;
    }
    
    public function determineRouteName()
    {   
        $routeName = \Illuminate\Support\Facades\Route::current()->getName();
        return explode('::',$routeName)[0];
    }
}
