<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->enum('ativo',['s','n'])->default('s');
            $table->enum('variante',['s','n'])->default('n');
            $table->enum('tipo',['digital','fisico'])->default('fisico');        
            $table->string('nome');
            $table->string('link_produto')->nullable();
            $table->string('pixels_facebook')->nullable();
            $table->enum('disponivel_venda',['s','n'])->default('s');
            $table->string('cod_sku');
            $table->string('cod_ean')->nullable();;
            $table->double('preco_custo')->nullable();;
            $table->double('preco_venda');
            $table->double('preco_promocional')->nullable();
            $table->double('peso');
            $table->double('largura');
            $table->double('altura');
            $table->double('comprimento');
            $table->double('quantidade');
            $table->double('quantidade_minima')->default(0);
            $table->longText('detalhes_produto')->nullable();
            $table->enum('prazo_postagem',['0', '1', '2', '3', '4', '5', '6', '7', '15', '20', '25', '30', '35', '40', '45', '50'])->default('0');
            $table->enum('estoque_em_zero',['indisponivel', '0', '1', '2', '3', '4', '5', '6', '7', '15', '20', '25', '30', '35', '40', '45', '50'])->default('indisponivel');
            
            $table->bigInteger('id_marca')->unsigned();
            $table->foreign('id_marca')->references('id')->on('marcas');
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
        Schema::dropIfExists('produtos');
    }
}
