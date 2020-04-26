<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuariosGrupos extends Model
{
    protected $table = 'usuarios_grupos';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'nome', 'visualizar_produtos', 'visualizar_marcas', 'visualizar_categorias', 'visualizar_variacoes', 'visualizar_clientes', 'visualizar_pedidos', 'visualizar_leads', 'visualizar_checkout', 'visualizar_usuarios', 'visualizar_logistica', 'visualizar_geral', 'visualizar_dashboard', 'gerenciar_produtos', 'gerenciar_marcas', 'gerenciar_categorias', 'gerenciar_variacoes', 'gerenciar_clientes', 'gerenciar_pedidos', 'gerenciar_leads', 'gerenciar_checkout', 'gerenciar_usuarios', 'gerenciar_logistica', 'gerenciar_geral'];
}
