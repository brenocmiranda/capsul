<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigSeguranca extends Model
{
    protected $table = 'config_seguranca';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'ip_bloqueado', 'created_at', 'updated_at'];
}
