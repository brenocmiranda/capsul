<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutosVariacoes extends Model
{
    protected $table = 'produtos_has_variacoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'id_variacao', 'id_produto', 'created_at', 'updated_at'];
}
