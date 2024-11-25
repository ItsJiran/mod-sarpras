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

    // + ===========================================
    // + ----------- STORE METHODS
    // + ===========================================

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

        $isResquestValid = InfrastructureDocument::mapStoreRequestValid($request);
        if ( !is_null($isResquestValid) ) return $isResquestValid;

        return InfrastructureDocument::storeRecord($request, $type_model_class);
    }


    public function storeFromAsset(Request $request, InfrastructureAsset $asset)
    {
        $request->merge([ 'asset' => $asset ]);

        if( !isset($request->unit) || !isset($request->unit['id']) )
            $request->merge([ 'unit' => $asset->unit ]);
    
        return $this->store($request);
    }


    public function storeFromUnitAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        $request->merge([ 'unit' => $unit ]);
        return $this->storeFromAsset($request, $asset);
    }


    public function storeFromUnit(Request $request, InfrastructureUnit $unit)
    {
        $request->merge([ 'unit' => $unit ]);
        return $this->store($request);
    }

    // + ===========================================
    // + ----------- SHOW METHODS
    // + ===========================================


    public function show(InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('show', $infrastructureDocument);
        return new DocumentShowResource($infrastructureDocument);
    }

    public function showFromAsset(InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->show($document);
    }


    public function showFromUnit(InfrastructureUnit $unit = null, InfrastructureDocument $document)
    {
        return $this->show($document);
    }


    public function showFromUnitAsset(InfrastructureUnit $unit = null, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->show($document);
    }

    // + ===========================================
    // + ----------- UPDATE METHODS
    // + ===========================================

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

        $isResquestValid = InfrastructureDocument::mapUpdateRequestValid($request, $infrastructureDocument);
        if ( !is_null($isResquestValid) ) return $isResquestValid;

        return InfrastructureDocument::updateRecord($request, $infrastructureDocument);
    }

    public function updateFromAsset(Request $request,  InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->update($request, $document);
    }

    public function updateFromUnitAsset(Request $request, InfrastructureUnit $unit = null, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->update($request, $document);
    }

    public function updateFromUnit(Request $request, InfrastructureUnit $unit = null, InfrastructureDocument $document)
    {
        return $this->update($request, $document);
    }

    // + ===========================================
    // + ----------- DESTROY METHODS
    // + ===========================================

    public function destroy(Request $request, InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('delete', $infrastructureDocument);

        $isResquestValid = InfrastructureDocument::mapDeleteRequestValid($request, $infrastructureDocument);
        if ( !is_null($isResquestValid) ) return $isResquestValid;

        return InfrastructureDocument::deleteRecord($infrastructureDocument);
    }

    public function destroyFromAsset(Request $request,  InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->destroy($request, $document);
    }

    public function destroyFromUnitAsset(Request $request, InfrastructureUnit $unit = null, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->destroy($request, $document);
    }

    public function destroyFromUnit(Request $request, InfrastructureUnit $unit = null, InfrastructureDocument $document)
    {
        return $this->destroy($request, $document);
    }

    // + ===========================================
    // + ----------- RESTORE METHODS
    // + ===========================================

    public function restore(Request $request, InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('restore', $infrastructureDocument);

        $isResquestValid = InfrastructureDocument::mapDeleteRequestValid($request, $infrastructureDocument);
        if ( !is_null($isResquestValid) ) return $isResquestValid;

        return InfrastructureDocument::restoreRecord($infrastructureDocument);
    }

    public function restoreFromAsset(Request $request,  InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->restore($request,$document);
    }

    public function restoreFromUnitAsset(Request $request, InfrastructureUnit $unit = null, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->restore($request,$document);
    }

    public function restoreFromUnit(Request $request, InfrastructureUnit $unit = null, InfrastructureDocument $document)
    {
        return $this->restore($request,$document);
    }

    // + ===========================================
    // + ----------- FORCEDELEETE METHODS
    // + ===========================================


    public function forceDelete(Request $request, InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('destroy', $infrastructureDocument);

        $isResquestValid = InfrastructureDocument::mapForceDeleteRequestValid($request, $infrastructureDocument);
        if ( !is_null($isResquestValid) ) return $isResquestValid;

        return InfrastructureDocument::destroyRecord($infrastructureDocument);
    }

    public function forceDeleteFromAsset(Request $request,  InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->forceDelete($request, $document);
    }

    public function forceDeleteFromUnitAsset(Request $request, InfrastructureUnit $unit = null, InfrastructureAsset $asset, InfrastructureDocument $document)
    {
        return $this->forceDelete($request, $document);
    }

    public function forceDeleteFromUnit(Request $request, InfrastructureUnit $unit = null, InfrastructureDocument $document)
    {
        return $this->forceDelete($request, $document);
    }

    // + ===========================================
    // + ----------- MAP COMBOS METHODS
    // + ===========================================

    public function mapCombosOnlyUnit(Request $request, InfrastructureUnit $unit)
    {
        return response()->json(InfrastructureDocument::mapCombosOnlyUnit($request),200);
    }

    public function mapCombosOnlyAsset(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        return response()->json(InfrastructureDocument::mapCombosOnlyAsset($request),200);
    }


}
