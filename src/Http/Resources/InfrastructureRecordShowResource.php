<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureInfrastructureRecord;
use Module\System\Http\Resources\UserLogActivity;

class InfrastructureRecordShowResource extends JsonResource
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
            'record' => InfrastructureInfrastructureRecord::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureInfrastructureRecord::mapCombos($request, $this),

                'icon' => InfrastructureInfrastructureRecord::getPageIcon('infrastructure-record'),

                'key' => InfrastructureInfrastructureRecord::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureInfrastructureRecord::mapStatuses($request, $this),

                'title' => InfrastructureInfrastructureRecord::getPageTitle($request, 'infrastructure-record'),
            ],
        ];
    }
}
