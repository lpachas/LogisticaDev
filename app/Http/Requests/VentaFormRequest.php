<?php

namespace SISTEMA_LOGISTICA\Http\Requests;

use SISTEMA_LOGISTICA\Http\Requests\Request;

class VentaFormRequest extends Request
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
            'ID_Cliente'=>'required',
            'ID_Usuario'=>'required',
            'ID_Tipo_Documento'=>'required',
            'Serie'=>'required|max:3',
            'Numero'=>'required|max:7',
            'ID_Forma_Pago'=>'required|max:11',
            'Nro_Dias'=>'required',
            'IGV'=>'required',
            'Total'=>'required',
        ];
    }
}
