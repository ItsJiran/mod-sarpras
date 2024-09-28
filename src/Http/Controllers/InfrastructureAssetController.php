<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\Infrastructure\Http\Resources\AssetCollection;
use Module\Infrastructure\Http\Resources\AssetShowResource;

class InfrastructureAssetController extends Controller
{
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
    public function indexUnits(Request $request)
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
}
