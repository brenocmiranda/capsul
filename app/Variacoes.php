<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variacoes extends Model
{
    protected $table = 'variacoes';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'valor', 'id_opcao', 'created_at', 'updated_at'];
}
