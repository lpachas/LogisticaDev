<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $table='t_pago_credito';
    protected $primaryKey='ID_Pago';

    protected $fillable=[
        'ID_Doc_Venta',
        'dTotal',
        'dPago',
        'dSaldo',
    ];
}
