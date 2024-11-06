<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureRecordNoteUsed;
use Module\System\Http\Resources\UserLogActivity;

class RecordNoteUsedShowResource extends JsonResource
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
            'record' => InfrastructureRecordNoteUsed::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureRecordNoteUsed::mapCombos($request, $this),

                'icon' => InfrastructureRecordNoteUsed::getPageIcon('infrastructure-recordnoteused'),

                'key' => InfrastructureRecordNoteUsed::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureRecordNoteUsed::mapStatuses($request, $this),

                'title' => InfrastructureRecordNoteUsed::getPageTitle($request, 'infrastructure-recordnoteused'),
            ],
        ];
    }
}
