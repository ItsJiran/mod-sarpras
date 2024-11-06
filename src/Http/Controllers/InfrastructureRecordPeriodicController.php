<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureRecordPeriodic;
use Module\Infrastructure\Http\Resources\RecordPeriodicCollection;
use Module\Infrastructure\Http\Resources\RecordPeriodicShowResource;

class InfrastructureRecordPeriodicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureRecordPeriodic::class);

        return new RecordPeriodicCollection(
            InfrastructureRecordPeriodic::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureRecordPeriodic::class);

        $request->validate([]);

        return InfrastructureRecordPeriodic::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordPeriodic $infrastructureRecordPeriodic
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureRecordPeriodic $infrastructureRecordPeriodic)
    {
        Gate::authorize('show', $infrastructureRecordPeriodic);

        return new RecordPeriodicShowResource($infrastructureRecordPeriodic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureRecordPeriodic $infrastructureRecordPeriodic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureRecordPeriodic $infrastructureRecordPeriodic)
    {
        Gate::authorize('update', $infrastructureRecordPeriodic);

        $request->validate([]);

        return InfrastructureRecordPeriodic::updateRecord($request, $infrastructureRecordPeriodic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordPeriodic $infrastructureRecordPeriodic
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureRecordPeriodic $infrastructureRecordPeriodic)
    {
        Gate::authorize('delete', $infrastructureRecordPeriodic);

        return InfrastructureRecordPeriodic::deleteRecord($infrastructureRecordPeriodic);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordPeriodic $infrastructureRecordPeriodic
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureRecordPeriodic $infrastructureRecordPeriodic)
    {
        Gate::authorize('restore', $infrastructureRecordPeriodic);

        return InfrastructureRecordPeriodic::restoreRecord($infrastructureRecordPeriodic);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordPeriodic $infrastructureRecordPeriodic
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureRecordPeriodic $infrastructureRecordPeriodic)
    {
        Gate::authorize('destroy', $infrastructureRecordPeriodic);

        return InfrastructureRecordPeriodic::destroyRecord($infrastructureRecordPeriodic);
    }
}
