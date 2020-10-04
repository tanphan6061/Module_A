<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = collect($this->resource)->only('id', 'name');
        $data['sessions'] = SessionR::collection($this->sessions);
        return $data;
    }
}
