<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetVehicle;
use Module\System\Http\Resources\UserLogActivity;

class AssetVehicleShowResource extends JsonResource
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
            'record' => InfrastructureAssetVehicle::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetVehicle::mapCombos($request, $this),

                'icon' => InfrastructureAssetVehicle::getPageIcon('infrastructure-assetvehicle'),

                'key' => InfrastructureAssetVehicle::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetVehicle::mapStatuses($request, $this),

                'title' => InfrastructureAssetVehicle::getPageTitle($request, 'infrastructure-assetvehicle'),
            ],
        ];
    }
}
