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

        return InfrastructureTaxRecord::storeRecord($request, $tax);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTax $tax, InfrastructureTaxRecord $infrastructureTaxRecord)
    {
        Gate::authorize('show', $infrastructureTaxRecord);

        return new TaxRecordShowResource($infrastructureTaxRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTaxRecord $record, InfrastructureTax $tax)
    {
        Gate::authorize('update', $record);

        $request->validate(  
            InfrastructureTaxRecord::mapUpdateRequest($request, $tax)
        );

        return InfrastructureTaxRecord::updateRecord($request, $record, $tax);
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
