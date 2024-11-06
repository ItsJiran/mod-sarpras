<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Http\Resources\TaxRecordUsedCollection;
use Module\Infrastructure\Http\Resources\TaxRecordUsedShowResource;

use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureTaxRecordUsed;
use Module\Infrastructure\Models\InfrastructureTaxRecord;
use Module\Infrastructure\Models\InfrastructureTax;

class InfrastructureTaxRecordUsedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('view', InfrastructureTaxRecordUsed::class);

        return new TaxRecordUsedCollection(
            InfrastructureTaxRecordUsed::index( $request, $tax, $record )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record)
    {
        Gate::authorize('create', InfrastructureTaxRecordUsed::class);

        $request->validate( 
            InfrastructureTaxRecordUsed::mapStoreRequest($request, $tax, $record) 
        );

        return InfrastructureTaxRecordUsed::storeRecord($request, $tax, $record);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record, InfrastructureTaxRecordUsed $used)
    {
        Gate::authorize('show', $used);

        return new TaxRecordUsedShowResource($request, $used);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTax $tax, InfrastructureTaxRecord $record, InfrastructureTaxRecordUsed $model)
    {
        Gate::authorize('update', $infrastructureTaxRecordUsed);

        $request->validate(
            InfrastructureTaxRecordUsed::mapUpdateRequest($request, $tax, $record) 
        );

        return InfrastructureTaxRecordUsed::updateRecord($request, $model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed)
    {
        Gate::authorize('delete', $infrastructureTaxRecordUsed);

        return InfrastructureTaxRecordUsed::deleteRecord($infrastructureTaxRecordUsed);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed)
    {
        Gate::authorize('restore', $infrastructureTaxRecordUsed);

        return InfrastructureTaxRecordUsed::restoreRecord($infrastructureTaxRecordUsed);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed)
    {
        Gate::authorize('destroy', $infrastructureTaxRecordUsed);

        return InfrastructureTaxRecordUsed::destroyRecord($infrastructureTaxRecordUsed);
    }
}
