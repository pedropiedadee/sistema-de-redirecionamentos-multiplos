<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RedirectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => (integer)$this->id,
            'nome_link'      => (string)$this->nome_link,
            'link_hash' => (string)$this->link_hash,
            'total_max_click' => (integer)$this->total_max_click,
            'created_at'    => (string)$this->created_at,
            'links'  => LinkResource::collection($this->whenLoaded('links')),
        ];
    }
}
