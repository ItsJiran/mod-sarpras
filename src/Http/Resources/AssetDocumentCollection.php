<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureAssetDocument;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AssetDocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AssetDocumentResource::collection($this->collection);
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
                'combos' => InfrastructureAssetDocument::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureAssetDocument::mapFilters(),

                /** the table header */
                'headers' => InfrastructureAssetDocument::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureAssetDocument::getPageIcon('infrastructure-assetdocument'),

                /** the record key */
                'key' => InfrastructureAssetDocument::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureAssetDocument::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureAssetDocument::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureAssetDocument::getPageTitle($request, 'infrastructure-assetdocument'),

                /** the usetrash flag */
                'usetrash' => InfrastructureAssetDocument::hasSoftDeleted(),
            ]
        ];
    }
}
