<?php

namespace Cosapi\Http\Requests;

use Cosapi\Http\Requests\Request;

class UsersAssignQueuesRequest extends Request
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
            'checkQueue'           => 'required',
            'selectPriority'       => 'required'
        ];
    }

    public function messages()
    {
        return [
            'checkQueue.required'          => 'Se debe eleguir por lo menos una cola',
            'selectPriority.required'      => 'Se debe escoger una prioridad para la cola seleccionada'
        ];
    }
}
