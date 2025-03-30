<?php

namespace TestImgApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'user_id' => $this->id,
            'message' => 'New user successfully registered'
        ];
    }

}
