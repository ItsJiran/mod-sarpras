<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTaxRecordUsed;
use Module\Infrastructure\Http\Resources\TaxRecordUsedCollection;
use Module\Infrastructure\Http\Resources\TaxRecordUsedShowResource;

class InfrastructureTaxRecordUsedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTaxRecordUsed::class);

        return new TaxRecordUsedCollection(
            InfrastructureTaxRecordUsed::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureTaxRecordUsed::class);

        $request->validate([]);

        return InfrastructureTaxRecordUsed::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed)
    {
        Gate::authorize('show', $infrastructureTaxRecordUsed);

        return new TaxRecordUsedShowResource($infrastructureTaxRecordUsed);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTaxRecordUsed $infrastructureTaxRecordUsed)
    {
        Gate::authorize('update', $infrastructureTaxRecordUsed);

        $request->validate([]);

        return InfrastructureTaxRecordUsed::updateRecord($request, $infrastructureTaxRecordUsed);
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
