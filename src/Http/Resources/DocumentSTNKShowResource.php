<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocumentSTNK;
use Module\System\Http\Resources\UserLogActivity;

class DocumentSTNKShowResource extends JsonResource
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
            'record' => InfrastructureDocumentSTNK::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocumentSTNK::mapCombos($request, $this),

                'icon' => InfrastructureDocumentSTNK::getPageIcon('infrastructure-documentstnk'),

                'key' => InfrastructureDocumentSTNK::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocumentSTNK::mapStatuses($request, $this),

                'title' => InfrastructureDocumentSTNK::getPageTitle($request, 'infrastructure-documentstnk'),
            ],
        ];
    }
}
