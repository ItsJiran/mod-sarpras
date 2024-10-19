<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxAsset;
use Module\System\Http\Resources\UserLogActivity;

class TaxAssetShowResource extends JsonResource
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
            'record' => InfrastructureTaxAsset::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxAsset::mapCombos($request, $this),

                'icon' => InfrastructureTaxAsset::getPageIcon('infrastructure-taxasset'),

                'key' => InfrastructureTaxAsset::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxAsset::mapStatuses($request, $this),

                'title' => InfrastructureTaxAsset::getPageTitle($request, 'infrastructure-taxasset'),
            ],
        ];
    }
}
