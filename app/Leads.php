<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    protected $table = 'leads';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'created_at', 'updated_at', 'nome', 'email'];
}
