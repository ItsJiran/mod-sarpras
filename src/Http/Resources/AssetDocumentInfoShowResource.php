<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetDocumentInfo;
use Module\System\Http\Resources\UserLogActivity;

class AssetDocumentInfoShowResource extends JsonResource
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
            'record' => InfrastructureAssetDocumentInfo::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetDocumentInfo::mapCombos($request, $this),

                'icon' => InfrastructureAssetDocumentInfo::getPageIcon('infrastructure-assetdocumentinfo'),

                'key' => InfrastructureAssetDocumentInfo::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetDocumentInfo::mapStatuses($request, $this),

                'title' => InfrastructureAssetDocumentInfo::getPageTitle($request, 'infrastructure-assetdocumentinfo'),
            ],
        ];
    }
}
