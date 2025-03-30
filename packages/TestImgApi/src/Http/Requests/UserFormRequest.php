<?php

namespace TestImgApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TestImgApi\Models\Position;

class UserFormRequest extends FormRequest
{
    use ResponseErrorTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|string|email:rfc|min:6|max:100',
            'phone' => 'required|string|regex:/^\+?380[0-9]{9}$/',
            'position_id' => ['required', 'integer', 'exists:' . Position::class . ',id'],
            'photo' => 'required|image|mimes:jpeg,jpg|max:5120|dimensions:min_width=70,min_height=70',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 2 characters.',
            'name.max' => 'The name may not be greater than 60 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.min' => 'The email must be at least 6 characters.',
            'email.max' => 'The email may not be greater than 100 characters.',
            'phone.required' => 'The phone field is required.',
            'phone.regex' => 'The phone must start with +380 followed by 9 digits.',
            'position_id.required' => 'The position id field is required.',
            'position_id.integer' => 'The position id must be an integer.',
            'position_id.exists' => 'The selected position id is invalid.',
            'photo.required' => 'The photo field is required.',
            'photo.image' => 'The photo must be an image.',
            'photo.mimes' => 'The photo must be a file of type: jpeg, jpg.',
            'photo.max' => 'The photo may not be greater than 5 megabytes.',
            'photo.dimensions' => 'The photo dimensions must be at least 70x70 pixels.',
        ];
    }
}
