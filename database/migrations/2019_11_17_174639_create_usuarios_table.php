<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('ativo')->default(1);
            $table->string('_token');
            $table->rememberToken();
            $table->timestamps();

            $table->bigInteger('id_grupo')->unsigned();
            $table->foreign('id_grupo')->references('id')->on('usuarios_grupos');
            $table->bigInteger('id_imagem')->unsigned()->nullable();
            $table->foreign('id_imagem')->references('id')->on('imagens');
        });

        DB::table('usuarios')->insert(
            array(
                'nome' => 'Administrador',
                'email' => 'administrador@capsul.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('admincapsul123'),
                'ativo' => 1,
                '_token' => 'WqgUCi1UFTgWgP5xsWrxfcWYbLvYEsGIXnuu9iEB6c7tJ8ahrZPRVS0RVDfb',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'id_grupo' => '1',
                'id_imagem' => '1'
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
        Schema::dropIfExists('usuarios');
    }
}
