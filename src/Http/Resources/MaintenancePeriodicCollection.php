<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenancePeriodic;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenancePeriodicCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenancePeriodicResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenancePeriodic::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenancePeriodic::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenancePeriodic::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenancePeriodic::getPageIcon('infrastructure-maintenanceperiodic'),

                /** the record key */
                'key' => InfrastructureMaintenancePeriodic::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenancePeriodic::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenancePeriodic::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenancePeriodic::getPageTitle($request, 'infrastructure-maintenanceperiodic'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenancePeriodic::hasSoftDeleted(),
            ]
        ];
    }
}
