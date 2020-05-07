<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nome', 'email', 'email_verified_at',  'ativo', 'created_at', 'updated_at', 'id_grupo', 'id_imagem'];
    protected $hidden = ['_token', 'remember_token','password'];

    public function RelationImagens(){
        return $this->belongsTo(Imagens::class, 'id_imagem');
    }

    public function RelationGrupo(){
        return $this->belongsTo(UsuariosGrupos::class, 'id_grupo');
    }

    public function RelationAtividades(){
        return $this->belongsTo(Atividades::class, 'id', 'id_usuario')->where('icone', 'mdi-logout')->latest('created_at');
    }
}
