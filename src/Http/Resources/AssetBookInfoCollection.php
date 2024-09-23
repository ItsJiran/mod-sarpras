<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetBookInfo;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetBookInfoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetBookInfoResource::collection($this->collection);
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
                'combos' => InfrastructureAssetBookInfo::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetBookInfo::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetBookInfo::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetBookInfo::getPageIcon('infrastructure-assetbookinfo'),

                /** the record key */
                'key' => InfrastructureAssetBookInfo::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetBookInfo::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetBookInfo::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetBookInfo::getPageTitle($request, 'infrastructure-assetbookinfo'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetBookInfo::hasSoftDeleted(),
            ]
        ];
    }
}
