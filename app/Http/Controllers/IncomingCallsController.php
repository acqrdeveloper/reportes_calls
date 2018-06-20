<?php

namespace Cosapi\Http\Controllers;

use Illuminate\Http\Request;
use Cosapi\Models\Queue_Log;
use Cosapi\Collector\Collector;

use DB;
use Excel;
use Carbon\Carbon;
use Session;


class IncomingCallsController extends CosapiController
{

    /**
     * [index Función que retorna vista o datos al reporte Incoming Calls]
     * @param  Request $request [Retorna datos enviados por POST]
     * @return [view]           [Vista o Array con datos del reporte Incoming Calls]
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            if ($request->evento){
                return $this->calls_incoming($request->fecha_evento, $request->evento);
            }else{

                $arrayReport = $this->reportAction(array(
                    'boxReport','dateHourFilter','dateFilter','viewDateSearch','viewButtonExport','viewCustomFilter'
                ),'');

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.incoming_calls.tabs_incoming_calls',
                    'titleReport'           => 'Report of Calls Inbound',
                    'exportReport'          => 'export_incoming',
                    'nameRouteController'   => ''
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }
    }


    /**
     * [export Función que permite exportar el reporte de Incoming Calls]
     * @param  Request $request [Retorna datos enviados por POST]
     * @return [array]          [Array con la ubicación de los archivos exportados]
     */
    public function export(Request $request){
        $export_contestated  = call_user_func_array([$this,'export_'.$request->format_export], [$request->days]);
        return $export_contestated;
    }


    /**
     * [calls_incoming Función que obtiene los datos para las llamadas entrante]
     * @param  [string] $fecha_evento [Fecha de la consulta del reporte]
     * @param  [string] $evento       [Tipo de reporte a consultar (Atendidas, Transferidas o Abandonadas)]
     * @return [array]                [Array con datos de las llamadas entrantes]
     */
    protected function calls_incoming($fecha_evento, $evento){
        $query_calls        = $this->query_calls($fecha_evento,$evento);
        $builderview        = $this->builderview($query_calls);
        $incomingcollection = $this->incomingcollection($builderview);
        $calls_incoming     = $this->FormatDatatable($incomingcollection);
        return $calls_incoming;
    }


    /**
     * [query_calls Funcción que consulta en la base de datos las llamadas de entrantes]
     * @param  [string] $days   [Fecha de consulta]
     * @param  [array] $events  [Eventos de las llamadas]
     * @param  [string] $users  [Id del usuario]
     * @param  [string] $hours  [Hora de de la llamda, Ejem: 18:52]
     * @return [array]          [Array con los datos de llamadas entrantes]
     */
    public function query_calls($days,$events,$username ='', $hours ='')
    {
        $queues_proyect = $this->queues_proyect();
        $days           = explode(' - ', $days);
        $events         = $this->get_events($events);
        $query_calls    = Queue_Log::select_fechamod()
                                        ->filtro_usernameSearch($username)
                                        ->filtro_user_rol($this->UserRole,$this->UserSystem)
                                        ->filtro_tabla()
                                        ->filtro_hours($hours)
                                        ->filtro_days($days)
                                        ->filtro_events($events)
                                        ->whereIn('queue', $queues_proyect)
                                        ->OrderBy('id')
                                        ->get()
                                        ->toArray();  
        
        return $query_calls;
    }

    /**
     * [get_events Función que muestra los eventos en base a la acción a realizar]
     * @param  [string] $events [Tipo de reportes de Llamadas]
     * @return [array]          [Eventos que comforman el tipo de reporte]
     */
    protected function get_events($events){

        switch($events){
            case 'calls_completed' :
                $events             = array ('COMPLETECALLER', 'COMPLETEAGENT', 'TRANSFER', 'BLINDTRANSFER');
            break;
            case 'calls_transfer' :
                $events             = array ('TRANSFER', 'BLINDTRANSFER');
            break;
            case 'calls_abandone' :
                $events             = array ('ABANDON');
            break;
        }
        return $events;
    }


