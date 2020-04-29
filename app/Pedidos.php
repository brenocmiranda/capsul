<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'codigo', 'transacao_pagarme', 'link_boleto', 'desconto_aplicado', 'valor_compra', 'quantidade', 'ip_compra', 'id_produto', 'id_cliente', 'id_forma_pagamento', 'id_endereco', 'id_nota', 'id_rastreamento', 'created_at', 'updated_at'];

    public function RelationProduto(){
        return $this->belongsTo(Produtos::class, 'id_produto');
    }

    public function RelationCliente(){
        return $this->belongsTo(Clientes::class, 'id_cliente');
    }

    public function RelationEndereco(){
        return $this->belongsTo(Enderecos::class, 'id_endereco');
    }

    public function RelationFormaPag(){
        return $this->belongsTo(FormaPagamentos::class, 'id_forma_pagamento', 'id');
    }

    public function RelationTelefones(){
        return $this->belongsTo(Telefones::class, 'id_cliente', 'id_cliente');
    }

    public function RelationNotas(){
        return $this->belongsTo(PedidosNotas::class, 'id_nota', 'id');
    }

    public function RelationStatus(){
        return $this->belongsToMany(Status::class, 'pedidos_has_status', 'id_pedido', 'id_status');
    }

    public function RelationRastreamento(){
        return $this->belongsTo(PedidosRastreamento::class, 'id_rastreamento', 'id');
    }
    
}
