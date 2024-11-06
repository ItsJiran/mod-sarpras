<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureInfrastructureRecordPeriodic;
use Module\System\Http\Resources\UserLogActivity;

class InfrastructureRecordPeriodicShowResource extends JsonResource
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
            'record' => InfrastructureInfrastructureRecordPeriodic::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureInfrastructureRecordPeriodic::mapCombos($request, $this),

                'icon' => InfrastructureInfrastructureRecordPeriodic::getPageIcon('infrastructure-recordperiodic'),

                'key' => InfrastructureInfrastructureRecordPeriodic::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureInfrastructureRecordPeriodic::mapStatuses($request, $this),

                'title' => InfrastructureInfrastructureRecordPeriodic::getPageTitle($request, 'infrastructure-recordperiodic'),
            ],
        ];
    }
}
