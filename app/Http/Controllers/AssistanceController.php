<?php

namespace Cosapi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Cosapi\Http\Controllers\AgenteController;
use Cosapi\Models\Anexos;

class AssistanceController extends CosapiController
{
    protected $UserId;
    
    public function __construct(){
        if (!Session::has('UserId')) {
            Session::put('UserId',Auth::user()->id);
        }else{
            $this->UserId       = Session::get('UserId');
        }
    }

    /**
     * @param Request [Datos capturados desde el formulario de asistencia por POST]
     * @param $action [Dato que indica si es un ingreso o salida del sistema]
     * @return        [Redirecciona a la ventana correspondiente al resultado de los eventos realizados]
     */
    public function index(Request $request)
    {
        $ultimate_event_login   = $this->UltimateEventLogin();

        if($ultimate_event_login[0] == 1 && $ultimate_event_login[1]== null){
            //Redirecciona a la ventan de marcaciones
            return 'true&';
        }else{

            if($ultimate_event_login[2] >= date('Y-m-d H:i:s')){
                //Redirecciona a la ventana de espera
                $date = date_create($ultimate_event_login[2]);
                return 'stand_by&'.date_format($date,"H:i:s");
            }
            return 'false&';
        }
    }

}
