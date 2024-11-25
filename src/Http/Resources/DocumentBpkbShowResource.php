<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocumentBpkb;
use Module\System\Http\Resources\UserLogActivity;

class DocumentBpkbShowResource extends JsonResource
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
            'record' => InfrastructureDocumentBpkb::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocumentBpkb::mapCombos($request, $this),

                'icon' => InfrastructureDocumentBpkb::getPageIcon('infrastructure-documentbpkb'),

                'key' => InfrastructureDocumentBpkb::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocumentBpkb::mapStatuses($request, $this),

                'title' => InfrastructureDocumentBpkb::getPageTitle($request, 'infrastructure-documentbpkb'),
            ],
        ];
    }
}
