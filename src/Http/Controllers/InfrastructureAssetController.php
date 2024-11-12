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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('show', $infrastructureAsset);

        return new AssetShowResource($infrastructureAsset);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function showFromUnit(InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        Gate::authorize('show', $asset);

        return new AssetShowResource($asset);
    }

    // +----------------------------------------------------
    // +-------------- UPDATE METHODS ----------------------

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
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

        return InfrastructureAsset::updateRecord($request, $infrastructureAsset);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function updateFromUnit(Request $request, InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        Gate::authorize('update', $asset);

        return $this->update($request, $asset);
    }

    // +----------------------------------------------------
    // +------------- DESRTOY METHODS ----------------------

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('delete', $infrastructureAsset);

        return InfrastructureAsset::deleteRecord($infrastructureAsset);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function destroyFromUnit(InfrastructureUnit $unit, InfrastructureAsset $asset)
    {
        Gate::authorize('delete', $asset);

        return $this->destroy($asset);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('restore', $infrastructureAsset);

        return InfrastructureAsset::restoreRecord($infrastructureAsset);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureAsset $infrastructureAsset
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureAsset $infrastructureAsset)
    {
        Gate::authorize('destroy', $infrastructureAsset);

        return InfrastructureAsset::destroyRecord($infrastructureAsset);
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
