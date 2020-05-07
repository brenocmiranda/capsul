<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('codigo');
            $table->integer('transacao_pagarme')->nullable();
            $table->string('link_boleto')->nullable();
            $table->double('desconto_aplicado')->nullable();
            $table->double('valor_compra');
            $table->integer('quantidade')->default(1);
            $table->string('ip_compra');
            $table->boolean('carrinho_abandonado')->default(1);
            
            $table->bigInteger('id_produto')->unsigned();
            $table->foreign('id_produto')->references('id')->on('produtos');

            $table->bigInteger('id_cliente')->unsigned()->nullable();
            $table->foreign('id_cliente')->references('id')->on('clientes');

            $table->bigInteger('id_forma_pagamento')->unsigned()->nullable();
            $table->foreign('id_forma_pagamento')->references('id')->on('formas_pagamentos');

            $table->bigInteger('id_endereco')->unsigned()->nullable();
            $table->foreign('id_endereco')->references('id')->on('enderecos');

            $table->bigInteger('id_nota')->unsigned()->nullable();
            $table->foreign('id_nota')->references('id')->on('pedidos_has_notas');

            $table->bigInteger('id_rastreamento')->unsigned()->nullable();
            $table->foreign('id_rastreamento')->references('id')->on('pedidos_has_rastreamento');

            $table->bigInteger('id_avaliacao')->unsigned()->nullable();
            $table->foreign('id_avaliacao')->references('id')->on('avaliacoes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
