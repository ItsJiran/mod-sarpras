<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentBpkb;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentBpkbCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentBpkbResource::collection($this->collection);
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
                'combos' => InfrastructureDocumentBpkb::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocumentBpkb::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocumentBpkb::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocumentBpkb::getPageIcon('infrastructure-documentbpkb'),

                /** the record key */
                'key' => InfrastructureDocumentBpkb::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocumentBpkb::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocumentBpkb::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocumentBpkb::getPageTitle($request, 'infrastructure-documentbpkb'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocumentBpkb::hasSoftDeleted(),
            ]
        ];
    }
}
