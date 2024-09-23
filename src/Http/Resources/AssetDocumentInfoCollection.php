<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetDocumentInfo;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetDocumentInfoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetDocumentInfoResource::collection($this->collection);
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
                'combos' => InfrastructureAssetDocumentInfo::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetDocumentInfo::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetDocumentInfo::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetDocumentInfo::getPageIcon('infrastructure-assetdocumentinfo'),

                /** the record key */
                'key' => InfrastructureAssetDocumentInfo::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetDocumentInfo::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetDocumentInfo::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetDocumentInfo::getPageTitle($request, 'infrastructure-assetdocumentinfo'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetDocumentInfo::hasSoftDeleted(),
            ]
        ];
    }
}
