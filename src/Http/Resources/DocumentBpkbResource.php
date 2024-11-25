<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentBpkb;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentBpkbResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return InfrastructureDocumentBpkb::mapResource($request, $this);
    }
}
