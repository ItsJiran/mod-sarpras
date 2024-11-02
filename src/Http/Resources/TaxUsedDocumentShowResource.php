<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureTaxUsedDocument;
use Module\System\Http\Resources\UserLogActivity;

class TaxUsedDocumentShowResource extends JsonResource
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
            'record' => InfrastructureTaxUsedDocument::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureTaxUsedDocument::mapCombos($request, $this),

                'icon' => InfrastructureTaxUsedDocument::getPageIcon('infrastructure-taxuseddocument'),

                'key' => InfrastructureTaxUsedDocument::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureTaxUsedDocument::mapStatuses($request, $this),

                'title' => InfrastructureTaxUsedDocument::getPageTitle($request, 'infrastructure-taxuseddocument'),
            ],
        ];
    }
}
