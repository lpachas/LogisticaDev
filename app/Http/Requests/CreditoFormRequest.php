<?php

namespace SISTEMA_LOGISTICA\Http\Requests;

use SISTEMA_LOGISTICA\Http\Requests\Request;

class CreditoFormRequest extends Request
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
            'ID_Doc_Venta'=>'required',
            'ID_Usuario'=>'required',
            'dTotal'=>'required',
            'dPago'=>'required',
            'dSaldo'=>'required'
        ];
    }
}
