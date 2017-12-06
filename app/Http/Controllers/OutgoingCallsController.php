<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Models\Anexo;
use Illuminate\Http\Request;
use Cosapi\Models\Cdr;
use Cosapi\Collector\Collector;

use DB;
use Carbon\Carbon;
use Session;

class OutgoingCallsController extends CosapiController
{
    /**
     * [index Función que retorna vista o datos al reporte Outbound Calls]
     * @param  Request $request [Retorna datos enviados por POST]
     * @return [view]           [Vista o Array con datos del reporte Outbound Calls]
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            if ($request->fecha_evento){
                return $this->list_calls_outgoing($request->fecha_evento);
            }else{

                $arrayReport = $this->reportAction(array(
                    'boxReport','dateHourFilter','dateFilter','viewDateSearch','viewButtonSearch','viewButtonExport','viewCustomFilter'
                ),'');

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.outgoing_calls.outgoing_calls',
                    'titleReport'           => 'Report of Calls Outbound',
                    'exportReport'          => 'export_outgoing',
                    'nameRouteController'   => 'outgoing_calls'
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }
    }


    /**
     * [listar_llamadas_consolidadas Función para listar el consolidado de llamadas]
     * @param  Request   $request        [Dato para identifcar GET O POST]
     * @param  [string]  $fecha_evento   [Recibe el rango de fecha e buscar]
     * @return [Array]                   [Retorna la lista del consolidado de llamadas]
     */
    public function list_calls_outgoing($fecha_evento){
        $query_calls_outgoing   = $this->query_calls_outgoing($fecha_evento);
        $builderview            = $this->builderview($query_calls_outgoing);
        $outgoingcollection     = $this->outgoingcollection($builderview);
        $list_call_outgoing     = $this->FormatDatatable($outgoingcollection);

        return $list_call_outgoing;
    }

    /**
     * [export description]
     * @param  Request $request [Dato para identifcar GET O POST]
     * @return [type]           [description]
     */
    public function export(Request $request){
        $export_outgoing  = call_user_func_array([$this,'export_'.$request->format_export], [$request->days]);
        return $export_outgoing;
    }

    /**
     * [query_calls_outgoing Función donde se realiza la consulta a la base de datos de las llamadas salientes realizadas]
     * @param  [array] $fecha_evento [Rango de consulta, Ejem: '2016-10-22 - 20016-10-25']
     * @return [array]               [Array con los datos obtenidos de la consutla]
     */
    protected function query_calls_outgoing($fecha_evento){

        $days                   = explode(' - ', $fecha_evento);
        $range_annexed          = Anexo::select('name')->get()->toArray();
        $tamano_anexo           = $this->lengthAnnexed();
        $query_calls_outgoing   = Cdr::Select()
                                    ->filtro_user_rol($this->UserRole,$this->UserSystem)
                                    ->whereIn(DB::raw('LENGTH(src)'),$tamano_anexo)
                                    ->where('dst','not like','*%')
                                    ->where('disposition','=','ANSWERED')
                                    ->where('lastapp','=','Dial')
                                    ->whereIn('src',$range_annexed)
                                    ->whereNotIn('dst',$range_annexed)
                                    ->filtro_days($days)
                                    ->OrderBy('src')
                                    ->get()
                                    ->toArray();


        return $query_calls_outgoing;
    }

    /**
     * [builderview Función que ordena los datos visualmente para que sean cargado en el reporte Outbound Calls]
     * @param  [array]  $query_calls_outgoing [Array con datos de las llamadas salientes realizadas]
     * @param  [string] $type                 [Tipo de evento a realizar Exportar o Cargar datos en la tabla de Outbound Calls]
     * @return [array]                        [Array modificado para la correcta visualización en el reporte]
     */
    protected function builderview($query_calls_outgoing,$type=''){
        $posicion = 0;
        foreach ($query_calls_outgoing as $query_call) {

            if($type == 'export'){
                $builderview[$posicion]['date']          = $this->MostrarSoloFecha($query_call['calldate']);
                $builderview[$posicion]['hour']          = $this->MostrarSoloHora($query_call['calldate']);
                $builderview[$posicion]['annexedorigin'] = $query_call['src'];
                $builderview[$posicion]['destination']   = $query_call['dst'];
                $builderview[$posicion]['username']      = $query_call['accountcode'];
                $builderview[$posicion]['calltime']      = conversorSegundosHoras($query_call['billsec'],false);
            }else{
                $builderview[$posicion]['date']          = $this->MostrarSoloFecha($query_call['calldate']);
                $builderview[$posicion]['hour']          = $this->MostrarSoloHora($query_call['calldate']);
                $builderview[$posicion]['annexedorigin'] = $query_call['src'];
                $builderview[$posicion]['destination']   = $query_call['dst'];
                $builderview[$posicion]['username']      = $query_call['accountcode'];
                $builderview[$posicion]['userfield']     = $query_call['userfield']; // Url para descarga de audio
                $builderview[$posicion]['calltime']      = conversorSegundosHoras($query_call['billsec'],false);
            }
            $posicion ++;
        }
        if(!isset($builderview)){
            $builderview = [];
        }
        return $builderview;
    }

