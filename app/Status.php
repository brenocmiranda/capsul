<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'nome', 'descricao', 'posicao'];

    public function RelationPedidos(){
        return $this->belongsToMany(Pedidos::class, 'pedidos_has_status', 'id_status', 'id_pedido');
    }
}
