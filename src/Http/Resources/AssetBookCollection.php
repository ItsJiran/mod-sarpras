<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetBook;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetBookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetBookResource::collection($this->collection);
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
                'combos' => InfrastructureAssetBook::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetBook::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetBook::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetBook::getPageIcon('infrastructure-assetbook'),

                /** the record key */
                'key' => InfrastructureAssetBook::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetBook::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetBook::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetBook::getPageTitle($request, 'infrastructure-assetbook'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetBook::hasSoftDeleted(),
            ]
        ];
    }
}
