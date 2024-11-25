<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentStnk;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentStnkCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentStnkResource::collection($this->collection);
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
                'combos' => InfrastructureDocumentStnk::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocumentStnk::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocumentStnk::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocumentStnk::getPageIcon('infrastructure-documentstnk'),

                /** the record key */
                'key' => InfrastructureDocumentStnk::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocumentStnk::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocumentStnk::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocumentStnk::getPageTitle($request, 'infrastructure-documentstnk'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocumentStnk::hasSoftDeleted(),
            ]
        ];
    }
}
