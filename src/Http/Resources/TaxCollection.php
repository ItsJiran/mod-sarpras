<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTax;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxResource::collection($this->collection);
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
                'combos' => InfrastructureTax::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTax::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTax::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTax::getPageIcon('infrastructure-tax'),

                /** the record key */
                'key' => InfrastructureTax::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTax::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTax::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTax::getPageTitle($request, 'infrastructure-tax'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTax::hasSoftDeleted(),
            ]
        ];
    }
}
