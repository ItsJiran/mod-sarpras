<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureAssetReservation;
use Module\System\Http\Resources\UserLogActivity;

class AssetReservationShowResource extends JsonResource
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
            'record' => InfrastructureAssetReservation::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureAssetReservation::mapCombos($request, $this),

                'icon' => InfrastructureAssetReservation::getPageIcon('infrastructure-assetreservation'),

                'key' => InfrastructureAssetReservation::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureAssetReservation::mapStatuses($request, $this),

                'title' => InfrastructureAssetReservation::getPageTitle($request, 'infrastructure-assetreservation'),
            ],
        ];
    }
}
