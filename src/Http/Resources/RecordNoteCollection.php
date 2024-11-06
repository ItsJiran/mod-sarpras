<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureRecordNote;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecordNoteCollection extends ResourceCollection
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
                'combos' => InfrastructureRecordNote::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureRecordNote::mapFilters(),

                /** the table header */
                'headers' => InfrastructureRecordNote::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureRecordNote::getPageIcon('infrastructure-recordnote'),

                /** the record key */
                'key' => InfrastructureRecordNote::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureRecordNote::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureRecordNote::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureRecordNote::getPageTitle($request, 'infrastructure-recordnote'),

                /** the usetrash flag */
                'usetrash' => InfrastructureRecordNote::hasSoftDeleted(),
            ]
        ];
    }
}
