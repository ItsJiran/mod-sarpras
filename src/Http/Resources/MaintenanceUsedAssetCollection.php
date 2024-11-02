<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenanceUsedAsset;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceUsedAssetCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceUsedAssetResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenanceUsedAsset::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenanceUsedAsset::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenanceUsedAsset::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenanceUsedAsset::getPageIcon('infrastructure-maintenanceusedasset'),

                /** the record key */
                'key' => InfrastructureMaintenanceUsedAsset::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenanceUsedAsset::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenanceUsedAsset::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenanceUsedAsset::getPageTitle($request, 'infrastructure-maintenanceusedasset'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenanceUsedAsset::hasSoftDeleted(),
            ]
        ];
    }
}
