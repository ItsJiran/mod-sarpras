<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureInfrastructureRecordNoteUsed;
use Module\System\Http\Resources\UserLogActivity;

class InfrastructureRecordNoteUsedShowResource extends JsonResource
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
            'record' => InfrastructureInfrastructureRecordNoteUsed::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureInfrastructureRecordNoteUsed::mapCombos($request, $this),

                'icon' => InfrastructureInfrastructureRecordNoteUsed::getPageIcon('infrastructure-recordnoteused'),

                'key' => InfrastructureInfrastructureRecordNoteUsed::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureInfrastructureRecordNoteUsed::mapStatuses($request, $this),

                'title' => InfrastructureInfrastructureRecordNoteUsed::getPageTitle($request, 'infrastructure-recordnoteused'),
            ],
        ];
    }
}
