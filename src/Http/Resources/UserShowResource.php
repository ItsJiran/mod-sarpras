<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureUser;
use Module\System\Http\Resources\UserLogActivity;

class UserShowResource extends JsonResource
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
            'record' => InfrastructureUser::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureUser::mapCombos($request, $this),

                'icon' => InfrastructureUser::getPageIcon('infrastructure-user'),

                'key' => InfrastructureUser::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureUser::mapStatuses($request, $this),

                'title' => InfrastructureUser::getPageTitle($request, 'infrastructure-user'),
            ],
        ];
    }
}
