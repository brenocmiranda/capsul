<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigLogistica extends Model
{
    protected $table = 'config_logisticas';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'ativo', 'nome', 'cep_inicial', 'cep_final', 'porcetagem_adicional', 'valor', 'prazo_entrega', 'created_at', 'updated_at'];
}
