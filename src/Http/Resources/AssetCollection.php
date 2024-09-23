<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAsset;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetResource::collection($this->collection);
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
                'combos' => InfrastructureAsset::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAsset::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAsset::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAsset::getPageIcon('infrastructure-asset'),

                /** the record key */
                'key' => InfrastructureAsset::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAsset::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAsset::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAsset::getPageTitle($request, 'infrastructure-asset'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAsset::hasSoftDeleted(),
            ]
        ];
    }
}
