<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocumentBPKB;
use Module\System\Http\Resources\UserLogActivity;

class DocumentBPKBShowResource extends JsonResource
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
            'record' => InfrastructureDocumentBPKB::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocumentBPKB::mapCombos($request, $this),

                'icon' => InfrastructureDocumentBPKB::getPageIcon('infrastructure-documentbpkb'),

                'key' => InfrastructureDocumentBPKB::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocumentBPKB::mapStatuses($request, $this),

                'title' => InfrastructureDocumentBPKB::getPageTitle($request, 'infrastructure-documentbpkb'),
            ],
        ];
    }
}
