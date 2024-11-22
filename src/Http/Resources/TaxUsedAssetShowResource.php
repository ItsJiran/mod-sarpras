<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxUsedAsset;
use Module\System\Http\Resources\UserLogActivity;

class TaxUsedAssetShowResource extends JsonResource
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
            'record' => InfrastructureTaxUsedAsset::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxUsedAsset::mapCombos($request, $this),

                'icon' => InfrastructureTaxUsedAsset::getPageIcon('infrastructure-taxusedasset'),

                'key' => InfrastructureTaxUsedAsset::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxUsedAsset::mapStatuses($request, $this),

                'title' => InfrastructureTaxUsedAsset::getPageTitle($request, 'infrastructure-taxusedasset'),
            ],
        ];
    }
}
