<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocument;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentResource::collection($this->collection);
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
                'combos' => InfrastructureDocument::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocument::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocument::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocument::getPageIcon('infrastructure-document'),

                /** the record key */
                'key' => InfrastructureDocument::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocument::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocument::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocument::getPageTitle($request, 'infrastructure-document'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocument::hasSoftDeleted(),
            ]
        ];
    }
}
