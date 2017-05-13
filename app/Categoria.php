<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 't_categoria';
    protected $primaryKey = 'ID_Categoria';

    protected $fillable = [
        'Nombre',
        'Descripcion'
    ];
}
