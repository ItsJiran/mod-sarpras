<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureInfrastructureRecordPeriodic;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InfrastructureRecordPeriodicCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return RecordPeriodicResource::collection($this->collection);
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
                'combos' => InfrastructureInfrastructureRecordPeriodic::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureInfrastructureRecordPeriodic::mapFilters(),

                /** the table header */
                'headers' => InfrastructureInfrastructureRecordPeriodic::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureInfrastructureRecordPeriodic::getPageIcon('infrastructure-recordperiodic'),

                /** the record key */
                'key' => InfrastructureInfrastructureRecordPeriodic::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureInfrastructureRecordPeriodic::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureInfrastructureRecordPeriodic::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureInfrastructureRecordPeriodic::getPageTitle($request, 'infrastructure-recordperiodic'),

                /** the usetrash flag */
                'usetrash' => InfrastructureInfrastructureRecordPeriodic::hasSoftDeleted(),
            ]
        ];
    }
}
