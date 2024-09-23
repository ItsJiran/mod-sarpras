<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetVehicle;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetVehicleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetVehicleResource::collection($this->collection);
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
                'combos' => InfrastructureAssetVehicle::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetVehicle::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetVehicle::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetVehicle::getPageIcon('infrastructure-assetvehicle'),

                /** the record key */
                'key' => InfrastructureAssetVehicle::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetVehicle::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetVehicle::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetVehicle::getPageTitle($request, 'infrastructure-assetvehicle'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetVehicle::hasSoftDeleted(),
            ]
        ];
    }
}
