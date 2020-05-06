<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliacoes extends Model
{
    protected $table = 'avaliacoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'produto', 'satisfacao', 'recomendacao', 'observacoes', 'id_pedido', 'created_at', 'updated_at'];
}
