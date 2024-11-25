<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentOther;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentOtherCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentOtherResource::collection($this->collection);
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
                'combos' => InfrastructureDocumentOther::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocumentOther::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocumentOther::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocumentOther::getPageIcon('infrastructure-documentother'),

                /** the record key */
                'key' => InfrastructureDocumentOther::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocumentOther::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocumentOther::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocumentOther::getPageTitle($request, 'infrastructure-documentother'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocumentOther::hasSoftDeleted(),
            ]
        ];
    }
}
