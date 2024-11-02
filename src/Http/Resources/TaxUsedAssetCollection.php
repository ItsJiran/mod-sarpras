<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxUsedAsset;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxUsedAssetCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxUsedAssetResource::collection($this->collection);
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
                'combos' => InfrastructureTaxUsedAsset::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxUsedAsset::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxUsedAsset::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxUsedAsset::getPageIcon('infrastructure-taxusedasset'),

                /** the record key */
                'key' => InfrastructureTaxUsedAsset::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxUsedAsset::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxUsedAsset::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxUsedAsset::getPageTitle($request, 'infrastructure-taxusedasset'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxUsedAsset::hasSoftDeleted(),
            ]
        ];
    }
}
