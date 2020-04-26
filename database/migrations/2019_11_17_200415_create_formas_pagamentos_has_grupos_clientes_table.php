<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormasPagamentosHasGruposClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formas_pagamentos_has_grupos_clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('id_grupo_cliente')->unsigned();
            $table->foreign('id_grupo_cliente')->references('id')->on('clientes_grupos');
            $table->bigInteger('id_forma_pagamento')->unsigned();
            $table->foreign('id_forma_pagamento')->references('id')->on('formas_pagamentos');

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
        Schema::dropIfExists('formas_pagamentos_has_grupos_clientes');
    }
}
