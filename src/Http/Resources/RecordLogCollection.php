<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureRecordLog;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecordLogCollection extends ResourceCollection
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
                'combos' => InfrastructureRecordLog::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureRecordLog::mapFilters(),

                /** the table header */
                'headers' => InfrastructureRecordLog::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureRecordLog::getPageIcon('infrastructure-recordlog'),

                /** the record key */
                'key' => InfrastructureRecordLog::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureRecordLog::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureRecordLog::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureRecordLog::getPageTitle($request, 'infrastructure-recordlog'),

                /** the usetrash flag */
                'usetrash' => InfrastructureRecordLog::hasSoftDeleted(),
            ]
        ];
    }
}
