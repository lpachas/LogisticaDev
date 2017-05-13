<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 't_cliente';
    protected $primaryKey = 'ID_Cliente';

    protected $fillable = [
        'Nombre',
        'Dirección',
        'RUC_DNI',
        'Telefono',
        'Zona'
    ];
}
