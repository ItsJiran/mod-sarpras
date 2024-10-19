<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxAsset;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxAssetCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxAssetResource::collection($this->collection);
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
                'combos' => InfrastructureTaxAsset::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxAsset::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxAsset::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxAsset::getPageIcon('infrastructure-taxasset'),

                /** the record key */
                'key' => InfrastructureTaxAsset::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxAsset::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxAsset::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxAsset::getPageTitle($request, 'infrastructure-taxasset'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxAsset::hasSoftDeleted(),
            ]
        ];
    }
}
