<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTaxRecord;
use Module\Infrastructure\Http\Resources\TaxRecordCollection;
use Module\Infrastructure\Http\Resources\TaxRecordShowResource;

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
    public function store(Request $request)
    {
        Gate::authorize('create', InfrastructureTaxRecord::class);

        $request->validate([]);

        return InfrastructureTaxRecord::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecord $infrastructureTaxRecord
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTaxRecord $infrastructureTaxRecord)
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
    public function update(Request $request, InfrastructureTaxRecord $infrastructureTaxRecord)
    {
        Gate::authorize('update', $infrastructureTaxRecord);

        $request->validate([]);

        return InfrastructureTaxRecord::updateRecord($request, $infrastructureTaxRecord);
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