<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureInfrastructureRecordNote;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InfrastructureRecordNoteCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return RecordNoteResource::collection($this->collection);
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
                'combos' => InfrastructureInfrastructureRecordNote::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureInfrastructureRecordNote::mapFilters(),

                /** the table header */
                'headers' => InfrastructureInfrastructureRecordNote::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureInfrastructureRecordNote::getPageIcon('infrastructure-recordnote'),

                /** the record key */
                'key' => InfrastructureInfrastructureRecordNote::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureInfrastructureRecordNote::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureInfrastructureRecordNote::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureInfrastructureRecordNote::getPageTitle($request, 'infrastructure-recordnote'),

                /** the usetrash flag */
                'usetrash' => InfrastructureInfrastructureRecordNote::hasSoftDeleted(),
            ]
        ];
    }
}
