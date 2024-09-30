<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenance;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceShowResource extends JsonResource
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
            'record' => InfrastructureMaintenance::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenance::mapCombos($request, $this),

                'icon' => InfrastructureMaintenance::getPageIcon('infrastructure-maintenance'),

                'key' => InfrastructureMaintenance::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenance::mapStatuses($request, $this),

                'title' => InfrastructureMaintenance::getPageTitle($request, 'infrastructure-maintenance'),
            ],
        ];
    }
}
