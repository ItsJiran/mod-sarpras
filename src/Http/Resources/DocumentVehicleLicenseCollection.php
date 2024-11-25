<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentVehicleLicenseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentVehicleLicenseResource::collection($this->collection);
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
                'combos' => InfrastructureDocumentVehicleLicense::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocumentVehicleLicense::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocumentVehicleLicense::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocumentVehicleLicense::getPageIcon('infrastructure-documentvehiclelicense'),

                /** the record key */
                'key' => InfrastructureDocumentVehicleLicense::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocumentVehicleLicense::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocumentVehicleLicense::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocumentVehicleLicense::getPageTitle($request, 'infrastructure-documentvehiclelicense'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocumentVehicleLicense::hasSoftDeleted(),
            ]
        ];
    }
}
