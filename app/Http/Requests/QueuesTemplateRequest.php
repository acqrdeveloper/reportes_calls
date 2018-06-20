<?php

namespace Cosapi\Http\Requests;

use Cosapi\Http\Requests\Request;

class QueuesTemplateRequest extends Request
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
            'nameTemplateQueue'         => 'required',
            'selectedMusicOnHold'       => 'required',
            'selectedJoinEmpty'         => 'required',
            'timeOut'                   => 'required|numeric|between:1,10',
            'memberDelay'               => 'required|numeric|between:1,10',
            'selectedRingInUse'         => 'required',
            'selectedAutoPause'         => 'required',
            'selectedAutoPauseBusy'     => 'required',
            'wrapUptime'                => 'required|numeric|between:1,10',
            'maxLen'                    => 'required|numeric|between:0,10',
        ];
    }

    public function messages()
    {
        return [
            'nameTemplateQueue.required'        => 'Debes ingresar un nombre para el template',
            'selectedMusicOnHold.required'      => 'Debes escoger un Music On Hold',
            'selectedJoinEmpty.required'        => 'Debes escoger una opción de JoinEmpty',
            'timeOut.required'                  => 'Debes ingresar un tiempo para el timeOut',
            'memberDelay.required'              => 'Debes ingresar un tiempo para el memberDelay',
            'selectedRingInUse.required'        => 'Debes escoger una opción de RingInUse',
            'selectedAutoPause.required'        => 'Debes escoger una opción de AutoPause',
            'selectedAutoPauseBusy.required'    => 'Debes escoger una opción de AutoPause Busy',
            'wrapUptime.required'               => 'Debes ingresar un tiempo para el wrapUpTime',
            'maxLen.required'                   => 'Debes ingresar un tiempo para el maxLen',
            'timeOut.digits_between'            => 'El TimeOut debe ser minimo 1 y maximo 10',
            'memberDelay.digits_between'        => 'El memberDelay debe ser minimo 1 y maximo 10',
            'wrapUptime.digits_between'         => 'El wrapUptime debe ser minimo 1 y maximo 10',
            'maxLen.digits_between'             => 'El maxLen debe ser minimo 0 y maximo 10'
        ];
    }
}
