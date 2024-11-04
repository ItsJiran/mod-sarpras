<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenanceUsed;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceUsedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceUsedResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenanceUsed::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenanceUsed::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenanceUsed::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenanceUsed::getPageIcon('infrastructure-maintenanceused'),

                /** the record key */
                'key' => InfrastructureMaintenanceUsed::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenanceUsed::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenanceUsed::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenanceUsed::getPageTitle($request, 'infrastructure-maintenanceused'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenanceUsed::hasSoftDeleted(),
            ]
        ];
    }
}
