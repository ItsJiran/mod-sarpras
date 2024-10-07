<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxRecordUsed;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxRecordUsedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxRecordUsedResource::collection($this->collection);
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
                'combos' => InfrastructureTaxRecordUsed::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxRecordUsed::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxRecordUsed::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxRecordUsed::getPageIcon('infrastructure-taxrecordused'),

                /** the record key */
                'key' => InfrastructureTaxRecordUsed::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxRecordUsed::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxRecordUsed::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxRecordUsed::getPageTitle($request, 'infrastructure-taxrecordused'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxRecordUsed::hasSoftDeleted(),
            ]
        ];
    }
}
