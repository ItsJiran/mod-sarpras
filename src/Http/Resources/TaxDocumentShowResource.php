<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxDocument;
use Module\System\Http\Resources\UserLogActivity;

class TaxDocumentShowResource extends JsonResource
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
            'record' => InfrastructureTaxDocument::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxDocument::mapCombos($request, $this),

                'icon' => InfrastructureTaxDocument::getPageIcon('infrastructure-taxdocument'),

                'key' => InfrastructureTaxDocument::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxDocument::mapStatuses($request, $this),

                'title' => InfrastructureTaxDocument::getPageTitle($request, 'infrastructure-taxdocument'),
            ],
        ];
    }
}
