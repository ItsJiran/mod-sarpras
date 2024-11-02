<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenanceUsedAsset;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceUsedAssetShowResource extends JsonResource
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
            'record' => InfrastructureMaintenanceUsedAsset::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenanceUsedAsset::mapCombos($request, $this),

                'icon' => InfrastructureMaintenanceUsedAsset::getPageIcon('infrastructure-maintenanceusedasset'),

                'key' => InfrastructureMaintenanceUsedAsset::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenanceUsedAsset::mapStatuses($request, $this),

                'title' => InfrastructureMaintenanceUsedAsset::getPageTitle($request, 'infrastructure-maintenanceusedasset'),
            ],
        ];
    }
}
