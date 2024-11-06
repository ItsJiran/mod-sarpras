<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Http\Resources\RecordCollection;
use Module\Infrastructure\Http\Resources\RecordShowResource;

use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Models\InfrastructureRecord;
use Module\Infrastructure\Models\InfrastructureRecordNote;

class InfrastructureRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureRecord::class);

        return new RecordCollection(
            InfrastructureRecord::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureRecord::class);

        $request->validate([]);

        return InfrastructureRecord::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('show', $infrastructureRecord);

        return new RecordShowResource($infrastructureRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('update', $infrastructureRecord);

        $request->validate([]);

        return InfrastructureRecord::updateRecord($request, $infrastructureRecord);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('delete', $infrastructureRecord);

        return InfrastructureRecord::deleteRecord($infrastructureRecord);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('restore', $infrastructureRecord);

        return InfrastructureRecord::restoreRecord($infrastructureRecord);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureRecord $infrastructureRecord
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureRecord $infrastructureRecord)
    {
        Gate::authorize('destroy', $infrastructureRecord);

        return InfrastructureRecord::destroyRecord($infrastructureRecord);
    }
}
