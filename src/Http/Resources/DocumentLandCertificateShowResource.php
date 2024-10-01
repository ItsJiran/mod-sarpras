<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocumentLandCertificate;
use Module\System\Http\Resources\UserLogActivity;

class DocumentLandCertificateShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            /**
             * the record data
             */
            'record' => InfrastructureDocumentLandCertificate::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocumentLandCertificate::mapCombos($request, $this),

                'icon' => InfrastructureDocumentLandCertificate::getPageIcon('infrastructure-documentlandcertificate'),

                'key' => InfrastructureDocumentLandCertificate::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocumentLandCertificate::mapStatuses($request, $this),

                'title' => InfrastructureDocumentLandCertificate::getPageTitle($request, 'infrastructure-documentlandcertificate'),
            ],
        ];
    }
}
