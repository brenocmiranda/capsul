<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_grupos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->boolean('ativo')->default(1);
            $table->string('nome');
            $table->enum('tipo',['pj','pf'])->default('pf');
            $table->double('pedido_minimo')->nullable();
            $table->enum('operacao',['adicionar', 'subtrair'])->nullable();
            $table->double('porcentagem')->nullable();
            $table->enum('inserrir_novos_clientes',['s','n'])->nullable();

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
        Schema::dropIfExists('clientes_grupos');
    }
}
