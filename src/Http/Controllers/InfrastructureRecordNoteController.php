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

    public function store(Request $request, InfrastructureRecord $record)
    {
        Gate::authorize('create', InfrastructureRecordNote::class);

        dd($record);

        $request->validate( InfrastructureRecordNote::mapStoreRequest($request, $record) );
        $isResponseValid = InfrastructureRecordNote::mapStoreRequestValid($request, $record);
        
        if ( !is_null($isResponseValid) ) return $isResponseValid;
        return InfrastructureRecordNote::storeRecord($request, $record);
    }

    public function show(InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('show', $infrastructureRecordNote);

        return new RecordNoteShowResource($infrastructureRecordNote);
    }

    public function update(Request $request, InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('update', $infrastructureRecordNote);

        $request->validate([]);

        return InfrastructureRecordNote::updateRecord($request, $infrastructureRecordNote);
    }

    public function destroy(InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('delete', $infrastructureRecordNote);

        return InfrastructureRecordNote::deleteRecord($infrastructureRecordNote);
    }

    public function restore(InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('restore', $infrastructureRecordNote);

        return InfrastructureRecordNote::restoreRecord($infrastructureRecordNote);
    }

    public function forceDelete(InfrastructureRecordNote $infrastructureRecordNote)
    {
        Gate::authorize('destroy', $infrastructureRecordNote);

        return InfrastructureRecordNote::destroyRecord($infrastructureRecordNote);
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
