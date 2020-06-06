<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_emails', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('nome_remetente');
            $table->boolean('ativo_avaliacao');
            $table->integer('avaliar_produto');
            $table->boolean('ativo_carrinho');
            $table->enum('enviar_cupom',['s', 'n'])->default('n');
            $table->string('assunto')->nullable();
            $table->string('sms')->nullable();
            
            $table->timestamps();
        });

        DB::table('config_emails')->insert(
            array(
                'email' => 'contato@grupocapsul.com',
                'nome_remetente' => 'Grupo Capsul',
                'avaliar_produto' => '3',
                'ativo_avaliacao' => 1,
                'ativo_carrinho' => 1,
                'enviar_cupom' => 's',
                'assunto' => 'Os produtos que você escolheu estão te esperando, são as últimas unidades, aproveite!',
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
        Schema::dropIfExists('config_emails');
    }
}
