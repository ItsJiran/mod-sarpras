<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetElectronic;
use Module\System\Http\Resources\UserLogActivity;

class AssetElectronicShowResource extends JsonResource
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
            'record' => InfrastructureAssetElectronic::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetElectronic::mapCombos($request, $this),

                'icon' => InfrastructureAssetElectronic::getPageIcon('infrastructure-assetelectronic'),

                'key' => InfrastructureAssetElectronic::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetElectronic::mapStatuses($request, $this),

                'title' => InfrastructureAssetElectronic::getPageTitle($request, 'infrastructure-assetelectronic'),
            ],
        ];
    }
}
