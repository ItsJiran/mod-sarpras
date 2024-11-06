<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureInfrastructureRecordNoteUsed;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InfrastructureRecordNoteUsedCollection extends ResourceCollection
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
                'combos' => InfrastructureInfrastructureRecordNoteUsed::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureInfrastructureRecordNoteUsed::mapFilters(),

                /** the table header */
                'headers' => InfrastructureInfrastructureRecordNoteUsed::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureInfrastructureRecordNoteUsed::getPageIcon('infrastructure-recordnoteused'),

                /** the record key */
                'key' => InfrastructureInfrastructureRecordNoteUsed::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureInfrastructureRecordNoteUsed::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureInfrastructureRecordNoteUsed::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureInfrastructureRecordNoteUsed::getPageTitle($request, 'infrastructure-recordnoteused'),

                /** the usetrash flag */
                'usetrash' => InfrastructureInfrastructureRecordNoteUsed::hasSoftDeleted(),
            ]
        ];
    }
}
