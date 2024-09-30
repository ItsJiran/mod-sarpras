<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenanceRecord;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceRecordCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceRecordResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenanceRecord::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenanceRecord::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenanceRecord::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenanceRecord::getPageIcon('infrastructure-maintenancerecord'),

                /** the record key */
                'key' => InfrastructureMaintenanceRecord::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenanceRecord::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenanceRecord::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenanceRecord::getPageTitle($request, 'infrastructure-maintenancerecord'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenanceRecord::hasSoftDeleted(),
            ]
        ];
    }
}
