<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetLand;
use Module\System\Http\Resources\UserLogActivity;

class AssetLandShowResource extends JsonResource
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
            'record' => InfrastructureAssetLand::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetLand::mapCombos($request, $this),

                'icon' => InfrastructureAssetLand::getPageIcon('infrastructure-assetland'),

                'key' => InfrastructureAssetLand::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetLand::mapStatuses($request, $this),

                'title' => InfrastructureAssetLand::getPageTitle($request, 'infrastructure-assetland'),
            ],
        ];
    }
}
