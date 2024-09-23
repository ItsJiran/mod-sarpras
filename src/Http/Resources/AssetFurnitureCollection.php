<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetFurniture;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetFurnitureCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetFurnitureResource::collection($this->collection);
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
                'combos' => InfrastructureAssetFurniture::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetFurniture::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetFurniture::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetFurniture::getPageIcon('infrastructure-assetfurniture'),

                /** the record key */
                'key' => InfrastructureAssetFurniture::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetFurniture::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetFurniture::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetFurniture::getPageTitle($request, 'infrastructure-assetfurniture'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetFurniture::hasSoftDeleted(),
            ]
        ];
    }
}
