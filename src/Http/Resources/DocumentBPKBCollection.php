<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentBPKB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentBPKBCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentBPKBResource::collection($this->collection);
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
                'combos' => InfrastructureDocumentBPKB::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocumentBPKB::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocumentBPKB::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocumentBPKB::getPageIcon('infrastructure-documentbpkb'),

                /** the record key */
                'key' => InfrastructureDocumentBPKB::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocumentBPKB::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocumentBPKB::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocumentBPKB::getPageTitle($request, 'infrastructure-documentbpkb'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocumentBPKB::hasSoftDeleted(),
            ]
        ];
    }
}
