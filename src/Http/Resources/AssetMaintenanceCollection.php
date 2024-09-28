<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetMaintenance;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetMaintenanceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetMaintenanceResource::collection($this->collection);
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
                'combos' => InfrastructureAssetMaintenance::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetMaintenance::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetMaintenance::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetMaintenance::getPageIcon('infrastructure-assetmaintenance'),

                /** the record key */
                'key' => InfrastructureAssetMaintenance::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetMaintenance::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetMaintenance::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetMaintenance::getPageTitle($request, 'infrastructure-assetmaintenance'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetMaintenance::hasSoftDeleted(),
            ]
        ];
    }
}
