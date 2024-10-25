<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Http\Resources\DocumentCollection;
use Module\Infrastructure\Http\Resources\DocumentShowResource;

use Module\Infrastructure\Models\InfrastructureDocument;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Models\InfrastructureUnit;

class InfrastructureDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureDocument::class);

        return new DocumentCollection(
            InfrastructureDocument::applyMode($request->mode)
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
    public function indexFromAsset(Request $request, InfrastructureAsset $asset)
    {
        Gate::authorize('view', InfrastructureDocument::class);

        return new DocumentCollection(
            $asset->documents()
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
    public function indexFromUnitAsset(Request $request, InfrastructureUnit $unit = null, InfrastructureAsset $asset = null)
    {
        Gate::authorize('view', InfrastructureDocument::class);
        return $this->indexFromAsset($request, $asset);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFromUnit(Request $request, InfrastructureUnit $unit = null)
    {
        Gate::authorize('view', InfrastructureDocument::class);

        return new DocumentCollection(
            $unit->documents()
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
        Gate::authorize('create', InfrastructureDocument::class);

        // request
        $request->validate([
            'name' => 'required|min:3',
            'unit' => 'required',
            'status' => [
                'required',
                Rule::in( InfrastructureDocument::mapStatus() )
            ],
            'documentable_type_key' => [
                'required',
                Rule::in( InfrastructureDocument::mapTypeKeyClass() )
            ],
        ]);

        // additional request validation        
        $request->asset = (object) $request->asset;
        $request->unit = (object) $request->unit;

        $is_asset_exist = isset($request->asset) && isset($request->asset->slug_unit);
        $is_unit_slug_same = $is_asset_exist && $request->unit->slug != $request->asset->slug_unit;

        if ( $is_asset_exist && $is_unit_slug_same ){             
            response()->json([
                'success' => false,
                'message' => 'Slug unit dan slug unit pada asset tidak sama..'
            ], 422);
        }

        // type class
        $map_type_class = InfrastructureDocument::mapTypeClass();
        $type_model_class = $map_type_class[ $request->documentable_type_key ];

        // get request validatoin from the type_model
        $request->validate( $type_model_class::mapStoreValidation() );

        return InfrastructureDocument::storeRecord($request, $type_model_class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromAsset(Request $request, InfrastructureAsset $asset)
    {
        $request->merge([ 'asset' => $asset ]);

        if( !isset($request->unit) || !isset($request->unit['id']) )
            $request->merge([ 'unit' => $asset->unit ]);
    
        return $this->store($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromUnit(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        $request->merge([ 'unit' => $unit ]);
        return $this->storeFromAsset($request, $asset);
    }


    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('show', $infrastructureDocument);

        return new DocumentShowResource($infrastructureDocument);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function showFromAsset(InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        Gate::authorize('show', $document);
        return $this->show($document);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function showFromUnit(InfrastructureUnit $unit = null, InfrastructureDocument $document)
    {
        Gate::authorize('show', $document);
        return $this->show($document);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function showFromUnitAsset(InfrastructureUnit $unit = null, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        Gate::authorize('show', $document);
        return $this->show($document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('update', $infrastructureDocument);

        // request
        $request->validate([
            'name' => 'required|min:3',
            'unit' => 'required',
            'status' => [
                'required',
                Rule::in( InfrastructureDocument::mapStatus() )
            ],
            'documentable_type_key' => [
                'required',
                Rule::in( InfrastructureDocument::mapTypeKeyClass() )
            ],
        ]);

        // additional request validation        
        $request->asset = (object) $request->asset;
        $request->unit = (object) $request->unit;

        $is_asset_exist = isset($request->asset) && isset($request->asset->slug_unit);
        $is_unit_slug_same = $is_asset_exist && $request->unit->slug != $request->asset->slug_unit;

        if ( $is_asset_exist && $is_unit_slug_same ){             
            response()->json([
                'success' => false,
                'message' => 'Slug unit dan slug unit pada asset tidak sama..'
            ], 422);
        }


        return InfrastructureDocument::updateRecord($request, $infrastructureDocument);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function updateFromAsset(Request $request,  InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        Gate::authorize('update', $document);
        return $this->update($request, $document);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function updateFromUnit(Request $request, InfrastructureUnit $unit = null, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        Gate::authorize('update', $document);
        return $this->updateFromAsset($request, $asset,$document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('delete', $infrastructureDocument);

        return InfrastructureDocument::deleteRecord($infrastructureDocument);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('restore', $infrastructureDocument);

        return InfrastructureDocument::restoreRecord($infrastructureDocument);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('destroy', $infrastructureDocument);
        return InfrastructureDocument::destroyRecord($infrastructureDocument);
    }

    /**
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function mapCombosOnlyUnit(Request $request, InfrastructureUnit $unit)
    {
        return response()->json(InfrastructureDocument::mapCombosOnlyUnit($request),200);
    }

    /**
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function mapCombosOnlyAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        return response()->json(InfrastructureDocument::mapCombosOnlyAsset($request),200);
    }


}
