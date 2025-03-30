<?php

namespace TestImgApi\Http\Resources;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'success' => $this['success'],
            'token' => $this['token'],
        ];
    }
}
