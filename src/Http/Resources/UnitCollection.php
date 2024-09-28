<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureUnit;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UnitCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return UnitResource::collection($this->collection);
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
                'combos' => InfrastructureUnit::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureUnit::mapFilters(),

                /** the table header */
                'headers' => InfrastructureUnit::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureUnit::getPageIcon('infrastructure-unit'),

                /** the record key */
                'key' => InfrastructureUnit::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureUnit::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureUnit::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureUnit::getPageTitle($request, 'infrastructure-unit'),

                /** the usetrash flag */
                'usetrash' => InfrastructureUnit::hasSoftDeleted(),
            ]
        ];
    }
}
