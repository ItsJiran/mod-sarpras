<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureInfrastructureRecordNote;
use Module\System\Http\Resources\UserLogActivity;

class InfrastructureRecordNoteShowResource extends JsonResource
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
            'record' => InfrastructureInfrastructureRecordNote::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureInfrastructureRecordNote::mapCombos($request, $this),

                'icon' => InfrastructureInfrastructureRecordNote::getPageIcon('infrastructure-recordnote'),

                'key' => InfrastructureInfrastructureRecordNote::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureInfrastructureRecordNote::mapStatuses($request, $this),

                'title' => InfrastructureInfrastructureRecordNote::getPageTitle($request, 'infrastructure-recordnote'),
            ],
        ];
    }
}
