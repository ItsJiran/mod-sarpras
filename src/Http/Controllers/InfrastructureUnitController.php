<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\Infrastructure\Http\Resources\UnitCollection;
use Module\Infrastructure\Http\Resources\UnitShowResource;

class InfrastructureUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureUnit::class);

        return new UnitCollection(
            InfrastructureUnit::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureUnit::class);

        $request->validate([]);

        return InfrastructureUnit::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureUnit $infrastructureUnit
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureUnit $infrastructureUnit)
    {
        Gate::authorize('show', $infrastructureUnit);

        return new UnitShowResource($infrastructureUnit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureUnit $infrastructureUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureUnit $infrastructureUnit)
    {
        Gate::authorize('update', $infrastructureUnit);

        $request->validate([]);

        return InfrastructureUnit::updateRecord($request, $infrastructureUnit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureUnit $infrastructureUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureUnit $infrastructureUnit)
    {
        Gate::authorize('delete', $infrastructureUnit);

        return InfrastructureUnit::deleteRecord($infrastructureUnit);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureUnit $infrastructureUnit
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureUnit $infrastructureUnit)
    {
        Gate::authorize('restore', $infrastructureUnit);

        return InfrastructureUnit::restoreRecord($infrastructureUnit);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureUnit $infrastructureUnit
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureUnit $infrastructureUnit)
    {
        Gate::authorize('destroy', $infrastructureUnit);

        return InfrastructureUnit::destroyRecord($infrastructureUnit);
    }
}
