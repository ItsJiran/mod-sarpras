<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocumentOther;
use Module\System\Http\Resources\UserLogActivity;

class DocumentOtherShowResource extends JsonResource
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
            'record' => InfrastructureDocumentOther::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocumentOther::mapCombos($request, $this),

                'icon' => InfrastructureDocumentOther::getPageIcon('infrastructure-documentother'),

                'key' => InfrastructureDocumentOther::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocumentOther::mapStatuses($request, $this),

                'title' => InfrastructureDocumentOther::getPageTitle($request, 'infrastructure-documentother'),
            ],
        ];
    }
}
