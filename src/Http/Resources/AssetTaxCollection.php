<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetTax;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetTaxCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetTaxResource::collection($this->collection);
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
                'combos' => InfrastructureAssetTax::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetTax::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetTax::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetTax::getPageIcon('infrastructure-assettax'),

                /** the record key */
                'key' => InfrastructureAssetTax::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetTax::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetTax::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetTax::getPageTitle($request, 'infrastructure-assettax'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetTax::hasSoftDeleted(),
            ]
        ];
    }
}
