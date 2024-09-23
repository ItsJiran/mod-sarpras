<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetLand;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetLandCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetLandResource::collection($this->collection);
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
                'combos' => InfrastructureAssetLand::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetLand::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetLand::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetLand::getPageIcon('infrastructure-assetland'),

                /** the record key */
                'key' => InfrastructureAssetLand::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetLand::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetLand::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetLand::getPageTitle($request, 'infrastructure-assetland'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetLand::hasSoftDeleted(),
            ]
        ];
    }
}
