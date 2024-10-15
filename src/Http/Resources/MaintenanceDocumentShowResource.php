<?php

namespace Module\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Infrastructure\Models\InfrastructureMaintenanceDocument;
use Module\System\Http\Resources\UserLogActivity;

class MaintenanceDocumentShowResource extends JsonResource
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
            'record' => InfrastructureMaintenanceDocument::mapResourceShow($request, $this),

            /**
             * the page setups
             */
            'setups' => [
                'combos' => InfrastructureMaintenanceDocument::mapCombos($request, $this),

                'icon' => InfrastructureMaintenanceDocument::getPageIcon('infrastructure-maintenancedocument'),

                'key' => InfrastructureMaintenanceDocument::getDataKey(),

                'logs' => $request->activities ? UserLogActivity::collection($this->activitylogs) : null,

                'softdelete' => $this->trashed() ?: false,

                'statuses' => InfrastructureMaintenanceDocument::mapStatuses($request, $this),

                'title' => InfrastructureMaintenanceDocument::getPageTitle($request, 'infrastructure-maintenancedocument'),
            ],
        ];
    }
}
