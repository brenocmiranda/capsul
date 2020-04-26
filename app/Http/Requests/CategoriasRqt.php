<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriasRqt extends FormRequest
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
                'ativo' => 'nullable',
                'nome' => 'required|string',
                'mostrar_na_home' => 'nullable',
                'sub_categoria' => 'nullable',
                'ordenar_produtos' => 'required|string',
                'descricao' => 'nullable|string',
                'titulo_pagina' => 'nullable|string',
                'link_pagina' => 'nullable|string',
                'descricao_pagina' => 'nullable|string',
                'url_cronica' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
        'required' => 'O campo :attribute é obrigatório',
        'min' => 'O campo :attribute deve possuir no minimo :min caracteres',
        'unique' => 'O contrato já foi adicionado!',
        ];
    }
}
