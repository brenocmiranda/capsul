<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidosStatus extends Model
{
    protected $table = 'pedidos_has_status';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'id_pedido', 'id_status', 'observacoes'];

	public function RelationStatus1(){
        return $this->belongsTo(Status::class, 'id_status');
    }

    public function RelationPedido1(){
        return $this->belongsTo(Pedidos::class, 'id_pedido');
    }
}
