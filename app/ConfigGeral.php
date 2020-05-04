<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigGeral extends Model
{
   	protected $table = 'config_geral';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'email_pedidos', 'nome_loja', 'descricao_loja', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado', 'complemento', 'razao_social', 'cnpj', 'email', 'telefone', 'whatsapp', 'created_at', 'updated_at'];
}
