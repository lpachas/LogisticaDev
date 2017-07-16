<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class CredVenta extends Model
{
    protected $table='t_credito';
    protected $primaryKey='ID_Credito';

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
        'Total',
        'Detalle_Total',
        'Saldo_Credito'
    ];
}
