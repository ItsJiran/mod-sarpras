<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxUsed;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxUsedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxUsedResource::collection($this->collection);
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
                'combos' => InfrastructureTaxUsed::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxUsed::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxUsed::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxUsed::getPageIcon('infrastructure-taxused'),

                /** the record key */
                'key' => InfrastructureTaxUsed::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxUsed::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxUsed::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxUsed::getPageTitle($request, 'infrastructure-taxused'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxUsed::hasSoftDeleted(),
            ]
        ];
    }
}
