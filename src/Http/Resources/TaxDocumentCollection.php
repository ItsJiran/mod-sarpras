<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxDocument;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxDocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxDocumentResource::collection($this->collection);
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
                'combos' => InfrastructureTaxDocument::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxDocument::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxDocument::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxDocument::getPageIcon('infrastructure-taxdocument'),

                /** the record key */
                'key' => InfrastructureTaxDocument::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxDocument::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxDocument::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxDocument::getPageTitle($request, 'infrastructure-taxdocument'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxDocument::hasSoftDeleted(),
            ]
        ];
    }
}
