<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigLogisticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_logisticas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');          
            $table->boolean('ativo')->default(1);
            $table->string('nome');
            $table->string('cep_inicial');
            $table->string('cep_final');
            $table->double('porcetagem_adicional')->nullable();
            $table->double('valor')->nullable();
            $table->integer('prazo_entrega');

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
        Schema::dropIfExists('config_logisticas');
    }
}
