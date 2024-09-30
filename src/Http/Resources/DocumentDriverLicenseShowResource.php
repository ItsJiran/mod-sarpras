<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocumentDriverLicense;
use Module\System\Http\Resources\UserLogActivity;

class DocumentDriverLicenseShowResource extends JsonResource
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
            'record' => InfrastructureDocumentDriverLicense::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocumentDriverLicense::mapCombos($request, $this),

                'icon' => InfrastructureDocumentDriverLicense::getPageIcon('infrastructure-documentdriverlicense'),

                'key' => InfrastructureDocumentDriverLicense::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocumentDriverLicense::mapStatuses($request, $this),

                'title' => InfrastructureDocumentDriverLicense::getPageTitle($request, 'infrastructure-documentdriverlicense'),
            ],
        ];
    }
}
