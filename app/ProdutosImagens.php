<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutosImagens extends Model
{
    protected $table = 'produtos_has_imagens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'id_produto', 'id_imagem'];

    public function RelationProdutos(){
        return $this->belongsToMany(Produtos::class, 'imagens_has_produtos', 'id_imagem', 'id_produto');
    }
}
