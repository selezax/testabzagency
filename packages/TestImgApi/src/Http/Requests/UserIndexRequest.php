<?php

namespace TestImgApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{
    use ResponseErrorTrait;

    public function rules(): array
    {
        return [
            'page' => 'nullable|integer|min:1',
            'count' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'page.integer' => 'The page must be an integer.',
            'page.min' => 'The page must be at least 1.',
            'count.integer' => 'The count must be an integer.',
            'count.min' => 'The count must be at least 1.',
        ];
    }
}
