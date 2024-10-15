<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceDocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceDocumentResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenanceDocument::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenanceDocument::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenanceDocument::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenanceDocument::getPageIcon('infrastructure-maintenancedocument'),

                /** the record key */
                'key' => InfrastructureMaintenanceDocument::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenanceDocument::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenanceDocument::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenanceDocument::getPageTitle($request, 'infrastructure-maintenancedocument'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenanceDocument::hasSoftDeleted(),
            ]
        ];
    }
}
