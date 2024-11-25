<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureDocumentStnk;
use Module\System\Http\Resources\UserLogActivity;

class DocumentStnkShowResource extends JsonResource
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
            'record' => InfrastructureDocumentStnk::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureDocumentStnk::mapCombos($request, $this),

                'icon' => InfrastructureDocumentStnk::getPageIcon('infrastructure-documentstnk'),

                'key' => InfrastructureDocumentStnk::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureDocumentStnk::mapStatuses($request, $this),

                'title' => InfrastructureDocumentStnk::getPageTitle($request, 'infrastructure-documentstnk'),
            ],
        ];
    }
}
