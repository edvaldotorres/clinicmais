<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts')->ignore($this->post)
            ],
            'content' => ['required', 'string'],
            'image' => [
                'nullable',
                'image',
                'max:1024',
                'mimes:jpeg,png',
            ],
        ];
    }
}
