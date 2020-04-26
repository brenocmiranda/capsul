<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescontosFretesHasGruposClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descontos_fretes_has_grupos_clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('id_desconto_frete')->unsigned();
            $table->foreign('id_desconto_frete')->references('id')->on('descontos_fretes');
            $table->bigInteger('id_grupo_cliente')->unsigned();
            $table->foreign('id_grupo_cliente')->references('id')->on('clientes_grupos');

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
        Schema::dropIfExists('descontos_fretes_has_grupos_clientes');
    }
}
