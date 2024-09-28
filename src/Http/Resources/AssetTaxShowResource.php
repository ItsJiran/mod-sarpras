<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetTax;
use Module\System\Http\Resources\UserLogActivity;

class AssetTaxShowResource extends JsonResource
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
            'record' => InfrastructureAssetTax::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetTax::mapCombos($request, $this),

                'icon' => InfrastructureAssetTax::getPageIcon('infrastructure-assettax'),

                'key' => InfrastructureAssetTax::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetTax::mapStatuses($request, $this),

                'title' => InfrastructureAssetTax::getPageTitle($request, 'infrastructure-assettax'),
            ],
        ];
    }
}
