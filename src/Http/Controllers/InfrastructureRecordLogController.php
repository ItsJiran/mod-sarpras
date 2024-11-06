<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureRecordLog;
use Module\Infrastructure\Http\Resources\RecordLogCollection;
use Module\Infrastructure\Http\Resources\RecordLogShowResource;

class InfrastructureRecordLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureRecordLog::class);

        return new RecordLogCollection(
            InfrastructureRecordLog::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureRecordLog::class);

        $request->validate([]);

        return InfrastructureRecordLog::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordLog $infrastructureRecordLog
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureRecordLog $infrastructureRecordLog)
    {
        Gate::authorize('show', $infrastructureRecordLog);

        return new RecordLogShowResource($infrastructureRecordLog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureRecordLog $infrastructureRecordLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureRecordLog $infrastructureRecordLog)
    {
        Gate::authorize('update', $infrastructureRecordLog);

        $request->validate([]);

        return InfrastructureRecordLog::updateRecord($request, $infrastructureRecordLog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordLog $infrastructureRecordLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureRecordLog $infrastructureRecordLog)
    {
        Gate::authorize('delete', $infrastructureRecordLog);

        return InfrastructureRecordLog::deleteRecord($infrastructureRecordLog);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordLog $infrastructureRecordLog
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureRecordLog $infrastructureRecordLog)
    {
        Gate::authorize('restore', $infrastructureRecordLog);

        return InfrastructureRecordLog::restoreRecord($infrastructureRecordLog);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecordLog $infrastructureRecordLog
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureRecordLog $infrastructureRecordLog)
    {
        Gate::authorize('destroy', $infrastructureRecordLog);

        return InfrastructureRecordLog::destroyRecord($infrastructureRecordLog);
    }
}
