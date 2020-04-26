<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariacoesProdutosHasOpcoesVariacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variacoes_produtos_has_opcoes_variacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->bigInteger('id_variacao_produto')->unsigned();
            $table->foreign('id_variacao_produto')->references('id')->on('variacoes_produtos');

            $table->bigInteger('id_opcao_variacao')->unsigned();
            $table->foreign('id_opcao_variacao')->references('id')->on('opcoes_variacoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variacoes_produtos_has_opcoes_variacoes');
    }
}
