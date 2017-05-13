<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 't_modelo';
    protected $primaryKey = 'ID_Modelo';

    protected $fillable = [
        'Nombre',
        'Descripcion'
    ];
}
