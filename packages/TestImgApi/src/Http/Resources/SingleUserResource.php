<?php

namespace TestImgApi\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'success' => true,
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'position' => $this->position,
                'position_id' => $this->position_id,
                'photo' => $this->photo,
            ],
        ];
    }
}
