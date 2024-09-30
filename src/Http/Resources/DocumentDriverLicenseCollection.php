<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentDriverLicense;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentDriverLicenseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentDriverLicenseResource::collection($this->collection);
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
                'combos' => InfrastructureDocumentDriverLicense::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocumentDriverLicense::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocumentDriverLicense::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocumentDriverLicense::getPageIcon('infrastructure-documentdriverlicense'),

                /** the record key */
                'key' => InfrastructureDocumentDriverLicense::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocumentDriverLicense::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocumentDriverLicense::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocumentDriverLicense::getPageTitle($request, 'infrastructure-documentdriverlicense'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocumentDriverLicense::hasSoftDeleted(),
            ]
        ];
    }
}
