<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->enum('tipo',['pf','pj'])->default('pf');         
            $table->boolean('ativo')->default(1);
            $table->string('nome');
            $table->string('email');
            $table->string('documento');
            $table->date('data_nascimento')->nullable();
            $table->longText('observacoes')->nullable();
            $table->string('senha')->nullable();
            $table->bigInteger('id_grupo_cliente')->unsigned()->nullable();
            $table->foreign('id_grupo_cliente')->references('id')->on('clientes_grupos');
            $table->bigInteger('id_lead')->unsigned();
            $table->foreign('id_lead')->references('id')->on('leads');

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
        Schema::dropIfExists('clientes');
    }
}
