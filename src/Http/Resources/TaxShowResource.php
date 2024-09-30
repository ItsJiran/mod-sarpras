<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTax;
use Module\System\Http\Resources\UserLogActivity;

class TaxShowResource extends JsonResource
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
            'record' => InfrastructureTax::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTax::mapCombos($request, $this),

                'icon' => InfrastructureTax::getPageIcon('infrastructure-tax'),

                'key' => InfrastructureTax::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTax::mapStatuses($request, $this),

                'title' => InfrastructureTax::getPageTitle($request, 'infrastructure-tax'),
            ],
        ];
    }
}
