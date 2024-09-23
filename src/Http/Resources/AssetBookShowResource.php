<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetBook;
use Module\System\Http\Resources\UserLogActivity;

class AssetBookShowResource extends JsonResource
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
            'record' => InfrastructureAssetBook::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetBook::mapCombos($request, $this),

                'icon' => InfrastructureAssetBook::getPageIcon('infrastructure-assetbook'),

                'key' => InfrastructureAssetBook::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetBook::mapStatuses($request, $this),

                'title' => InfrastructureAssetBook::getPageTitle($request, 'infrastructure-assetbook'),
            ],
        ];
    }
}
