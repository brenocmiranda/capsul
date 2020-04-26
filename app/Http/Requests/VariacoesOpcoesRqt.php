<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariacoesOpcoesRqt extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
        'required' => 'O campo :attribute é obrigatório',
        'string' => 'O campo :attribute deve ser preenchido com texto.',
        ];
    }
}
