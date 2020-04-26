<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'ativo', 'variante', 'tipo', 'nome', 'link_produto', 'id_marca', 'pixels_facebook', 'disponivel_venda', 'cod_sku', 'cod_ean', 'preco_custo', 'preco_venda', 'preco_promocional', 'peso', 'largura', 'altura', 'comprimento', 'quantidade', 'quantidade_minima', 'destalhes_produto', 'id_variacao', 'prazo_postagem', 'estoque_em_zero'];

    public function RelationImagens(){
    	return $this->belongsToMany(Imagens::class, 'produtos_has_imagens', 'id_produto', 'id_imagem')->where('tipo', '<>' ,'produtos_principal');
    }

    public function RelationImagensPrincipal(){
        return $this->belongsToMany(Imagens::class, 'produtos_has_imagens', 'id_produto', 'id_imagem')->where('tipo', 'produtos_principal');
    }

    public function RelationMarcas(){
        return $this->belongsTo(Marcas::class, 'id_marca');
    }

    public function RelationProdutosCategorias(){
    	return $this->belongsToMany(Categorias::class, 'produtos_has_categorias', 'id_produto', 'id_categoria');
    }

    public function RelationProdutosVariacoes(){
    	return $this->belongsToMany(Variacoes::class, 'produtos_has_variacoes', 'id_produto', 'id_variacao');
    }
    
}
