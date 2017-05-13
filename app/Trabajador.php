<?php

namespace SISTEMA_LOGISTICA;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 't_trabajador';
    protected $primaryKey = 'ID_Trabajador';

    protected $fillable = [
        'DNI',
        'Nombre',
        'Ap_Paterno',
        'Ap_Materno',
        'Cargo',
        'Sueldo_Base'
    ];
}
