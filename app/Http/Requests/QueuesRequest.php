<?php

namespace Cosapi\Http\Requests;

use Cosapi\Http\Requests\Request;

class QueuesRequest extends Request
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
            'nameQueue'           => 'required|unique:queues,name,'.$this->queueID,
            'numVdn'              => 'required|min:4|max:5|unique:queues,vdn,'.$this->queueID,
            'selectedStrategy'    => 'required',
            'selectedPriority'    => 'required',
            'selectedTemplate'    => 'required',
            'limitCallWaiting'    => 'required',
            'selectedMusic'       => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nameQueue.required'            => 'Debes ingresar un nombre para la Cola (Queue)',
            'numVdn.required'               => 'Debes ingresar un número VDN',
            'numVdn.min'                    => 'El número de VDN debe ser minimo de 4 números',
            'numVdn.max'                    => 'El número de VDN debe ser máximo de 5 números',
            'selectedStrategy.required'     => 'Debes escoger una Estrategia',
            'selectedPriority.required'     => 'Debes escoger una Prioridad',
            'selectedTemplate.required'     => 'Debes escoger un Template',
            'limitCallWaiting.required'     => 'Debes colocar un limite de llamadas encoladas',
            'selectedMusic.required'        => 'Debes escoger una musica para la cola',
            'nameQueue.unique'              => 'El nombre de la Cola ingresada ya existe',
            'numVdn.unique'                 => 'El número de VDN ingresado, ya existe'
        ];
    }
}
