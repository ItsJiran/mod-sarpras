<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxRecord;
use Module\System\Http\Resources\UserLogActivity;

class TaxRecordShowResource extends JsonResource
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
            'record' => InfrastructureTaxRecord::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxRecord::mapCombos($request, $this),

                'icon' => InfrastructureTaxRecord::getPageIcon('infrastructure-taxrecord'),

                'key' => InfrastructureTaxRecord::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxRecord::mapStatuses($request, $this),

                'title' => InfrastructureTaxRecord::getPageTitle($request, 'infrastructure-taxrecord'),
            ],
        ];
    }
}
