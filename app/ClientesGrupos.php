<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    protected $table = 'clientes_grupos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'nome', 'ativo', 'tipo', 'pedido_minimo', 'operacao', 'porcentagem', 'inserrir_novos_clientes'];
}
