<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceAssetCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceAssetResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenanceAsset::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenanceAsset::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenanceAsset::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenanceAsset::getPageIcon('infrastructure-maintenanceasset'),

                /** the record key */
                'key' => InfrastructureMaintenanceAsset::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenanceAsset::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenanceAsset::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenanceAsset::getPageTitle($request, 'infrastructure-maintenanceasset'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenanceAsset::hasSoftDeleted(),
            ]
        ];
    }
}
