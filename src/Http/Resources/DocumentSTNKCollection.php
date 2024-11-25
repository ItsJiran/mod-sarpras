<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentSTNK;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentSTNKCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentSTNKResource::collection($this->collection);
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
                'combos' => InfrastructureDocumentSTNK::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocumentSTNK::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocumentSTNK::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocumentSTNK::getPageIcon('infrastructure-documentstnk'),

                /** the record key */
                'key' => InfrastructureDocumentSTNK::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocumentSTNK::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocumentSTNK::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocumentSTNK::getPageTitle($request, 'infrastructure-documentstnk'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocumentSTNK::hasSoftDeleted(),
            ]
        ];
    }
}
