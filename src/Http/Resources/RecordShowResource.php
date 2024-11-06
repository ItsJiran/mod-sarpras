<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureRecord;
use Module\System\Http\Resources\UserLogActivity;

class RecordShowResource extends JsonResource
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
            'record' => InfrastructureRecord::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureRecord::mapCombos($request, $this),

                'icon' => InfrastructureRecord::getPageIcon('infrastructure-record'),

                'key' => InfrastructureRecord::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureRecord::mapStatuses($request, $this),

                'title' => InfrastructureRecord::getPageTitle($request, 'infrastructure-record'),
            ],
        ];
    }
}
