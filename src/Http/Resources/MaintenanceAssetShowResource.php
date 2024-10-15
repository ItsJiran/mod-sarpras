<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenanceAsset;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceAssetShowResource extends JsonResource
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
            'record' => InfrastructureMaintenanceAsset::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenanceAsset::mapCombos($request, $this),

                'icon' => InfrastructureMaintenanceAsset::getPageIcon('infrastructure-maintenanceasset'),

                'key' => InfrastructureMaintenanceAsset::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenanceAsset::mapStatuses($request, $this),

                'title' => InfrastructureMaintenanceAsset::getPageTitle($request, 'infrastructure-maintenanceasset'),
            ],
        ];
    }
}
