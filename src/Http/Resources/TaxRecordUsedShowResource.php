<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxRecordUsed;
use Module\System\Http\Resources\UserLogActivity;

class TaxRecordUsedShowResource extends JsonResource
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
            'record' => InfrastructureTaxRecordUsed::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxRecordUsed::mapCombos($request, $this),

                'icon' => InfrastructureTaxRecordUsed::getPageIcon('infrastructure-taxrecordused'),

                'key' => InfrastructureTaxRecordUsed::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxRecordUsed::mapStatuses($request, $this),

                'title' => InfrastructureTaxRecordUsed::getPageTitle($request, 'infrastructure-taxrecordused'),
            ],
        ];
    }
}
