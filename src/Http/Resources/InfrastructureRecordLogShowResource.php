<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureInfrastructureRecordLog;
use Module\System\Http\Resources\UserLogActivity;

class InfrastructureRecordLogShowResource extends JsonResource
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
            'record' => InfrastructureInfrastructureRecordLog::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureInfrastructureRecordLog::mapCombos($request, $this),

                'icon' => InfrastructureInfrastructureRecordLog::getPageIcon('infrastructure-recordlog'),

                'key' => InfrastructureInfrastructureRecordLog::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureInfrastructureRecordLog::mapStatuses($request, $this),

                'title' => InfrastructureInfrastructureRecordLog::getPageTitle($request, 'infrastructure-recordlog'),
            ],
        ];
    }
}
