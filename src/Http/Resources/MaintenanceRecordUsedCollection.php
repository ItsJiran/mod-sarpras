<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenanceRecordUsed;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceRecordUsedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceRecordUsedResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenanceRecordUsed::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenanceRecordUsed::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenanceRecordUsed::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenanceRecordUsed::getPageIcon('infrastructure-maintenancerecordused'),

                /** the record key */
                'key' => InfrastructureMaintenanceRecordUsed::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenanceRecordUsed::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenanceRecordUsed::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenanceRecordUsed::getPageTitle($request, 'infrastructure-maintenancerecordused'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenanceRecordUsed::hasSoftDeleted(),
            ]
        ];
    }
}
