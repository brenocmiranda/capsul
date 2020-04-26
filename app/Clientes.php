<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'tipo', 'ativo', 'nome', 'email', 'documento', 'data_nascimento', 'observacoes', 'senha', 'id_grupo_cliente', 'id_lead'];

    public function RelationPedido(){
        return $this->hasOne(Produtos::class, 'id');
    }

    public function RelationTelefone(){
        return $this->belongsTo(Telefones::class, 'id', 'id_cliente');
    }

    public function RelationEnderecos(){
    	return $this->hasMany(Enderecos::class, 'id_cliente', 'id');
    }
}
