<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxUsed;
use Module\System\Http\Resources\UserLogActivity;

class TaxUsedShowResource extends JsonResource
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
            'record' => InfrastructureTaxUsed::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxUsed::mapCombos($request, $this),

                'icon' => InfrastructureTaxUsed::getPageIcon('infrastructure-taxused'),

                'key' => InfrastructureTaxUsed::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxUsed::mapStatuses($request, $this),

                'title' => InfrastructureTaxUsed::getPageTitle($request, 'infrastructure-taxused'),
            ],
        ];
    }
}
