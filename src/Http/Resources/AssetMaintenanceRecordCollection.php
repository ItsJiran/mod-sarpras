<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetMaintenanceRecord;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetMaintenanceRecordCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetMaintenanceRecordResource::collection($this->collection);
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
                'combos' => InfrastructureAssetMaintenanceRecord::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetMaintenanceRecord::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetMaintenanceRecord::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetMaintenanceRecord::getPageIcon('infrastructure-assetmaintenancerecord'),

                /** the record key */
                'key' => InfrastructureAssetMaintenanceRecord::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetMaintenanceRecord::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetMaintenanceRecord::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetMaintenanceRecord::getPageTitle($request, 'infrastructure-assetmaintenancerecord'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetMaintenanceRecord::hasSoftDeleted(),
            ]
        ];
    }
}
