<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atividades extends Model
{
    protected $table = 'activities';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'descricao', 'icone', 'url', 'id_usuario', 'created_at', 'updated_at'];
}
