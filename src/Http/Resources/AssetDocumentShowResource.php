<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetDocument;
use Module\System\Http\Resources\UserLogActivity;

class AssetDocumentShowResource extends JsonResource
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
            'record' => InfrastructureAssetDocument::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetDocument::mapCombos($request, $this),

                'icon' => InfrastructureAssetDocument::getPageIcon('infrastructure-assetdocument'),

                'key' => InfrastructureAssetDocument::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetDocument::mapStatuses($request, $this),

                'title' => InfrastructureAssetDocument::getPageTitle($request, 'infrastructure-assetdocument'),
            ],
        ];
    }
}
