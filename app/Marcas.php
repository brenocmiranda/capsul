<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marcas extends Model
{
    protected $table = 'marcas';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'nome', 'ativo', 'mostrar_na_home', 'descricao', 'id_imagem'];

    public function RelationImagens1(){
        return $this->belongsTo(Imagens::class, 'id_imagem');
    }
}
