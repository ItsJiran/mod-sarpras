<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenanceUsed;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceUsedShowResource extends JsonResource
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
            'record' => InfrastructureMaintenanceUsed::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenanceUsed::mapCombos($request, $this),

                'icon' => InfrastructureMaintenanceUsed::getPageIcon('infrastructure-maintenanceused'),

                'key' => InfrastructureMaintenanceUsed::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenanceUsed::mapStatuses($request, $this),

                'title' => InfrastructureMaintenanceUsed::getPageTitle($request, 'infrastructure-maintenanceused'),
            ],
        ];
    }
}
