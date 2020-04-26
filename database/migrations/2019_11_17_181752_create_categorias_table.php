<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('nome');
            $table->enum('ativo',['s','n'])->default('s');
            $table->enum('mostrar_na_home',['s','n'])->default('s');
            $table->enum('sub_categoria',['s','n'])->default('n');
            $table->enum('ordenar_produtos',['mais vendidos', 'maior preço', 'menor preço', 'melhor avaliado', 'relevancia', 'lançamentos', 'a-z', 'z-a', 'randômico'])->default('relevancia');
            $table->longText('descricao')->nullable();
            $table->string('titulo_pagina')->nullable();
            $table->string('link_pagina')->nullable();
            $table->string('url_cronica')->nullable();
            $table->string('descricao_pagina')->nullable();

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
        Schema::dropIfExists('categorias');
    }
}
