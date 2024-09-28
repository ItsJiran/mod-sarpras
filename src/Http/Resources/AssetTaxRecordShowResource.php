<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetTaxRecord;
use Module\System\Http\Resources\UserLogActivity;

class AssetTaxRecordShowResource extends JsonResource
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
            'record' => InfrastructureAssetTaxRecord::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetTaxRecord::mapCombos($request, $this),

                'icon' => InfrastructureAssetTaxRecord::getPageIcon('infrastructure-assettaxrecord'),

                'key' => InfrastructureAssetTaxRecord::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetTaxRecord::mapStatuses($request, $this),

                'title' => InfrastructureAssetTaxRecord::getPageTitle($request, 'infrastructure-assettaxrecord'),
            ],
        ];
    }
}
