<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetTaxRecord;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetTaxRecordCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetTaxRecordResource::collection($this->collection);
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
                'combos' => InfrastructureAssetTaxRecord::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetTaxRecord::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetTaxRecord::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetTaxRecord::getPageIcon('infrastructure-assettaxrecord'),

                /** the record key */
                'key' => InfrastructureAssetTaxRecord::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetTaxRecord::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetTaxRecord::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetTaxRecord::getPageTitle($request, 'infrastructure-assettaxrecord'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetTaxRecord::hasSoftDeleted(),
            ]
        ];
    }
}
