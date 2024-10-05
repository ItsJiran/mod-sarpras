<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenanceRecord;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceRecordShowResource extends JsonResource
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
            'record' => InfrastructureMaintenanceRecord::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenanceRecord::mapCombos($request, $this),

                'icon' => InfrastructureMaintenanceRecord::getPageIcon('infrastructure-maintenancerecord'),

                'key' => InfrastructureMaintenanceRecord::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenanceRecord::mapStatuses($request, $this),

                'title' => InfrastructureMaintenanceRecord::getPageTitle($request, 'infrastructure-maintenancerecord'),
            ],
        ];
    }
}
