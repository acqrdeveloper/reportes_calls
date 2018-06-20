<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Facades\phpAMI;
use Log;

use Cosapi\Http\Requests;
use Cosapi\Http\Controllers\Controller;

class AsteriskController extends Controller
{
    public function index()
    {
        if ($this->connectAMI()) {
            $channel = "SIP/5198";
            $exten = "5199";
            $context = "salidas-anexos-internos";
            $priority = 1;
            $callerid = null;
            $timeout = null;
            $account = null;
            $codecs = null;
            $variable = null;
            $aplication = null;
            $data = null;
            $async = true;

            $response = phpAMI::originate($channel, $exten, $context, $priority, $callerid, $timeout, $account, $codecs, $variable, $aplication, $data, $async);
            //$response = phpAMI::listCommands();
            dd($response);
            $this->disconnectAMI();
        }
    }

    /**
     * Abrir conexion ami, hacia el asterisk a traves del puerto del manager.conf (Archivo Asterisk)
     * @return bool
     */
    protected function connectAMI()
    {
        $response = phpAMI::login('172.11.1.30', 'dashboard', 'zaxA5rA@a', '5023');
        if ($response['Response'] === "Error") {
            Log::error('Conection PHPAMI : '.$response['Message']);
            Log::error('Conection PHPAMI : Problemas en el usuario y password de la Conexion Manager');
            echo 'Conection PHPAMI : Problemas en el usuario y password de la Conexion Manager';
            return false ;
        }

        return true;
    }


    /**
     * Desconectar session de ami.
     */
    protected function disconnectAMI()
    {
        phpAMI::logoff();
    }
}
