<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentVehicleLicense;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentVehicleLicenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return InfrastructureDocumentVehicleLicense::mapResource($request, $this);
    }
}
