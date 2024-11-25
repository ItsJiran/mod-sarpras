<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureVehicleLicense;
use Module\System\Http\Resources\UserLogActivity;

class VehicleLicenseShowResource extends JsonResource
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
            'record' => InfrastructureVehicleLicense::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureVehicleLicense::mapCombos($request, $this),

                'icon' => InfrastructureVehicleLicense::getPageIcon('infrastructure-vehiclelicense'),

                'key' => InfrastructureVehicleLicense::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureVehicleLicense::mapStatuses($request, $this),

                'title' => InfrastructureVehicleLicense::getPageTitle($request, 'infrastructure-vehiclelicense'),
            ],
        ];
    }
}
