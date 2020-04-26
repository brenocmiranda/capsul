<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    protected $table = 'emails_para_envio';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'nome', 'identificador', 'descricao', 'corpo'];
}
