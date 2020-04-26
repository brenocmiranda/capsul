<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigCheckout extends Model
{
   	protected $table = 'config_checkout';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'api_key', 'api_criptografada', 'endereco_cliente', 'prazo_entrega', 'calculo_frete', 'cupom_desconto', 'data_nascimento', 'data_previsao', 'maior_parcela', 'quantidade_itens', 'desconto_boleto', 'desconto_cartao', 'compras_pessoa', 'pagamento_preferencial', 'pedidos_ip', 'tempo_cronometro', 'telefone', 'texto_topo', 'texto_entrega', 'texto_boleto', 'url_boleto', 'url_cartao', 'created_at', 'updated_at'];
}
