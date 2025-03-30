<?php

namespace TestImgApi\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class UserItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position,
            'position_id' => (string) $this->position_id,
            'registration_timestamp' => $this->created_at->timestamp,
            'photo' => $this->photo,
        ];
    }
}
