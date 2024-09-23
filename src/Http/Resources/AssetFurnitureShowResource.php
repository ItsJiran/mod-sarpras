<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetFurniture;
use Module\System\Http\Resources\UserLogActivity;

class AssetFurnitureShowResource extends JsonResource
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
            'record' => InfrastructureAssetFurniture::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetFurniture::mapCombos($request, $this),

                'icon' => InfrastructureAssetFurniture::getPageIcon('infrastructure-assetfurniture'),

                'key' => InfrastructureAssetFurniture::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetFurniture::mapStatuses($request, $this),

                'title' => InfrastructureAssetFurniture::getPageTitle($request, 'infrastructure-assetfurniture'),
            ],
        ];
    }
}
