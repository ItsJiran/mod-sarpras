<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureInfrastructureRecordLog;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InfrastructureRecordLogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return RecordLogResource::collection($this->collection);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        if ($request->has('initialized')) {
            return [];
        }

        return [
            'setups' => [
                /** the page combo */
                'combos' => InfrastructureInfrastructureRecordLog::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureInfrastructureRecordLog::mapFilters(),

                /** the table header */
                'headers' => InfrastructureInfrastructureRecordLog::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureInfrastructureRecordLog::getPageIcon('infrastructure-recordlog'),

                /** the record key */
                'key' => InfrastructureInfrastructureRecordLog::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureInfrastructureRecordLog::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureInfrastructureRecordLog::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureInfrastructureRecordLog::getPageTitle($request, 'infrastructure-recordlog'),

                /** the usetrash flag */
                'usetrash' => InfrastructureInfrastructureRecordLog::hasSoftDeleted(),
            ]
        ];
    }
}
