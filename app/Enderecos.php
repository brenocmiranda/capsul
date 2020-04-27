<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enderecos extends Model
{
    protected $table = 'enderecos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'status', 'destinatario', 'cep', 'endereco', 'numero', 'complemento', 'referencia', 'bairro', 'cidade', 'estado', 'id_cliente', 'created_at', 'updated_at'];
}
