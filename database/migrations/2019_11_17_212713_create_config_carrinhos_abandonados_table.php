<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigCarrinhosAbandonadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_carrinhos_abandonados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->boolean('ativo');
            $table->enum('enviar_cupom',['s', 'n'])->default('n');
            $table->string('assunto')->nullable();
            $table->string('sms')->nullable();

            $table->timestamps();
        });

        DB::table('config_carrinhos_abandonados')->insert(
            array(
                'ativo' => '1',
                'enviar_cupom' => 's',
                'assunto' => 'Os produtos que você escolheu estão te esperando',
                'sms' => 'Os produtos que você escolheu estão te esperando',
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
        Schema::dropIfExists('config_carrinhos_abandonados');
    }
}
