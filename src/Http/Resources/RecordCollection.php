<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureRecord;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecordCollection extends ResourceCollection
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
                'combos' => InfrastructureRecord::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureRecord::mapFilters(),

                /** the table header */
                'headers' => InfrastructureRecord::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureRecord::getPageIcon('infrastructure-record'),

                /** the record key */
                'key' => InfrastructureRecord::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureRecord::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureRecord::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureRecord::getPageTitle($request, 'infrastructure-record'),

                /** the usetrash flag */
                'usetrash' => InfrastructureRecord::hasSoftDeleted(),
            ]
        ];
    }
}
