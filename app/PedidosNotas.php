<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidosNotas extends Model
{
    protected $table = 'pedidos_has_notas';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'numero_nota', 'data_emissao', 'numero_serie', 'chave', 'url_nota', 'id_pedido', 'created_at', 'updated_at'];

}
