<?php

namespace SISTEMA_LOGISTICA\Http\Requests;

use SISTEMA_LOGISTICA\Http\Requests\Request;

class TrabajadorFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'DNI' => 'required|max:12',
            'Nombre' => 'required|max:50',
            'Ap_Paterno' => 'required|max:50',
            'Ap_Materno' => 'required|max:50',
            'Cargo' => 'max:30',
            'Sueldo_Base' => 'numeric',
        ];
    }
}
