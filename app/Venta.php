<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='t_doc_venta';
    protected $primaryKey='ID_Doc_Venta';

    protected $fillable=[
        'ID_Cliente',
        'ID_Usuario',
        'ID_Tipo_Documento',
        'Serie',
        'Numero',
        'FechaVenta_Actual',
        'ID_Forma_Pago',
        'Estado',
        'FechaVenta_Credito',
        'Nro_Dias',
        'IGV',
        'Subtotal',
        'SubIGV',
        'Total'
    ];

}
