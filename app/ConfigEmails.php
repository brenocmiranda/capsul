<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ConfigEmails extends Model
{
	use Notifiable;

   	protected $table = 'config_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'ativo_avaliacao', 'email', 'nome_remetente', 'avaliar_produto', 'ativo_carrinho', 'enviar_cupom', 'assunto', 'sms', 'created_at', 'updated_at'];
}
