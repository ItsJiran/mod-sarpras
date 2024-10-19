<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxLog;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxLogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxLogResource::collection($this->collection);
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
                'combos' => InfrastructureTaxLog::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxLog::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxLog::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxLog::getPageIcon('infrastructure-taxlog'),

                /** the record key */
                'key' => InfrastructureTaxLog::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxLog::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxLog::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxLog::getPageTitle($request, 'infrastructure-taxlog'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxLog::hasSoftDeleted(),
            ]
        ];
    }
}
