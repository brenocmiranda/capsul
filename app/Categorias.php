<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'nome', 'ativo', 'mostrar_na_home', 'sub_categoria', 'ordenar_produtos', 'descricao', 'id_imagem', 'titulo_pagina', 'link_pagina', 'url_cronica', 'id_categoria'];

    public function RelationImagens2(){
        return $this->belongsTo(Imagens::class, 'id_imagem');
    }
}
