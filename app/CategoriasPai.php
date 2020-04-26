<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriasPai extends Model
{
    protected $table = 'categorias_has_categorias';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'id_categoria', 'id_categoria_pai'];
}
