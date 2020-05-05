<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigEmails extends Model
{
   	protected $table = 'config_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'ativo_avaliacao', 'email_remetente', 'nome_remetente', 'avaliar_produto', 'ativo_carrinho', 'enviar_cupom', 'assunto', 'sms', 'created_at', 'updated_at'];
}
