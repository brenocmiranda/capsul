<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigCarrinhos extends Model
{
    protected $table = 'config_carrinhos_abandonados';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'ativo', 'enviar_cupom', 'assunto', 'sms', 'created_at', 'updated_at'];

}
