<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenance;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenance::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenance::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenance::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenance::getPageIcon('infrastructure-maintenance'),

                /** the record key */
                'key' => InfrastructureMaintenance::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenance::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenance::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenance::getPageTitle($request, 'infrastructure-maintenance'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenance::hasSoftDeleted(),
            ]
        ];
    }
}
