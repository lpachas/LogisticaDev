<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table = 't_membresia';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ID_Usuario','ID_Tipo_Usuario', 'Estado','Descripcion',
    ];

    protected $casts = [
        'ID_Usuario' => 'integer',
        'ID_Tipo_Usuario' => 'integer',
    ];
}
