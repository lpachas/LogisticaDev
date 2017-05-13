<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='t_producto';
    protected $primaryKey='ID_Producto';

    protected $fillable=[
        'Nombre',
        'PU_Publico',
        'PU_Ferreteria',
        'Stock',
        'Stock_Min',
        'ID_Marca',
        'ID_Categoria',
        'ID_Modelo'
    ];
}
