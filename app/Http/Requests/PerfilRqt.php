<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerfilRqt extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'nome' => 'required|string',
                'email' => 'required|email',
                'id_imagem' => 'nullable|image',
                'password' => 'nullable|confirmed',
        ];
    }

    public function messages()
    {
        return [
        'required' => 'O campo :attribute é obrigatório.',
        'email' => 'O campo :attribute aceita somente e-mails.',
        'string' => 'O campo :attribute só aceita de texto.',
        'image' => 'O campo :attribute só aceita imagens.',
        'confirmed' => 'A combinação de senhas preenchidas não conferem.'
        ];
    }
}
