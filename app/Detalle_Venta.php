<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Detalle_Venta extends Model
{
    protected $table='t_detalle_doc_venta';
    protected $primaryKey='ID_Detalle_Doc_Venta';

    protected $fillable=[
        'ID_Doc_Venta',
        'ID_Producto',
        'Cantidad',
        'Precio',
        'Descuento',
        'Subtotal'
    ];
}
