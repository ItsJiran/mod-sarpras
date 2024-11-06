<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureRecordPeriodic;
use Module\System\Http\Resources\UserLogActivity;

class RecordPeriodicShowResource extends JsonResource
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
            'record' => InfrastructureRecordPeriodic::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureRecordPeriodic::mapCombos($request, $this),

                'icon' => InfrastructureRecordPeriodic::getPageIcon('infrastructure-recordperiodic'),

                'key' => InfrastructureRecordPeriodic::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureRecordPeriodic::mapStatuses($request, $this),

                'title' => InfrastructureRecordPeriodic::getPageTitle($request, 'infrastructure-recordperiodic'),
            ],
        ];
    }
}
