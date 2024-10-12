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
                'nullable',  // Torna o campo opcional em ambos os casos (criação e edição)
                'image',     // Verifica se é uma imagem
                'max:1024',  // Limita o tamanho máximo a 1024 KB
                'mimes:jpeg,png',  // Aceita apenas arquivos JPEG ou PNG
            ],
        ];
    }
}
