<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GruposUsuariosRqt extends FormRequest
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
                'ver_pedidos' => 'nullable|string',
                'edit_pedidos' => 'nullable|string', 
                'ver_carrinhos' => 'nullable|string', 
                'edit_carrinhos' => 'nullable|string', 
                'ver_produtos' => 'nullable|string',                        
                'edit_produtos' => 'nullable|string', 
                'ver_marcas' => 'nullable|string', 
                'edit_marcas' => 'nullable|string', 
                'ver_categorias' => 'nullable|string', 
                'edit_categorias' => 'nullable|string', 
                'ver_variacoes' => 'nullable|string', 
                'edit_variacoes' => 'nullable|string', 
                'ver_clientes' => 'nullable|string', 
                'edit_clientes' => 'nullable|string', 
                'ver_leads' => 'nullable|string', 
                'edit_leads' => 'nullable|string', 
                'ver_relatorios' => 'nullable|string', 
                'edit_relatorios' => 'nullable|string', 
                'ver_lojas' => 'nullable|string', 
                'edit_lojas' => 'nullable|string', 
                'ver_instituicoes' => 'nullable|string', 
                'edit_instituicoes' => 'nullable|string', 
                'ver_usuarios' => 'nullable|string', 
                'edit_usuarios' => 'nullable|string', 
                'ver_grupos_usuarios' => 'nullable|string',
                'edit_grupos_usuarios' => 'nullable|string',
                'ver_configuracoes' => 'nullable|string',
                'edit_configuracoes' => 'nullable|string', 
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }
}
