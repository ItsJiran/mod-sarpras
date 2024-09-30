<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTax;
use Module\Infrastructure\Http\Resources\TaxCollection;
use Module\Infrastructure\Http\Resources\TaxShowResource;

class InfrastructureTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureTax::class);

        return new TaxCollection(
            InfrastructureTax::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureTax::class);

        $request->validate([]);

        return InfrastructureTax::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTax $infrastructureTax
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureTax $infrastructureTax)
    {
        Gate::authorize('show', $infrastructureTax);

        return new TaxShowResource($infrastructureTax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureTax $infrastructureTax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureTax $infrastructureTax)
    {
        Gate::authorize('update', $infrastructureTax);

        $request->validate([]);

        return InfrastructureTax::updateRecord($request, $infrastructureTax);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTax $infrastructureTax
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureTax $infrastructureTax)
    {
        Gate::authorize('delete', $infrastructureTax);

        return InfrastructureTax::deleteRecord($infrastructureTax);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTax $infrastructureTax
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureTax $infrastructureTax)
    {
        Gate::authorize('restore', $infrastructureTax);

        return InfrastructureTax::restoreRecord($infrastructureTax);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureTax $infrastructureTax
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureTax $infrastructureTax)
    {
        Gate::authorize('destroy', $infrastructureTax);

        return InfrastructureTax::destroyRecord($infrastructureTax);
    }
}
