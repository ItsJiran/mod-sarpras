<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureTaxPeriodics;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaxPeriodicsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return TaxPeriodicsResource::collection($this->collection);
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
                'combos' => InfrastructureTaxPeriodics::mapCombos($request),

                /** the page data filter */
                'filters' => InfrastructureTaxPeriodics::mapFilters(),

                /** the table header */
                'headers' => InfrastructureTaxPeriodics::mapHeaders($request),

                /** the page icon */
                'icon' => InfrastructureTaxPeriodics::getPageIcon('infrastructure-taxperiodics'),

                /** the record key */
                'key' => InfrastructureTaxPeriodics::getDataKey(),

                /** the page default */
                'recordBase' => InfrastructureTaxPeriodics::mapRecordBase($request),

                /** the page statuses */
                'statuses' => InfrastructureTaxPeriodics::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => InfrastructureTaxPeriodics::getPageTitle($request, 'infrastructure-taxperiodics'),

                /** the usetrash flag */
                'usetrash' => InfrastructureTaxPeriodics::hasSoftDeleted(),
            ]
        ];
    }
}
