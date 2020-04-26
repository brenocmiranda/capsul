<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefones extends Model
{
    protected $table = 'telefones';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'numero', 'id_cliente'];
    
}
