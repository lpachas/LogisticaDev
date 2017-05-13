<?php

namespace SISTEMA_LOGISTICA\Http\Requests;

use SISTEMA_LOGISTICA\Http\Requests\Request;

class ClienteFormRequest extends Request
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
            'Nombre' => 'required|max:100',
            'Direccion' => 'required|max:255',
            'RUC_DNI' => 'required|max:12',
            'Zona' => 'required|max:100'
        ];
    }
}
