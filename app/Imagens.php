<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagens extends Model
{
    protected $table = 'imagens';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'tipo', 'created_at', 'updated_at', 'caminho'];

}
