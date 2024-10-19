<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTaxLog;
use Module\Infrastructure\Http\Resources\TaxLogCollection;
use Module\Infrastructure\Http\Resources\TaxLogShowResource;

class InfrastructureTaxLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTaxLog::class);

        return new TaxLogCollection(
            InfrastructureTaxLog::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureTaxLog::class);

        $request->validate([]);

        return InfrastructureTaxLog::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxLog $infrastructureTaxLog
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTaxLog $infrastructureTaxLog)
    {
        Gate::authorize('show', $infrastructureTaxLog);

        return new TaxLogShowResource($infrastructureTaxLog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTaxLog $infrastructureTaxLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTaxLog $infrastructureTaxLog)
    {
        Gate::authorize('update', $infrastructureTaxLog);

        $request->validate([]);

        return InfrastructureTaxLog::updateRecord($request, $infrastructureTaxLog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxLog $infrastructureTaxLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTaxLog $infrastructureTaxLog)
    {
        Gate::authorize('delete', $infrastructureTaxLog);

        return InfrastructureTaxLog::deleteRecord($infrastructureTaxLog);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxLog $infrastructureTaxLog
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTaxLog $infrastructureTaxLog)
    {
        Gate::authorize('restore', $infrastructureTaxLog);

        return InfrastructureTaxLog::restoreRecord($infrastructureTaxLog);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTaxLog $infrastructureTaxLog
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTaxLog $infrastructureTaxLog)
    {
        Gate::authorize('destroy', $infrastructureTaxLog);

        return InfrastructureTaxLog::destroyRecord($infrastructureTaxLog);
    }
}
