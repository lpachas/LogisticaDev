<?php

namespace SISTEMA_LOGISTICA\Http\Requests;

use SISTEMA_LOGISTICA\Http\Requests\Request;

class CargarPerfilesRequest extends Request
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
            'name'=>'max:250|required'
        ];
    }
}
