<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 't_tipo_usuario';
    protected $primaryKey = 'ID_Tipo_Usuario';

    protected $fillable = [
        'Nombre'
    ];
}
