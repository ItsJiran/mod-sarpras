<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetReservation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetReservationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetReservationResource::collection($this->collection);
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
                'combos' => InfrastructureAssetReservation::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetReservation::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetReservation::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetReservation::getPageIcon('infrastructure-assetreservation'),

                /** the record key */
                'key' => InfrastructureAssetReservation::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetReservation::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetReservation::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetReservation::getPageTitle($request, 'infrastructure-assetreservation'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetReservation::hasSoftDeleted(),
            ]
        ];
    }
}
