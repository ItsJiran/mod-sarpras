<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetBookInfo;
use Module\System\Http\Resources\UserLogActivity;

class AssetBookInfoShowResource extends JsonResource
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
            'record' => InfrastructureAssetBookInfo::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetBookInfo::mapCombos($request, $this),

                'icon' => InfrastructureAssetBookInfo::getPageIcon('infrastructure-assetbookinfo'),

                'key' => InfrastructureAssetBookInfo::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetBookInfo::mapStatuses($request, $this),

                'title' => InfrastructureAssetBookInfo::getPageTitle($request, 'infrastructure-assetbookinfo'),
            ],
        ];
    }
}
