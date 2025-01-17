<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigCheckout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_checkout', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('api_key');
            $table->string('api_criptografada');
            $table->boolean('text_topo_mostrar');
            $table->boolean('prazo_entrega');
            $table->boolean('cupom_desconto');
            $table->boolean('data_nascimento');
            $table->boolean('data_previsao');
            $table->boolean('maior_parcela');
            $table->boolean('quantidade_itens');
            $table->double('desconto_boleto')->nullable();
            $table->double('desconto_cartao')->nullable();
            $table->string('compras_pessoa');
            $table->string('pagamento_preferencial')->nullable();
            $table->integer('pedidos_ip')->nullable();
            $table->string('tempo_cronometro')->nullable();
            $table->text('texto_topo')->nullable();
            $table->text('texto_entrega')->nullable();
            $table->text('texto_boleto')->nullable();
            $table->string('url_boleto')->nullable();
            $table->string('url_cartao')->nullable();
            
            $table->timestamps();
        });

        DB::table('config_checkout')->insert(
            array(
                'api_key' => 'Fornecido pelo meio de pagamento',
                'api_criptografada' => 'Fornecido pelo meio de pagamento',
                'text_topo_mostrar' => '0',
                'prazo_entrega' => '1',
                'cupom_desconto' => '0',
                'data_nascimento' => '0',
                'data_previsao' => '1',
                'maior_parcela' => '1',
                'quantidade_itens' => '1',
                'desconto_boleto' => '0',
                'desconto_cartao' => '0',
                'compras_pessoa' => 'todos',
                'pagamento_preferencial' => 'cart_Credit',
                'pedidos_ip' => '50',
                'tempo_cronometro' => '10',
                'texto_topo' => '<b>Parabéns!</b> Você conseguiu receber as <b>últimas</b> unidades. Com o <b>Pagamento no Cartão</b> você receberá <b>DESCONTO SUGERIDO</b>.',
                'texto_entrega' => null,
                'texto_boleto' => 'Somente quando recebermos a confirmação, em até 48h após o pagamento, seguiremos com o envio das suas compras. O prazo de entrega passa a ser contado somente após a confirmação do pagamento.',
                'url_boleto' => null,
                'url_cartao' => 'https://nutrimais.top/redutize-upsell/',
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_checkout');
    }
}
