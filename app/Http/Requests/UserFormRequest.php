<?php

namespace SISTEMA_LOGISTICA\Http\Requests;

use SISTEMA_LOGISTICA\Http\Requests\Request;

class UserFormRequest extends Request
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
            'ID_Trabajador' => 'required',
            'name' => 'required|min:3|max:80',
            'email' => 'required', //unique:users(verifica que el email ya existe en la tabla user)
            'password' => 'required|min:4|max:120',
            'Descripcion' => 'max:255',
            'tipos'=>'max:20',
        ];
    }
}
