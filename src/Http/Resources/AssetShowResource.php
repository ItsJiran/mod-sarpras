<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAsset;
use Module\System\Http\Resources\UserLogActivity;

class AssetShowResource extends JsonResource
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
            'record' => InfrastructureAsset::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAsset::mapCombos($request, $this),

                'icon' => InfrastructureAsset::getPageIcon('infrastructure-asset'),

                'key' => InfrastructureAsset::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAsset::mapStatuses($request, $this),

                'title' => InfrastructureAsset::getPageTitle($request, 'infrastructure-asset'),
            ],
        ];
    }
}
