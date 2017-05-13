<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 't_marca';
    protected $primaryKey = 'ID_Marca';

    protected $fillable = [
        'Nombre',
        'Descripcion'
    ];
}
