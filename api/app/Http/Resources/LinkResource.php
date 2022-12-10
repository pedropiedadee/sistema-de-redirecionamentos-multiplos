<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
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
            'id' => (integer)$this->id,
            'link' => (string)$this->link,
            'click' => (integer)$this->click,
            'max_click' => (integer)$this->max_click,
            'created_at' => (string)$this->created_at,
        ];
    }
}
