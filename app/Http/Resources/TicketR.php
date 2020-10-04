<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = collect($this->resource)->only('id', 'name');
        $data['cost'] = intval($this->cost);
        $data['available'] = $this->available();
        $data['description'] = $this->description();
        return $data;
    }
}
