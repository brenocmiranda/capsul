<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidosRastreamento extends Model
{
    protected $table = 'pedidos_has_rastreamento';
    protected $primaryKey = 'id';
    protected $fillable = [ 'id', 'tipo', 'valor_envio', 'prazo_envio', 'prazo', 'cod_rastreamento', 'link_rastreamento', 'created_at', 'updated_at' ];
}
