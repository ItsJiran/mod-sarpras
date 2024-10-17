<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenanceLog;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceLogShowResource extends JsonResource
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
            'record' => InfrastructureMaintenanceLog::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenanceLog::mapCombos($request, $this),

                'icon' => InfrastructureMaintenanceLog::getPageIcon('infrastructure-maintenancelog'),

                'key' => InfrastructureMaintenanceLog::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenanceLog::mapStatuses($request, $this),

                'title' => InfrastructureMaintenanceLog::getPageTitle($request, 'infrastructure-maintenancelog'),
            ],
        ];
    }
}
