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

        DB::table('config_logisticas')->insert(
            array(
                'nome' => 'Envio normal',
                'cep_inicial' => 00000000,
                'cep_final' => 99999999,
                'porcetagem_adicional' => null,
                'valor' => 29.99,
                'prazo_entrega' => 20,
            )
        );
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
