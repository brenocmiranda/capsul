<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_grupos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nome')->unique();
            $table->boolean('visualizar_produtos')->nullable();
            $table->boolean('visualizar_marcas')->nullable();
            $table->boolean('visualizar_categorias')->nullable();
            $table->boolean('visualizar_variacoes')->nullable();
            $table->boolean('visualizar_clientes')->nullable();
            $table->boolean('visualizar_pedidos')->nullable();
            $table->boolean('visualizar_leads')->nullable();
            $table->boolean('visualizar_checkout')->nullable();
            $table->boolean('visualizar_usuarios')->nullable();
            $table->boolean('visualizar_logistica')->nullable();
            $table->boolean('visualizar_geral')->nullable();
            $table->boolean('visualizar_dashboard')->nullable();
            $table->boolean('gerenciar_produtos')->nullable();
            $table->boolean('gerenciar_marcas')->nullable();
            $table->boolean('gerenciar_categorias')->nullable();
            $table->boolean('gerenciar_variacoes')->nullable();
            $table->boolean('gerenciar_clientes')->nullable();
            $table->boolean('gerenciar_pedidos')->nullable();
            $table->boolean('gerenciar_leads')->nullable();
            $table->boolean('gerenciar_checkout')->nullable();
            $table->boolean('gerenciar_usuarios')->nullable();
            $table->boolean('gerenciar_logistica')->nullable();
            $table->boolean('gerenciar_geral')->nullable();
        });

        DB::table('usuarios_grupos')->insert(
            array(
                'nome' => 'Administradores',
                'visualizar_produtos' => 1,
                'visualizar_marcas' => 1,
                'visualizar_categorias' => 1,
                'visualizar_variacoes' => 1,
                'visualizar_clientes' => 1,
                'visualizar_pedidos' => 1,
                'visualizar_leads' => 1,
                'visualizar_checkout' => 1,
                'visualizar_usuarios' => 1,
                'visualizar_logistica' => 1,
                'visualizar_geral' => 1,
                'visualizar_dashboard' => 1,
                'gerenciar_produtos' => 1,
                'gerenciar_marcas' => 1,
                'gerenciar_categorias' => 1,
                'gerenciar_variacoes' => 1,
                'gerenciar_clientes' => 1,
                'gerenciar_pedidos' => 1,
                'gerenciar_leads' => 1,
                'gerenciar_checkout' => 1,
                'gerenciar_usuarios' => 1,
                'gerenciar_logistica' => 1,
                'gerenciar_geral' => 1,
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
        Schema::dropIfExists('usuarios_grupos');
    }
}
