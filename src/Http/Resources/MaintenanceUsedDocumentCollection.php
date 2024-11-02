<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureMaintenanceUsedDocument;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaintenanceUsedDocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return MaintenanceUsedDocumentResource::collection($this->collection);
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
                'combos' => InfrastructureMaintenanceUsedDocument::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureMaintenanceUsedDocument::mapFilters(),

                /** the table header */
                'headers' => InfrastructureMaintenanceUsedDocument::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureMaintenanceUsedDocument::getPageIcon('infrastructure-maintenanceuseddocument'),

                /** the record key */
                'key' => InfrastructureMaintenanceUsedDocument::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureMaintenanceUsedDocument::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureMaintenanceUsedDocument::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureMaintenanceUsedDocument::getPageTitle($request, 'infrastructure-maintenanceuseddocument'),

                /** the usetrash flag */
                'usetrash' => InfrastructureMaintenanceUsedDocument::hasSoftDeleted(),
            ]
        ];
    }
}
