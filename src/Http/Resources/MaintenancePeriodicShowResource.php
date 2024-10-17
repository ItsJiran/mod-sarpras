<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenancePeriodic;
use Module\System\Http\Resources\UserLogActivity;

class MaintenancePeriodicShowResource extends JsonResource
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
            'record' => InfrastructureMaintenancePeriodic::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenancePeriodic::mapCombos($request, $this),

                'icon' => InfrastructureMaintenancePeriodic::getPageIcon('infrastructure-maintenanceperiodic'),

                'key' => InfrastructureMaintenancePeriodic::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenancePeriodic::mapStatuses($request, $this),

                'title' => InfrastructureMaintenancePeriodic::getPageTitle($request, 'infrastructure-maintenanceperiodic'),
            ],
        ];
    }
}
