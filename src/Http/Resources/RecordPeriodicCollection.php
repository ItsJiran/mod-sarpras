<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureRecordPeriodic;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecordPeriodicCollection extends ResourceCollection
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
                'combos' => InfrastructureRecordPeriodic::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureRecordPeriodic::mapFilters(),

                /** the table header */
                'headers' => InfrastructureRecordPeriodic::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureRecordPeriodic::getPageIcon('infrastructure-recordperiodic'),

                /** the record key */
                'key' => InfrastructureRecordPeriodic::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureRecordPeriodic::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureRecordPeriodic::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureRecordPeriodic::getPageTitle($request, 'infrastructure-recordperiodic'),

                /** the usetrash flag */
                'usetrash' => InfrastructureRecordPeriodic::hasSoftDeleted(),
            ]
        ];
    }
}
