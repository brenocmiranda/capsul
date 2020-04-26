<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesGruposHasFormasEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_grupos_has_formas_envios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('id_grupo_cliente')->unsigned();
            $table->foreign('id_grupo_cliente')->references('id')->on('clientes_grupos');
            $table->bigInteger('id_forma_envio')->unsigned();
            $table->foreign('id_forma_envio')->references('id')->on('clientes_grupos');

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
        Schema::dropIfExists('clientes_grupos_has_formas_envios');
    }
}
