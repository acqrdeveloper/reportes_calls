<?php

namespace Cosapi\Http\Requests;

use Cosapi\Http\Requests\Request;

class UsersChangeRoleRequest extends Request
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
            'nameRole'        => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nameRole.required'          => 'Debes escoger por lo menos un rol'
        ];
    }
}
