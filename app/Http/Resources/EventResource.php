<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'day'=>$this->day,
            'event_type'=>$this->event_type,
            'comment'=>$this->comment,
            'user_id'=>$this->user_id
        ];
    }
}
