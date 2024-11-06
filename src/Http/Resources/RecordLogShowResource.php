<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureRecordLog;
use Module\System\Http\Resources\UserLogActivity;

class RecordLogShowResource extends JsonResource
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
            'record' => InfrastructureRecordLog::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureRecordLog::mapCombos($request, $this),

                'icon' => InfrastructureRecordLog::getPageIcon('infrastructure-recordlog'),

                'key' => InfrastructureRecordLog::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureRecordLog::mapStatuses($request, $this),

                'title' => InfrastructureRecordLog::getPageTitle($request, 'infrastructure-recordlog'),
            ],
        ];
    }
}
