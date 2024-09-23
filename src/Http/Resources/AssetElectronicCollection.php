<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetElectronic;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetElectronicCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetElectronicResource::collection($this->collection);
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
                'combos' => InfrastructureAssetElectronic::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetElectronic::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetElectronic::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetElectronic::getPageIcon('infrastructure-assetelectronic'),

                /** the record key */
                'key' => InfrastructureAssetElectronic::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetElectronic::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetElectronic::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetElectronic::getPageTitle($request, 'infrastructure-assetelectronic'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetElectronic::hasSoftDeleted(),
            ]
        ];
    }
}
