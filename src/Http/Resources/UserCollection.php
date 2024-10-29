<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureUser;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return UserResource::collection($this->collection);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        if ($request->has('initialized')) {
            return [];
        }

        return [
            'setups' => [
                /** the page combo */
                'combos' => InfrastructureUser::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureUser::mapFilters(),

                /** the table header */
                'headers' => InfrastructureUser::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureUser::getPageIcon('infrastructure-user'),

                /** the record key */
                'key' => InfrastructureUser::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureUser::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureUser::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureUser::getPageTitle($request, 'infrastructure-user'),

                /** the usetrash flag */
                'usetrash' => InfrastructureUser::hasSoftDeleted(),
            ]
        ];
    }
}
