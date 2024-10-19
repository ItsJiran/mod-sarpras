<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxLog;
use Module\System\Http\Resources\UserLogActivity;

class TaxLogShowResource extends JsonResource
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
            'record' => InfrastructureTaxLog::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxLog::mapCombos($request, $this),

                'icon' => InfrastructureTaxLog::getPageIcon('infrastructure-taxlog'),

                'key' => InfrastructureTaxLog::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxLog::mapStatuses($request, $this),

                'title' => InfrastructureTaxLog::getPageTitle($request, 'infrastructure-taxlog'),
            ],
        ];
    }
}
