<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Tipo_Documento extends Model
{
    protected $table='t_tipo_documento';
    protected $primaryKey='ID_Tipo_Documento';

    protected $fillable=[
        'Descripcion_Doc',
        'Serie',
        'Numero'
    ];
}
