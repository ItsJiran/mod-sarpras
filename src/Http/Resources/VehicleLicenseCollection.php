<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureVehicleLicense;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleLicenseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return VehicleLicenseResource::collection($this->collection);
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
                'combos' => InfrastructureVehicleLicense::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureVehicleLicense::mapFilters(),

                /** the table header */
                'headers' => InfrastructureVehicleLicense::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureVehicleLicense::getPageIcon('infrastructure-vehiclelicense'),

                /** the record key */
                'key' => InfrastructureVehicleLicense::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureVehicleLicense::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureVehicleLicense::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureVehicleLicense::getPageTitle($request, 'infrastructure-vehiclelicense'),

                /** the usetrash flag */
                'usetrash' => InfrastructureVehicleLicense::hasSoftDeleted(),
            ]
        ];
    }
}
