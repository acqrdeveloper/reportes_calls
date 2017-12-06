<?php

namespace Cosapi\Http\Controllers;


use Cosapi\Collector\Collector;
use Illuminate\Http\Request;
use Cosapi\Models\AgentesOnline;
use DB;

class AgentsOnlineController extends CosapiController
{


    /**
     * [index Función que carga las vistas del reporte Agentes Online]
     * @param  Request $request [Variable por la cual se recibe datos enviados por POST]
     * @return [view]           [retorna datos a cargar en la vista]
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            if ($request->fecha_evento){
                return $this->agents_online($request->fecha_evento);
            }else{

                $arrayReport = $this->reportAction(array(
                    'boxReport','dateHourFilter','dateFilter','viewDateSearch','viewButtonSearch','viewButtonExport','viewCustomFilter'
                ),'');

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.agents_online.agents-online',
                    'titleReport'           => 'Report of Agent Online',
                    'exportReport'          => 'export_agents_online',
                    'nameRouteController'   => 'agents_online'
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }

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
     * [agents_online Función que envia los datos del día para su respectica consulta a la base de datos.]
     * @param  [array] $fecha_evento  [Días de consulta]
     * @return [array]                [retorna datos de los agentes en línea obtenidos]
     */
    public function agents_online($fecha_evento){

        $query_agents_online    = $this->query_agents_online($fecha_evento);
        $builderview            = $this->builderview($query_agents_online);
        $outgoingcollection     = $this->outgoingcollection($builderview);
        $list_call_outgoing     = $this->FormatDatatable($outgoingcollection);
        return $list_call_outgoing;
    }


    /**
     * [query_agents_online Función que realiza la consulta a la tabla Agentes Online]
     * @param  [array] $days [Rango de días a realizar la consulta]
     * @return [array]       [Retorna agentes en línea en base a la consulta realizada]
     */
    public function query_agents_online($fecha_evento){
        $days                   = explode(' - ', $fecha_evento);
        $events_ignored         = array (4,15,7);
        $query_agents_online    = AgentesOnline::select_fechamod()
                                        ->filtro_days($days)
                                        ->whereNotIn('evento_id',$events_ignored)
                                        ->groupBy('date_agent','hour_agent')
                                        ->get();
        return $query_agents_online;
    }

    protected function builderview($query_agents_online,$type=''){
        $posicion = 0;
        foreach ($query_agents_online as $query) {
            $builderview[$posicion]['date']     = $query['date_agent'];
            $builderview[$posicion]['hour']     = $query['hour_agent'];
            $builderview[$posicion]['agents']   = $query['quantity'];
            $posicion ++;
        }

        if(!isset($builderview)){
            $builderview = [];
        }
        return $builderview;
    }


    protected function outgoingcollection($builderview){
        $outgoingcollection                 = new Collector();
        foreach ($builderview as $view) {

            $outgoingcollection->push([
                'date'          => $view['date'],
                'hour'          => $view['hour'],
                'fecha_hora'    => $view['date'].' '.$view['hour'],
                'agents'        => $view['agents']
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
        $filename               = 'agents_online_'.time();
        $builderview = $this->builderview($this->query_agents_online($days),'export');
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
        $filename               = 'agents_online_'.time();
        $builderview = $this->builderview($this->query_agents_online($days,'agents_online'),'export');
        $this->BuilderExport($builderview,$filename,'xlsx','exports');

        $data = [
            'succes'    => true,
            'path'      => ['http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.xlsx']
        ];

        return $data;
    }

}
