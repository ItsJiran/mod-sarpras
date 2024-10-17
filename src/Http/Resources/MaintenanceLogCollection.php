<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenanceLog;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceLogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceLogResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenanceLog::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenanceLog::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenanceLog::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenanceLog::getPageIcon('infrastructure-maintenancelog'),

                /** the record key */
                'key' => InfrastructureMaintenanceLog::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenanceLog::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenanceLog::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenanceLog::getPageTitle($request, 'infrastructure-maintenancelog'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenanceLog::hasSoftDeleted(),
            ]
        ];
    }
}
