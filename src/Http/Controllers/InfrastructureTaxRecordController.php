<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Http\Resources\TaxRecordCollection;
use Module\Infrastructure\Http\Resources\TaxRecordShowResource;

use Module\Infrastructure\Models\InfrastructureTaxRecord;
use Module\Infrastructure\Models\InfrastructureTax;
use Module\Infrastructure\Models\InfrastructureUnit;

class InfrastructureTaxRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTaxRecord::class);

        return new TaxRecordCollection(
            InfrastructureTaxRecord::applyMode($request->mode)
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
    public function store(Request $request, InfrastructureTax $tax)
    {
        Gate::authorize('create', InfrastructureTaxRecord::class);

        $request->validate(  
            InfrastructureTaxRecord::mapStoreRequest($request, $tax)
        );

        $isResponseValid = InfrastructureTaxRecord::mapStoreRequestValid($request, $tax);

        if ( !is_null($isResponseValid) ) {
            return $isResponseValid;   
        }

        return InfrastructureTaxRecord::storeRecord($request, $tax);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('show', $record);

        return new TaxRecordShowResource($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('update', $record);

        $request->validate(  
            InfrastructureTaxRecord::mapUpdateRequest($request, $tax)
        );

        $isResponseValid = InfrastructureTaxRecord::mapUpdateRequestValid($request, $tax, $record);

        if ( !is_null($isResponseValid) ) {
            return $isResponseValid;   
        }

        return InfrastructureTaxRecord::updateRecord($request, $tax, $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function changeToPending(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('update', $record);

        $isResponseValid = InfrastructureTaxRecord::mapUpdateToPending($request, $tax, $record);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureTaxRecord::changeToPending($request, $tax, $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function changeToDraft(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('update', $record);

        $isResponseValid = InfrastructureTaxRecord::mapUpdateToDraft($request, $tax, $record);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureTaxRecord::toDraft($request, $tax, $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function changeToVerified(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('update', $record);

        $isResponseValid = InfrastructureTaxRecord::mapUpdateToVerified($request, $tax, $record);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureTaxRecord::toVerified($request, $tax, $record);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function changeToUnVerified(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('update', $record);

        $isResponseValid = InfrastructureTaxRecord::mapUpdateToUnVerified($request, $tax, $record);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureTaxRecord::toUnVerified($request, $tax, $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function changeToCancelled(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('update', $record);

        $isResponseValid = InfrastructureTaxRecord::mapUpdateToCancelled($request, $tax, $record);
        if ( !is_null($isResponseValid) ) return $isResponseValid;   
        
        return InfrastructureTaxRecord::toCancelled($request, $tax, $record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTaxRecord $infrastructureTaxRecord)
    {
        Gate::authorize('delete', $infrastructureTaxRecord);

        return InfrastructureTaxRecord::deleteRecord($infrastructureTaxRecord);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTaxRecord $infrastructureTaxRecord)
    {
        Gate::authorize('restore', $infrastructureTaxRecord);

        return InfrastructureTaxRecord::restoreRecord($infrastructureTaxRecord);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTaxRecord $infrastructureTaxRecord)
    {
        Gate::authorize('destroy', $infrastructureTaxRecord);

        return InfrastructureTaxRecord::destroyRecord($infrastructureTaxRecord);
    }
}
