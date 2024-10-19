<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxPeriodics;
use Module\System\Http\Resources\UserLogActivity;

class TaxPeriodicsShowResource extends JsonResource
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
            'record' => InfrastructureTaxPeriodics::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxPeriodics::mapCombos($request, $this),

                'icon' => InfrastructureTaxPeriodics::getPageIcon('infrastructure-taxperiodics'),

                'key' => InfrastructureTaxPeriodics::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxPeriodics::mapStatuses($request, $this),

                'title' => InfrastructureTaxPeriodics::getPageTitle($request, 'infrastructure-taxperiodics'),
            ],
        ];
    }
}
