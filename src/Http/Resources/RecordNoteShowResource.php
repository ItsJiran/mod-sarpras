<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureRecordNote;
use Module\System\Http\Resources\UserLogActivity;

class RecordNoteShowResource extends JsonResource
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
            'record' => InfrastructureRecordNote::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureRecordNote::mapCombos($request, $this),

                'icon' => InfrastructureRecordNote::getPageIcon('infrastructure-recordnote'),

                'key' => InfrastructureRecordNote::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureRecordNote::mapStatuses($request, $this),

                'title' => InfrastructureRecordNote::getPageTitle($request, 'infrastructure-recordnote'),
            ],
        ];
    }
}
