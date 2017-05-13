<?php

namespace SISTEMA_LOGISTICA\Http\Requests;

use SISTEMA_LOGISTICA\Http\Requests\Request;

class ModeloFormRequest extends Request
{
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
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:255',
        ];
    }
}
