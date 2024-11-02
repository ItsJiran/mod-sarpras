<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenanceUsedDocument;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceUsedDocumentShowResource extends JsonResource
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
            'record' => InfrastructureMaintenanceUsedDocument::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenanceUsedDocument::mapCombos($request, $this),

                'icon' => InfrastructureMaintenanceUsedDocument::getPageIcon('infrastructure-maintenanceuseddocument'),

                'key' => InfrastructureMaintenanceUsedDocument::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenanceUsedDocument::mapStatuses($request, $this),

                'title' => InfrastructureMaintenanceUsedDocument::getPageTitle($request, 'infrastructure-maintenanceuseddocument'),
            ],
        ];
    }
}
