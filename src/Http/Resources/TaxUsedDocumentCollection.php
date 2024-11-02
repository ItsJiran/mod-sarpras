<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxUsedDocument;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxUsedDocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxUsedDocumentResource::collection($this->collection);
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
                'combos' => InfrastructureTaxUsedDocument::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxUsedDocument::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxUsedDocument::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxUsedDocument::getPageIcon('infrastructure-taxuseddocument'),

                /** the record key */
                'key' => InfrastructureTaxUsedDocument::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxUsedDocument::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxUsedDocument::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxUsedDocument::getPageTitle($request, 'infrastructure-taxuseddocument'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxUsedDocument::hasSoftDeleted(),
            ]
        ];
    }
}
