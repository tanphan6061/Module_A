<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventDetailR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = collect($this->resource)->only('id', 'name', 'slug', 'date');
        $data['tickets'] = TicketR::collection($this->tickets);
        $data['channels'] = ChannelR::collection($this->channels);
        return $data;
    }
}
