<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigEmails extends Model
{
   	protected $table = 'config_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'ativo', 'email_remetente', 'nome_remetente', 'avaliar_produto', 'created_at', 'updated_at'];
}