    /**
     * [builderview Función que prepara los datos para mostrar en la vista]
     * @param  [array] $query_calls [Array con los datos de llamadas entrantes]
     * @return [array]              [Array modificado para mostrar en el reporte de Incoming Calls]
     */
    protected function builderview($query_calls){
        $action = '';
        $posicion = 0;
        $builderview = [];

        //dd(getenv('FORMAT_DATE'));

        foreach ($query_calls as $query_call) {
            $builderview[$posicion]['date']        = date(getenv('FORMAT_DATE'), strtotime($query_call['fechamod']));
            $builderview[$posicion]['hour']        = $query_call['timemod'];
            $builderview[$posicion]['telephone']   = $query_call['clid'];
            $builderview[$posicion]['agent']       = ExtraerAgente($query_call['agent']);
            $builderview[$posicion]['skill']       = $query_call['queue'];
            $builderview[$posicion]['duration']    = conversorSegundosHoras(abs($query_call['info2']),false);

            switch ($query_call['event']) {
                case 'TRANSFER':
                    $action = 'Transferido a '.$query_call['url'];
                    break;
                case 'BLINDTRANSFER':
                    $action = 'Transferido a '.$query_call['url'];
                    break;
                case 'ABANDON':
                    $action = 'Abandonada';
                    break;
                case 'COMPLETECALLER':
                    $action = 'Colgo Cliente';
                    break;
                default:
                    $action = 'Colgo Agente';
                    break;
            }

            $builderview[$posicion]['action']      = $action;
            $builderview[$posicion]['waittime']    = conversorSegundosHoras(abs($query_call['info1']),false);
            $posicion ++;
        }

        return $builderview;
    }


    /**
     * [incomingcollection Función que permite pasar de Array a Collection los datos del reporte Incoming Calls]
     * @param  [array]      $builderview [Array con los datos de llamdas entrantes]
     * @return [collection]              [Collection con los datos de llamadas entrantes]
     */
    protected function incomingcollection($builderview){
        $incomingcollection                 = new Collector;
        foreach ($builderview as $view) {

            $colas          = $this->list_vdn();
            $vdn            = $colas[$view['skill']]['vdn'];
            $listen         = 'No compatible';
            $date           = str_replace('/', '-', $view['date']);
            $day            = Carbon::parse(date('Y-m-d', strtotime($date)));
            $hour           = Carbon::parse($view['hour']);
            $listen         = 'No compatible';
            $bronswer       = detect_bronswer();

            $url            = 'url='.$view['skill'].'/'.$day->format('Y/m/d').'/';
            $audio_name     = '&nameaudio='.$view['telephone'].'-'.$vdn.'-'.$day->format('dmY').'-';
            $proyecto       = '&proyect='.getenv('AUDIO_PROYECT');
            $hora           = '&hour='.$hour;
            $route_complete = 'http://'.$_SERVER['HTTP_HOST'].'/script_php/descargar_audio.php?'.$url.$audio_name.$proyecto.$hora;
            $download       = '<center><a target="_blank" href="'.$route_complete.'"><i class="fa fa-download" aria-hidden="true"></i></a></center>';

            if($bronswer["browser"] == 'FIREFOX'){
                $listen = '<center><a target="_blank" href="'.$route_complete.'"><i class="fa fa-play" aria-hidden="true"></i></a></center>';
            }

            $incomingcollection->push([
                'date'                      => $view['date'],
                'hour'                      => $view['hour'],
                'fecha_hora'                => $view['date'].' '.$view['hour'],
                'telephone'                 => $view['telephone'],
                'agent'                     => $view['agent'],
                'skill'                     => $view['skill'],
                'duration'                  => $view['duration'],
                'action'                    => $view['action'],
                'waittime'                  => $view['waittime'],
                'download'                  => $download,
                'listen'                    => $listen
            ]);
        }

        return $incomingcollection;
    }


    /**
     * [export_csv Function que retorna la ubicación de los datos a exportar en CSV]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en CSV]
     */
    protected function export_csv($days){
        $filenamefirst              = "calls_completed";
        $filenamesecond             = "calls_transfer";
        $filenamethird              = "calls_abandone";
        $filetime                   = time();

        $events = [$filenamefirst,$filenamesecond,$filenamethird];

        for($i=0;$i<count($events);$i++){
            $builderview = $this->builderview($this->query_calls($days,$events[$i]));
            $this->BuilderExport($builderview,$events[$i].'_'.$filetime,'csv','exports');
        }
    
        $data = [
            'succes'    => true,
            'path'      => [
                            'http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filenamefirst.'_'.$filetime.'.csv',
                            'http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filenamesecond.'_'.$filetime.'.csv',
                            'http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filenamethird.'_'.$filetime.'.csv'
                            ]
        ];

        return $data;
    }


    /**
     * [export_excel Function que retorna la ubicación de los datos a exportar en Excel]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en Excel]
     */
    protected function export_excel($days){
        $filename               = 'inbound_calls_'.time();
        Excel::create($filename, function($excel) use($days) {

            $excel->sheet('Atendidas', function($sheet) use($days) {
                $sheet->fromArray($this->builderview($this->query_calls($days,'calls_completed')));
            });

            $excel->sheet('Transferidas', function($sheet) use($days) {
                $sheet->fromArray($this->builderview($this->query_calls($days,'calls_transfer')));
            });


            $excel->sheet('Abandonadas', function($sheet) use($days) {
                $sheet->fromArray($this->builderview($this->query_calls($days,'calls_abandone')));
            });


        })->store('xlsx','exports');

        $data = [
            'succes'    => true,
            'path'      => ['http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.xlsx']
        ];

        return $data;
    }

}