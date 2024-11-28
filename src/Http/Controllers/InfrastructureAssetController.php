<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Http\Resources\AssetCollection;
use Module\Infrastructure\Http\Resources\AssetShowResource;

use Module\Infrastructure\Models\InfrastructureUnit;

class InfrastructureAssetController extends Controller
{

    // +-----------------------------------------------------
    // +---------------- INDEX METHODS ----------------------

    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureAsset::class);

        return new AssetCollection(
            InfrastructureAsset::applyMode($request->mode)
                ->filter($request->filters)
                ->search($request->findBy)
                ->sortBy($request->sortBy)
                ->paginate($request->itemsPerPage)
        );
    }

    public function indexFromUnit(Request $request, InfrastructureUnit $unit)
    {
        Gate::authorize('view', InfrastructureAsset::class);

        return new AssetCollection(
            $unit->assets()
                ->filter($request->filters)
                ->search($request->findBy)
                ->sortBy($request->sortBy)
                ->paginate($request->itemsPerPage)
        );
    }


    // +-----------------------------------------------------
    // +---------------- STORE METHODS ----------------------

    public function store(Request $request)
    {
        Gate::authorize('create', InfrastructureAsset::class);

        // request
        $request->validate([
            'name' => 'required|min:3',
            'slug_unit' => 'required|exists:human_units,slug',
            'asset_type_key' => [
                'required',
                Rule::in( InfrastructureAsset::mapTypeKeyClass() )
            ],
        ]);

        // type class
        $map_type_class = InfrastructureAsset::mapTypeClass();
        $type_model_class = $map_type_class[ $request->asset_type_key ];

        // get request validatoin from the type_model
        $request->validate( $type_model_class::mapStoreValidation() );

        // hanlding is request vlaid
        $isRequestValid = InfrastructureAsset::mapStoreRequestValid($request);
        if ( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureAsset::storeRecord($request, $type_model_class);
    }

    public function storeFromUnit(Request $request, InfrastructureUnit $unit)
    {
        Gate::authorize('create', InfrastructureAsset::class);

        $request->merge([ 'slug_unit' => $unit->slug ]);

        return $this->store($request);
    }

    // +----------------------------------------------------
    // +---------------- SHOW METHODS ----------------------

    public function show(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('show', $infrastructureAsset);

        return new AssetShowResource($infrastructureAsset);
    }

    public function showFromUnit(InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        Gate::authorize('show', $asset);

        return new AssetShowResource($asset);
    }

    // +----------------------------------------------------
    // +-------------- UPDATE METHODS ----------------------

    public function update(Request $request, InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('update', $infrastructureAsset);

        // request
        $request->validate([
            'name' => 'required|min:3',
            'slug_unit' => 'required|exists:human_units,slug',
            'asset_type_key' => [
                'required',
                Rule::in( InfrastructureAsset::mapTypeKeyClass() )
            ],
        ]);

        // type class
        $map_type_class = InfrastructureAsset::mapTypeClass();
        $type_model_class = $map_type_class[ $request->asset_type_key ];

        // get request validation from the type_model
        $request->validate( $type_model_class::mapUpdateValidation() );

        // is request valid
        $isRequestValid = InfrastructureAsset::mapUpdateRequestValid($request,$infrastructureAsset);
        if ( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureAsset::updateRecord($request, $infrastructureAsset);
    }

    public function updateFromUnit(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        return $this->update($request, $asset);
    }

    // +----------------------------------------------------
    // +------------- DESRTOY METHODS ----------------------

    public function destroy(Request $request, InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('delete', $infrastructureAsset);

        // is request valid
        $isRequestValid = InfrastructureAsset::mapDeleteRequestValid($request,$infrastructureAsset);
        if ( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureAsset::deleteRecord($infrastructureAsset);
    }

    public function destroyFromUnit(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        return $this->destroy($request, $asset);
    }

    // +--------------------------------------------------------
    // +------------ FORCE DELETE METHODS ----------------------

    public function restore(Request $request, InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('restore', $infrastructureAsset);

        $isRequestValid = InfrastructureAsset::mapRestoreRequestValid($request,$infrastructureAsset);
        if ( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureAsset::restoreRecord($infrastructureAsset);
    }

    public function restoreFromUnit(Request $request, InfrastructureUnit $unit, InfrastructureAsset $model)
    {
        return $this->restore($request, $model);
    }

    // +--------------------------------------------------------
    // +------------ FORCE DELETE METHODS ----------------------

    public function forceDelete(Request $request, InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('destroy', $infrastructureAsset);

        $isRequestValid = InfrastructureAsset::mapForceDeleteRequestValid($request,$infrastructureAsset);
        if ( !is_null($isRequestValid) ) return $isRequestValid;

        return InfrastructureAsset::destroyRecord($infrastructureAsset);
    }

    public function forceDeleteFromUnit(Request $request, InfrastructureUnit $unit, InfrastructureAsset $model)
    {
        return $this->forceDelete($request,$model);
    }

    // +----------------------------------------------------
    // +------------ REFRENCE METHODS ----------------------

    public function refAsset(InfrastructureUnit $unit, Request $request)
    {
        $assets = $unit->assets;
        $assets_slugs = [];

        foreach($assets as $key => $value){
            $assets_slugs[$value->slug] = $value;
        }

        return response()->json([
            'assets_slugs' => (array) $assets_slugs,
            'assets' => (array) $assets,
        ],200);
    }

    public function refAssetType(InfrastructureUnit $unit, $asset_type, Request $request)
    {
        $type_model_class = InfrastructureAsset::mapTypeClass()[$asset_type];

        $assets = $unit->assets->where('assetable_type',$type_model_class);
        $array_assets = [];
        $assets_slugs = [];
        $assets_slugs_combos = [];

        foreach($assets as $key => $value){
            $assets_slugs[$value->slug] = $value;
            array_push( $array_assets, $value );
            array_push( $assets_slugs_combos, $value->slug );
        }

        return response()->json([
            'assets_slugs_combos' =>  $assets_slugs_combos,
            'assets_slugs' =>  $assets_slugs,
            'assets' =>  $array_assets,
        ],200);
    }

    public function refType(Request $request)
    {
        return InfrastructureAsset::mapTypeKeyClass();
    }

}
