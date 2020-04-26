<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosRqt extends FormRequest
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
                'variante' => 'required',
                'tipo' => 'required',
                'nome' => 'required|string',
                'link' => 'nullable|string',
                'pixels_facebook' => 'nullable|string',
                'url_redirect_cartao' => 'nullable|string',
                'url_redirect_boleto' => 'nullable|string',
                'disponivel_venda' => 'nullable',
                'cod_sku' => 'required|string',
                'cod_ean' => 'nullable|integer',
                'preco_custo' => 'nullable|string',
                'preco_venda' => 'required|string',
                'preco_promocional' => 'nullable|string',
                'peso' => 'nullable|numeric',
                'largura' => 'nullable|numeric',
                'altura' => 'nullable|numeric',
                'comprimento' => 'nullable|numeric',
                'quantidade' => 'required|integer',
                'quantidade_minima' => 'nullable|integer',
                'destalhes_produto' => 'nullable|string',
                'prazo_postagem' => 'nullable|integer',
                'estoque_em_zero' => 'nullable|string',
                'id_variacao' => 'nullable|integer',
                'id_marca' => 'required|integer',
                'imagem_principal' => 'required|string',
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
