<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentLandCertificate;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentLandCertificateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return DocumentLandCertificateResource::collection($this->collection);
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
                'combos' => InfrastructureDocumentLandCertificate::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureDocumentLandCertificate::mapFilters(),

                /** the table header */
                'headers' => InfrastructureDocumentLandCertificate::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureDocumentLandCertificate::getPageIcon('infrastructure-documentlandcertificate'),

                /** the record key */
                'key' => InfrastructureDocumentLandCertificate::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureDocumentLandCertificate::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureDocumentLandCertificate::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureDocumentLandCertificate::getPageTitle($request, 'infrastructure-documentlandcertificate'),

                /** the usetrash flag */
                'usetrash' => InfrastructureDocumentLandCertificate::hasSoftDeleted(),
            ]
        ];
    }
}
