<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureUnit;
use Module\System\Http\Resources\UserLogActivity;

class UnitShowResource extends JsonResource
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
            'record' => InfrastructureUnit::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureUnit::mapCombos($request, $this),

                'icon' => InfrastructureUnit::getPageIcon('infrastructure-unit'),

                'key' => InfrastructureUnit::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureUnit::mapStatuses($request, $this),

                'title' => InfrastructureUnit::getPageTitle($request, 'infrastructure-unit'),
            ],
        ];
    }
}
