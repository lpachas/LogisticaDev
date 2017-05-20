<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    protected $table='t_kardex';
    protected $primaryKey='ID_Kardex';

    protected $fillable=[
        'ID_Usuario',
        'ID_Producto',
        'Fecha',
        'Cantidad',
        'Descripcion'
    ];
}
