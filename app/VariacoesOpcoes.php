<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariacoesOpcoes extends Model
{
    protected $table = 'variacoes_opcoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'created_at', 'updated_at'];
}
