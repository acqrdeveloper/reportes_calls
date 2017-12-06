<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Illuminate\Http\Request;
use Cosapi\Models\Eventos;
use Cosapi\Models\DetalleEventosHistory;
use Cosapi\Models\DetalleEventos;

use Illuminate\Support\Facades\DB;
use Excel;


class EventsAgentController extends CosapiController
{
    /**
     * [events_consolidated Función que retorna la vista o datos para el reporte de Consolidated Events]
     * @param  Request $request  [Recepciona datos enviado por POST]
     * @return [view]            [Vista o Datos para cargar en el reporte consolidated]
     */
    public function events_consolidated(Request $request){

        if ($request->ajax()){
            if ($request->fecha_evento){
                return $this->list_event_consolidated($request->fecha_evento);
            }else{

                $arrayReport = $this->reportAction(array(
                    'boxReport','dateHourFilter','dateFilter','viewDateSearch','viewButtonSearch','viewButtonExport'
                ),'');

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.events_consolidated.events_consolidated',
                    'titleReport'           => 'Report of Events Consolidateds',
                    'exportReport'          => 'export_events_consolidated',
                    'nameRouteController'   => ''
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }

    }

    /**
     * [events_detail Función que carga los datos y vista del Details Events]
     * @param  Request $request [Recepciona los datos por POST]
     * @return [view]           [Retorna una vista y datos del reporte Details Events]
     */
    public function events_detail (Request $request){
        if ($request->ajax()){
            if ($request->fecha_evento){
                $days                   = explode(' - ',$request->fecha_evento);
                $query_events           = $this->query_events($days);
                $array_detail_events    = detailEvents($query_events);
                $objCollection          = $this->convertCollection($array_detail_events);
                $detail_events          = $this->FormatDatatable($objCollection);
                return $detail_events;
            }else{
                $customDataFilter = $this->customDataFilter();

                $arrayReport = $this->reportAction(array(
                    'boxReport','dateHourFilter','dateFilter','viewDateSearch','viewButtonSearch','viewButtonExport','viewCustomFilter'
                ),$customDataFilter['listUsers']['fullName']);

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.events_detail.events_detail',
                    'titleReport'           => 'Report of Events',
                    'exportReport'          => 'export_events_detail',
                    'nameRouteController'   => ''
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }
    }


    /**
     * [export_event_detail Función que permite exportar los datos de la tabla]
     * @param  Request $request [Recepciona datos enviado por POST]
     * @return [array]          [Ubicaciones de los archivos a exportar]
     */
    public function export_event_detail(Request $request){
        $export_contestated  = call_user_func_array([$this,'export_event_detail_'.$request->format_export], [$request->days]);
        return $export_contestated;
    }

    /**
     * [export_event_consolidated Función que permite exportar los datos de la tabla]
     * @param  Request $request [Recepciona datos enviado por POST]
     * @return [array]          [Ubicaciones de los archivos a exportar]
     */
    public function export_event_consolidated(Request $request){
        return call_user_func_array([$this,'export_event_consolidated_'.$request->format_export], [$request->days]);
    }


    /**
     * [list_state_agents Función que obtiene los datos a cargar en el reporte de Consolidated Events]
     * @param  [date]  $fecha_evento [Fecha de la consulta]
     * @return [array]               [Array con datos del consolidado de eventos]
     */
    protected function list_event_consolidated($fecha_evento){

        $query_event_consolidated       = $this->query_event_consolidated($fecha_evento);
        $builderview_event_consolidated = $this->builderview_event_consolidated($query_event_consolidated);
        $collection_event_consolidated  = $this->collection_event_consolidated($builderview_event_consolidated);
        $list_state_agents              = $this->FormatDatatable($collection_event_consolidated);
        return $list_state_agents;

    }


    /**
     * [query_estado_agentes Función que consulta los datos de Consolidated Events]
     * @param  [date]  $fecha_evento [Fecha de la consulta]
     * @return [array]               [Datos extraidos del Consolidated Events desde la Base de Datos]
     */
    protected function query_event_consolidated ($fecha_evento)
    {
        list($fecha_inicial,$fecha_final) = explode(' - ', $fecha_evento);

        $query_event_consolidated = DB::select('CALL sp_get_consolidated_events ("'.$fecha_inicial.'","'.$fecha_final.'")');

        return $query_event_consolidated;
    }



    /**
     * [collection_state_agent Función que transforma un Array en Collection]
     * @param  [array]      $query_estado_agentes [Datos del Consolidated Events]
     * @return [collection]                       [Datos en formato Colecction del reporte Consolidated Events]
     */
    protected function builderview_event_consolidated($query_event_consolidated){
        $builderview = [];
        $posicion = 0;
        foreach ($query_event_consolidated as $query_event) {
            $builderview[$posicion]['agente']        = $query_event->agente;
            $builderview[$posicion]['login']        = conversorSegundosHoras($query_event->login,false);
            $builderview[$posicion]['acd']          = conversorSegundosHoras($query_event->acd,false);
            $builderview[$posicion]['break']        = conversorSegundosHoras($query_event->break,false);
            $builderview[$posicion]['sshh']         = conversorSegundosHoras($query_event->sshh,false);
            $builderview[$posicion]['refrigerio']   = conversorSegundosHoras($query_event->refrigerio,false);
            $builderview[$posicion]['feedback']    = conversorSegundosHoras($query_event->feedback,false);
            $builderview[$posicion]['capacitacion'] = conversorSegundosHoras($query_event->capacitacion,false);
            $builderview[$posicion]['backoffice']   = conversorSegundosHoras($query_event->backoffice,false);
            $builderview[$posicion]['inbound']     = conversorSegundosHoras($query_event->inbound,false);
            $builderview[$posicion]['outbound']     = conversorSegundosHoras($query_event->outbound,false);
            $builderview[$posicion]['acw']          = conversorSegundosHoras($query_event->acw,false);
            $builderview[$posicion]['desconectado'] = conversorSegundosHoras($query_event->desconectado,false);
            $builderview[$posicion]['logueado']     = conversorSegundosHoras($query_event->logueado,false);
            $builderview[$posicion]['auxiliar']   = conversorSegundosHoras($query_event->auxiliar,false);
            $builderview[$posicion]['talk']         = conversorSegundosHoras($query_event->talk_time,false);
            $builderview[$posicion]['saliente']     = conversorSegundosHoras($query_event->saliente_hablado,false);
            $posicion ++;
        }
        return $builderview;
    }


    /**
     * [collection_state_agent Función que transforma un Array en Collection]
     * @param  [array]      $query_estado_agentes [Datos del Consolidated Events]
     * @return [collection]                       [Datos en formato Colecction del reporte Consolidated Events]
     */
    protected function collection_event_consolidated($builderview_event_consolidated){
        $eventconsolidatedcollection                = new Collector;
        foreach ($builderview_event_consolidated as $view) {
            $eventconsolidatedcollection->push([
                'agente'             => $view['agente'],
                'login'              => $view['login'],
                'acd'                => $view['acd'],
                'break'              => $view['break'],
                'sshh'               => $view['sshh'],
                'refrigerio'         => $view['refrigerio'],
                'feedback'           => $view['feedback'],
                'capacitacion'       => $view['capacitacion'],
                'backoffice'         => $view['backoffice'],
                'inbound'            => $view['inbound'],
                'outbound'           => $view['outbound'],
                'acw'                => $view['acw'],
                'desconectado'       => $view['desconectado'],
                'logueado'           => $view['logueado'],
                'auxiliar'           => $view['auxiliar'],
                'talk'               => $view['talk'],
                'saliente'           => $view['saliente']
            ]);
        }
        return $eventconsolidatedcollection;
    }


    /**
     * [query_events Función en donde se encunetra el query que consulta los datos del Details Event Empresa]
     * @param  [array] $days [Fecha de la consulta]
     * @return [array]       [Retorna datos para el Details Events]
     */
    protected function query_events($days){
        if($days[0] == date('Y-m-d') && $days[1] == date('Y-m-d')){

            $detail_events   = $this->events_presents($days,$this->UserId,$this->UserRole);

        }else if($days[0] != date('Y-m-d') && $days[1] != date('Y-m-d')){

            $detail_events   = $this->events_history($days,$this->UserId,$this->UserRole);
        }else{

            $events_presents = $this->events_presents($days,$this->UserId,$this->UserRole);
            $events_history  = $this->events_history($days,$this->UserId,$this->UserRole);
            $detail_events   = array_merge($events_presents, $events_history);
        }


        return $detail_events;
    }


    /**
     * [events_presents description]
     * @return [type] [description]
     */
    protected function events_presents ($days,$user_id,$rol){
        $events_presents  = DetalleEventos::Select('user_id','evento_id','fecha_evento','observaciones')
                            ->with('evento','user')
                            ->filtro_user_rol($rol,$user_id)
                            ->filtro_days($days)
                            ->OrderBy(DB::raw('user_id'), 'asc')
                            ->OrderBy(DB::raw('DATE(fecha_evento)'), 'asc')
                            ->OrderBy(DB::raw('TIME(fecha_evento)'), 'asc')
                            ->get()
                            ->toArray();
        return $events_presents;
    }

    /**
     * [Función que permite obtener datos de eventos pasados que han sido realizados por el usuario]
     * @param $days [Rango de días a consultar]
     * @return mixed [Array con informacion obtenida de los eventos]
     */
    protected function events_history($days,$user_id,$rol){

        $events_history  = DetalleEventosHistory::Select('user_id','evento_id','fecha_evento','observaciones')
                            ->with('evento','user')
                            ->filtro_user_rol($rol,$user_id)
                            ->filtro_days($days)
                            ->OrderBy(DB::raw('user_id'), 'asc')
                            ->OrderBy(DB::raw('DATE(fecha_evento)'), 'asc')
                            ->OrderBy(DB::raw('TIME(fecha_evento)'), 'asc')
                            ->get()
                            ->toArray();
        return $events_history;
    }

    /**
     * [convertCollection Función que permite pasar de un Array a Collection]
     * @param  [array]      $array [Datos con la información de Event Details]
     * @return [colection]         [Collection con los datos de Event Details]
     */
    function convertCollection($array){

        $objCollection = New Collector();
        foreach ($array as $data) {
            $objCollection->push([
                'nombre_agente'     => $data['full_name_user'],
                'fecha'             => $this->MostrarSoloFecha($data['fecha_evento']),
                'hora'              => $this->MostrarSoloHora($data['fecha_evento']),
                'fecha_hora'        => $this->MostrarSoloHora($data['fecha_evento']),
                'evento'            => $data['name_evento'],
                'accion'            => $data['accion'],
            ]);
        }

        return $objCollection;
    }


    /**
     * [builderview Función que prepara los datos para el envío de Detail Events]
     * @param  [array] $detail_events [Array con datos de la consulta a la base de datos]
     * @return [array]                [Array con los datos modificados para la vista]
     */
    protected function builderview ($detail_events){
        $array_detail = [];
        $posicion = 0;
        foreach($detail_events as $events){
            $array_detail[$posicion]['NOMBRE COMPLETO']   = $events['full_name_user'];
            $array_detail[$posicion]['FECHA']             = $this->MostrarSoloFecha($events['fecha_evento']);
            $array_detail[$posicion]['HORA']              = $this->MostrarSoloHora($events['fecha_evento']);
            $array_detail[$posicion]['NOMBRE DEL EVENTO'] = $events['name_evento'];
            $array_detail[$posicion]['REALIZADO POR']     = $events['accion'];
            $posicion++;
        }

        return $array_detail;
    }


    /**
     * [export_csv Function que retorna la ubicación de los datos a exportar en CSV]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en CSV]
     */
    protected function export_event_detail_csv($days){
            $days                   = explode(' - ',$days);
            $filename               = 'detail_events_'.time();

            $builderview = $this->builderview(detailEvents($this->query_events($days)));
            $this->BuilderExport($builderview,$filename,'csv','exports');


        $data = [
            'succes'    => true,
            'path'      => [
                'http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.csv'
            ]
        ];

        return $data;
    }


    /**
     * [export_excel Function que retorna la ubicación de los datos a exportar en Excel]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en Excel]
     */
    protected function export_event_detail_excel($days){
        $days                   = explode(' - ',$days);
        $filename               = 'detail_events_'.time();
        Excel::create($filename, function($excel) use($days) {


            $excel->sheet('Detail Events', function($sheet) use($days) {
                $sheet->fromArray($this->builderview(detailEvents($this->query_events($days))));
            });


        })->store('xlsx','exports');

        $data = [
            'succes'    => true,
            'path'      => ['http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.xlsx']
        ];

        return $data;
    }

    /**
     * [export_csv Function que retorna la ubicación de los datos a exportar en CSV]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en CSV]
     */
    protected function export_event_consolidated_csv($days){
        $filename               = 'detail_events_consolidated_'.substr(time(),6,4);
        $builderview = $this->builderview_event_consolidated($this->query_event_consolidated($days));
        $this->BuilderExport($builderview,$filename,'csv','exports');


        $data = [
            'succes'    => true,
            'path'      => [
                'http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.csv'
            ]
        ];

        return $data;
    }


    /**
     * [export_excel Function que retorna la ubicación de los datos a exportar en Excel]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en Excel]
     */
    protected function export_event_consolidated_excel($days){
        $filename               = 'detail_events_consolidated_'.time();
        Excel::create($filename, function($excel) use($days) {

            $excel->sheet('Consolidated Events', function($sheet) use($days) {
                $sheet->fromArray($this->builderview_event_consolidated($this->query_event_consolidated($days)));
            });

        })->store('xlsx','exports');

        $data = [
            'succes'    => true,
            'path'      => ['http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.xlsx']
        ];

        return $data;
    }
}
