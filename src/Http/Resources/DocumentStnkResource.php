<?php

namespace Module\Infrastructure\Http\Resources;

use Module\Infrastructure\Models\InfrastructureDocumentStnk;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentStnkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return InfrastructureDocumentStnk::mapResource($request, $this);
    }
}
