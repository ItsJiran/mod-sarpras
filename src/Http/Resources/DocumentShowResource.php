<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocument;
use Module\System\Http\Resources\UserLogActivity;

class DocumentShowResource extends JsonResource
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
            'record' => InfrastructureDocument::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocument::mapCombos($request, $this),

                'icon' => InfrastructureDocument::getPageIcon('infrastructure-document'),

                'key' => InfrastructureDocument::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocument::mapStatuses($request, $this),

                'title' => InfrastructureDocument::getPageTitle($request, 'infrastructure-document'),
            ],
        ];
    }
}
