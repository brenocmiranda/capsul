<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');            
            $table->string('nome');
            $table->enum('ativo',['s','n'])->default('s');
            $table->enum('mostrar_na_home',['s','n'])->default('s');
            $table->longText('descricao')->nullable();
            $table->bigInteger('id_imagem')->unsigned()->nullable();
            $table->foreign('id_imagem')->references('id')->on('imagens');
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
        Schema::dropIfExists('marcas');
    }
}