    /**
     * [outgoingcollection Función que pasa los datos de un array a un collection]
     * @param  [array]      $builderview [Datos de las llamadas salientes que se visualizaran en los reportes]
     * @return [collection]              [description]
     */
    protected function outgoingcollection($builderview){
        $outgoingcollection                 = new Collector;
        foreach ($builderview as $view) {

            $day            = Carbon::parse($view['date']);
            $hour           = Carbon::parse($view['hour']);
            $bronswer       = detect_bronswer();
            $listen         = 'No compatible';
            $carpeta        = '';

            if(substr($view['destination'], 0, 4) =='0800') $carpeta = '0800';
            else if(strlen($view['destination']) =='4' or strlen($view['destination']) == '5') $carpeta = 'anexos-externos';
            else if(strlen($view['destination']) =='7') $carpeta = 'local';
            else if(strlen($view['destination']) =='9'){
                if(substr($view['destination'], 0,1)=='0') $carpeta = 'nacional';
                else $carpeta = 'celular';
            }


            $url            = 'url=Salientes/'.$carpeta.'/'.$day->format('Y/m/d').'/';
            $proyecto       = '&proyect='.getenv('AUDIO_PROYECT');

            if($view['username']!=''){
                $audio_name     =  '&nameaudio='.$view['destination'].'-'.$view['annexedorigin'].'-'.$day->format('dmY').'-';
            }else{
                $audio_name     = '&nameaudio='.$view['annexedorigin'].'-'.$view['destination'].'-'.$day->format('dmY').'-';
            }
            $hora           = '&hour='.$hour;
            $route_complete = 'http://'.$_SERVER['HTTP_HOST'].'/script_php/descargar_audio.php?'.$url.$audio_name.$proyecto.$hora;

            $download       = '<center><a target="_blank" href="'.$route_complete.'"><i class="fa fa-download" aria-hidden="true"></i></a></center>';

            if($bronswer["browser"] == 'FIREFOX'){
                $listen = '<center><a target="_blank" href="'.$route_complete.'"><i class="fa fa-play" aria-hidden="true"></i></a></center>';
            }

            $outgoingcollection->push([
                'date'                      => $view['date'],
                'hour'                      => $view['hour'],
                'fecha_hora'                => $view['date'].' '.$view['hour'],
                'annexedorigin'             => $view['annexedorigin'],
                'destination'               => $view['destination'],
                'calltime'                  => $view['calltime'],
                'username'                  => $view['username'],
                'download'                  => $download,
                'listen'                    => $listen
            ]);

        }

        return $outgoingcollection;
    }

    /**
     * [export_csv Function que retorna la ubicación de los datos a exportar en CSV]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en CSV]
     */
    protected function export_csv($days){
        $filename               = 'outgoing_calls_'.time();
        $builderview = $this->builderview($this->query_calls_outgoing($days),'export');
        $this->BuilderExport($builderview,$filename,'csv','exports');

        $data = [
            'succes'    => true,
            'path'      => ['http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.csv']
        ];

        return $data;
    }

    /**
     * [export_excel Function que retorna la ubicación de los datos a exportar en Excel]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en Excel]
     */
    protected function export_excel($days){
        $filename               = 'outgoing_calls_'.time();
        $builderview = $this->builderview($this->query_calls_outgoing($days),'export');
        $this->BuilderExport($builderview,$filename,'xlsx','exports');

        $data = [
            'succes'    => true,
            'path'      => ['http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.xlsx']
        ];

        return $data;
    }

}