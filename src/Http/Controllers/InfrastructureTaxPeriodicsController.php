<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTaxPeriodics;
use Module\Infrastructure\Http\Resources\TaxPeriodicsCollection;
use Module\Infrastructure\Http\Resources\TaxPeriodicsShowResource;

class InfrastructureTaxPeriodicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTaxPeriodics::class);

        return new TaxPeriodicsCollection(
            InfrastructureTaxPeriodics::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureTaxPeriodics::class);

        $request->validate([]);

        return InfrastructureTaxPeriodics::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxPeriodics $infrastructureTaxPeriodics
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTaxPeriodics $infrastructureTaxPeriodics)
    {
        Gate::authorize('show', $infrastructureTaxPeriodics);

        return new TaxPeriodicsShowResource($infrastructureTaxPeriodics);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxPeriodics $infrastructureTaxPeriodics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTaxPeriodics $infrastructureTaxPeriodics)
    {
        Gate::authorize('update', $infrastructureTaxPeriodics);

        $request->validate([]);

        return InfrastructureTaxPeriodics::updateRecord($request, $infrastructureTaxPeriodics);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxPeriodics $infrastructureTaxPeriodics
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTaxPeriodics $infrastructureTaxPeriodics)
    {
        Gate::authorize('delete', $infrastructureTaxPeriodics);

        return InfrastructureTaxPeriodics::deleteRecord($infrastructureTaxPeriodics);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxPeriodics $infrastructureTaxPeriodics
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTaxPeriodics $infrastructureTaxPeriodics)
    {
        Gate::authorize('restore', $infrastructureTaxPeriodics);

        return InfrastructureTaxPeriodics::restoreRecord($infrastructureTaxPeriodics);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxPeriodics $infrastructureTaxPeriodics
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTaxPeriodics $infrastructureTaxPeriodics)
    {
        Gate::authorize('destroy', $infrastructureTaxPeriodics);

        return InfrastructureTaxPeriodics::destroyRecord($infrastructureTaxPeriodics);
    }
}
