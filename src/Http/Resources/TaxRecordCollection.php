<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxRecord;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxRecordCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxRecordResource::collection($this->collection);
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
                'combos' => InfrastructureTaxRecord::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxRecord::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxRecord::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxRecord::getPageIcon('infrastructure-taxrecord'),

                /** the record key */
                'key' => InfrastructureTaxRecord::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxRecord::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxRecord::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxRecord::getPageTitle($request, 'infrastructure-taxrecord'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxRecord::hasSoftDeleted(),
            ]
        ];
    }
}
