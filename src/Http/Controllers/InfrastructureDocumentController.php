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
            'status' => [
                'required',
                Rule::in( InfrastructureDocument::mapStatus() )
            ],
            'documentable_type_key' => [
                'required',
                Rule::in( InfrastructureDocument::mapTypeKeyClass() )
            ],
        ]);

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
        Gate::authorize('create', InfrastructureDocument::class);

        $request->merge([ 'asset_id' => $asset->id ]);

        return $this->store($request);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureDocument $infrastructureDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureDocument $infrastructureDocument)
    {
        Gate::authorize('update', $infrastructureDocument);

        $request->validate([]);

        return InfrastructureDocument::updateRecord($request, $infrastructureDocument);
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
}
