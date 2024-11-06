<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureInfrastructureRecord;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InfrastructureRecordCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return RecordResource::collection($this->collection);
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
                'combos' => InfrastructureInfrastructureRecord::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureInfrastructureRecord::mapFilters(),

                /** the table header */
                'headers' => InfrastructureInfrastructureRecord::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureInfrastructureRecord::getPageIcon('infrastructure-record'),

                /** the record key */
                'key' => InfrastructureInfrastructureRecord::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureInfrastructureRecord::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureInfrastructureRecord::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureInfrastructureRecord::getPageTitle($request, 'infrastructure-record'),

                /** the usetrash flag */
                'usetrash' => InfrastructureInfrastructureRecord::hasSoftDeleted(),
            ]
        ];
    }
}
