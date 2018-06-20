<?php

namespace Cosapi\Http\Requests;

use Cosapi\Http\Requests\Request;

class UsersChangePasswordRequest extends Request
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
            'newPassword'        => 'required|min:8|max:12',
            'confirmNewPassword' => 'required|same:newPassword'
        ];
    }

    public function messages()
    {
        return [
            'newPassword.required'          => 'Debes ingresar una nueva contraseña',
            'confirmNewPassword.required'   => 'Debes repetir la nueva contraseña',
            'newPassword.min'               => 'La contraseña debe tener minimo 8 caracteres',
            'newPassword.max'               => 'La contraseña debe tener maximo 12 caracteres',
            'confirmNewPassword.same'       => 'Debes ingresar la misma contraseña en los dos campos'
        ];
    }
}
