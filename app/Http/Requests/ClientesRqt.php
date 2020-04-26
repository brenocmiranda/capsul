<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientesRqt extends FormRequest
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
                'status' => 'nullable',
                'nome' => 'required|string',
                'tipo' => 'required|string',
                'documento' => 'required|string',
                'data_nascimento' => 'date',
                'email' => 'required|string',
                'password' => 'nullable|string',
                'apelido' => 'required|string',
                'sexo' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
        'required' => 'O campo :attribute é obrigatório',
        'min' => 'O campo :attribute deve possuir no minimo :min caracteres',
        'unique' => 'O contrato já foi adicionado!',
        'numeric' => 'O campo :attribute só aceita valores númericos.',
        'date' => 'A data não é válida.',
        ];
    }
}
