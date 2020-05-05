<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigGeral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_geral', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('nome_loja');
            $table->string('descricao_loja');

            $table->string('cep');
            $table->string('endereco');
            $table->string('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('complemento')->nullable();

            $table->string('razao_social');
            $table->string('cnpj');
            $table->string('email');
            $table->string('telefone');
            $table->string('whatsapp');
            
            $table->timestamps();
        });

        DB::table('config_geral')->insert(
            array(
                'email_pedidos' => 'suporte@capsulbrasil.com.br',
                'nome_loja' => 'Grupo Capsul',
                'descricao_loja' => 'Somos uma empresa que trabalha com os melhores produtos para os clientes mais exigentes e que merecem o santo graal de qualidade.',
                'cep' => '35588000',
                'endereco' => 'RUA TRAVESSA NOSA SENHORA DO CARMO',
                'numero' => '35',
                'bairro' => 'CENTRO',
                'cidade' => 'ARCOS',
                'estado' => 'MG',
                'complemento' => '',
                'razao_social' => 'Capsul Brasil',
                'cnpj' => '29822523000103',
                'email' => 'contato@capsulbrasil.com',
                'telefone' => '(37) 3351-5181',
                'whatsapp' => '(37) 3351-5181',
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
        Schema::dropIfExists('config_geral');
    }
}
