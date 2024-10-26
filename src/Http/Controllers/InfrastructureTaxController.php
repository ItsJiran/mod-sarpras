<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureTax;
use Module\Infrastructure\Http\Resources\TaxCollection;
use Module\Infrastructure\Http\Resources\TaxShowResource;

use Module\Infrastructure\Models\InfrastructureMaintenance;
use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureUnit;

class InfrastructureTaxController extends Controller
{

    // +================================================
    // +-------------------- INDEX METHODS
    // +================================================

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnit(Request $request, InfrastructureUnit $unit){        
        return new MaintenanceCollection(
            $unit->taxes()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromAsset(Request $request, InfrastructureAsset $asset){        
        return new MaintenanceCollection(
            $asset->taxes()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset){
        return $this->indexFromAsset($request, $asset);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromDocument(Request $request, InfrastructureDocument $document){        
        return new MaintenanceCollection(
            $document->taxes()
            ->applyMode($request->mode)
            ->filter($request->filters)
            ->search($request->findBy)
            ->sortBy($request->sortBy)
            ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromAssetDocument(Request $request, InfrastructureAsset $asset, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnitDocument(Request $request, InfrastructureUnit $unit, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnitAssetDocument(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset, InfrastructureDocument $document){
        return $this->indexFromDocument($request, $document);
    }
    
    // +================================================
    // +-------------------- STORE METHODS
    // +================================================

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

    // +================================================
    // +-------------------- SHOW METHODS
    // +================================================

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

    // +================================================
    // +-------------------- UPDATE METHODS
    // +================================================

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

    // +================================================
    // +-------------------- DESTROY METHODS
    // +================================================

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

    // +================================================
    // +-------------------- RESTORE METHODS
    // +================================================

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

    // +================================================
    // +-------------------- DELETE METHODS
    // +================================================

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
