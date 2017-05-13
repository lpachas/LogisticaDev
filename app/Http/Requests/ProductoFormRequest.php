<?php

namespace SISTEMA_LOGISTICA\Http\Requests;

use SISTEMA_LOGISTICA\Http\Requests\Request;

class ProductoFormRequest extends Request
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
            'Nombre'=>'required|max:100',
            'PU_Publico' => 'required',
            'PU_Ferreteria' => 'required',
            'Stock' => 'required',
            'Stock_Min' => 'required',
            'ID_Marca' => 'required',
            'ID_Categoria' => 'required',
            'ID_Modelo' => 'required',
        ];
    }
}
