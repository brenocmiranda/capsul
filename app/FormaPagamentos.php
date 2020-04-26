<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPagamentos extends Model
{
    protected $table = 'formas_pagamentos';
    protected $primaryKey = 'id';
    protected $fillable = ["id", "created_at", "updated_at", "nome", "cod"];
}
