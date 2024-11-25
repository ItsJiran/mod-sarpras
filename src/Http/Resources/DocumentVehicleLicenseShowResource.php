<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense;
use Module\System\Http\Resources\UserLogActivity;

class DocumentVehicleLicenseShowResource extends JsonResource
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
            'record' => InfrastructureDocumentVehicleLicense::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocumentVehicleLicense::mapCombos($request, $this),

                'icon' => InfrastructureDocumentVehicleLicense::getPageIcon('infrastructure-documentvehiclelicense'),

                'key' => InfrastructureDocumentVehicleLicense::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocumentVehicleLicense::mapStatuses($request, $this),

                'title' => InfrastructureDocumentVehicleLicense::getPageTitle($request, 'infrastructure-documentvehiclelicense'),
            ],
        ];
    }
}
