<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenanceRecordUsed;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceRecordUsedShowResource extends JsonResource
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
            'record' => InfrastructureMaintenanceRecordUsed::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenanceRecordUsed::mapCombos($request, $this),

                'icon' => InfrastructureMaintenanceRecordUsed::getPageIcon('infrastructure-maintenancerecordused'),

                'key' => InfrastructureMaintenanceRecordUsed::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenanceRecordUsed::mapStatuses($request, $this),

                'title' => InfrastructureMaintenanceRecordUsed::getPageTitle($request, 'infrastructure-maintenancerecordused'),
            ],
        ];
    }
}
