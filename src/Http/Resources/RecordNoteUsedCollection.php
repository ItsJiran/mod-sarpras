<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureRecordNoteUsed;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecordNoteUsedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return RecordNoteUsedResource::collection($this->collection);
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
                'combos' => InfrastructureRecordNoteUsed::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureRecordNoteUsed::mapFilters(),

                /** the table header */
                'headers' => InfrastructureRecordNoteUsed::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureRecordNoteUsed::getPageIcon('infrastructure-recordnoteused'),

                /** the record key */
                'key' => InfrastructureRecordNoteUsed::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureRecordNoteUsed::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureRecordNoteUsed::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureRecordNoteUsed::getPageTitle($request, 'infrastructure-recordnoteused'),

                /** the usetrash flag */
                'usetrash' => InfrastructureRecordNoteUsed::hasSoftDeleted(),
            ]
        ];
    }
}
