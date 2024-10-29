<?php

namespace Module\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Infrastructure\Models\InfrastructureUser;
use Module\Infrastructure\Http\Resources\UserCollection;
use Module\Infrastructure\Http\Resources\UserShowResource;

class InfrastructureUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', InfrastructureUser::class);

        return new UserCollection(
            InfrastructureUser::applyMode($request->mode)
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
        Gate::authorize('create', InfrastructureUser::class);

        $request->validate([]);

        return InfrastructureUser::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureUser $infrastructureUser
     * @return \Illuminate\Http\Response
     */
    public function show(InfrastructureUser $infrastructureUser)
    {
        Gate::authorize('show', $infrastructureUser);

        return new UserShowResource($infrastructureUser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Infrastructure\Models\InfrastructureUser $infrastructureUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfrastructureUser $infrastructureUser)
    {
        Gate::authorize('update', $infrastructureUser);

        $request->validate([]);

        return InfrastructureUser::updateRecord($request, $infrastructureUser);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureUser $infrastructureUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfrastructureUser $infrastructureUser)
    {
        Gate::authorize('delete', $infrastructureUser);

        return InfrastructureUser::deleteRecord($infrastructureUser);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureUser $infrastructureUser
     * @return \Illuminate\Http\Response
     */
    public function restore(InfrastructureUser $infrastructureUser)
    {
        Gate::authorize('restore', $infrastructureUser);

        return InfrastructureUser::restoreRecord($infrastructureUser);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Infrastructure\Models\InfrastructureUser $infrastructureUser
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(InfrastructureUser $infrastructureUser)
    {
        Gate::authorize('destroy', $infrastructureUser);

        return InfrastructureUser::destroyRecord($infrastructureUser);
    }
}
