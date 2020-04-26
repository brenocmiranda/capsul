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
            $table->boolean('ativo');
            $table->string('email_remetente');
            $table->string('nome_remetente');
            $table->integer('avaliar_produto');
            
            $table->timestamps();
        });

        DB::table('config_emails')->insert(
            array(
                'ativo' => 1,
                'email_remetente' => 'contato@grupocapsul.com',
                'nome_remetente' => 'Grupo Capsul',
                'avaliar_produto' => '3',
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
