<?php

namespace Module\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Module\Infrastructure\Http\Resources\RecordNoteCollection;
use Module\Infrastructure\Http\Resources\RecordNoteShowResource;

use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureUnit;

class InfrastructureRecordNoteController extends Controller
{
 
    public function index(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('view', InfrastructureRecordNote::class);

        return new RecordNoteCollection(
            $record->notes()
                ->applyMode($request->mode)
                ->filter($request->filters)
                ->search($request->findBy)
                ->sortBy($request->sortBy)
                ->paginate($request->itemsPerPage)
        );
    }

    // + ================================================ +
    // + -------------- SHOW METHODS -------------------- +

    public function store(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('create', InfrastructureRecordNote::class);

        $request->validate( InfrastructureRecordNote::mapStoreRequest($request, $record) );
        $isResponseValid = InfrastructureRecordNote::mapStoreRequestValid($request, $record);
        
        if ( !is_null($isResponseValid) ) return $isResponseValid;
        return InfrastructureRecordNote::storeRecord($request, $record);
    }

    // + ================================================ +
    // + -------------- SHOW METHODS -------------------- +

    public function show(InfrastructureRecord $record, InfrastructureRecordNote $note)
    {
        Gate::authorize('show', $note);
        return new RecordNoteShowResource($note);
    }

    // + ================================================== +
    // + -------------- UPDATE METHODS -------------------- +

    public function update(Request $request, InfrastructureRecordNote $note)
    {
        Gate::authorize('update', $note);

        $request->validate([]);

        return InfrastructureRecordNote::updateRecord($request, $note);
    }

    // + ================================================== +
    // + -------------- DESTROY METHODS -------------------- +

    public function destroy(InfrastructureRecordNote $note)
    {
        Gate::authorize('delete', $note);

        return InfrastructureRecordNote::deleteRecord($note);
    }

    // + ================================================== +
    // + -------------- RETORE METHODS -------------------- +

    public function restore(InfrastructureRecordNote $note)
    {
        Gate::authorize('restore', $note);

        return InfrastructureRecordNote::restoreRecord($note);
    }

    // + ================================================== +
    // + -------------- FORCEDDEL METHODS -------------------- +


    public function forceDelete(InfrastructureRecordNote $note)
    {
        Gate::authorize('destroy', $note);

        return InfrastructureRecordNote::destroyRecord($note);
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
