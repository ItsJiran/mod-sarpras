<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetMaintenance;
use Module\System\Http\Resources\UserLogActivity;

class AssetMaintenanceShowResource extends JsonResource
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
            'record' => InfrastructureAssetMaintenance::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetMaintenance::mapCombos($request, $this),

                'icon' => InfrastructureAssetMaintenance::getPageIcon('infrastructure-assetmaintenance'),

                'key' => InfrastructureAssetMaintenance::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetMaintenance::mapStatuses($request, $this),

                'title' => InfrastructureAssetMaintenance::getPageTitle($request, 'infrastructure-assetmaintenance'),
            ],
        ];
    }
}
