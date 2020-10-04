<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'event' => new EventR($this->ticket->event),
            'session_ids' => array_column(collect($this->session_registrations)->toArray(), 'session_id')
        ];
    }
}
