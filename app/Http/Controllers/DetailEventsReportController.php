<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Excel;

class DetailEventsReportController extends CosapiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if ($request->ajax()){
            if ($request->fecha_evento){
                return $this->list_detail_event_report($request->fecha_evento, $request->filter_rol, $request->group_filter);
            }else{

                $arrayReport = $this->reportAction(array(
                    'boxReport','dateHourFilter','dateFilter','viewDateSearch','viewRolTypeSearch','viewButtonSearch','viewButtonExport'
                ),'');

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.details_events_report.details_events_report',
                    'titleReport'           => 'Report Level of Occupation',
                    'exportReport'          => 'export_details_events_report',
                    'nameRouteController'   => ''
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }
    }

    protected function list_detail_event_report($fecha_evento, $rolUser, $typeReport){
        $query_detail_event_report          = $this->query_detail_event_report($fecha_evento, $rolUser, $typeReport);
        $builderview_detail_event_report    = $this->builderview_detail_event_report($query_detail_event_report);
        $collection_detail_event_report     = $this->collection_detail_event_report($builderview_detail_event_report);
        $list_detail_event_report           = $this->FormatDatatable($collection_detail_event_report);
        return $list_detail_event_report;
    }

    protected function query_detail_event_report ($fecha_evento, $rolUser, $typeReport){
        list($fecha_inicial,$fecha_final) = explode(' - ', $fecha_evento);
        $query_detail_event_report = DB::select('CALL sp_detail_event_report ("'.$fecha_inicial.'","'.$fecha_final.'","'.$rolUser.'","'.$typeReport.'")');
        return $query_detail_event_report;
    }

    protected function builderview_detail_event_report($query_detail_event_report){
        $builderview = [];
        $posicion = 0;
        foreach ($query_detail_event_report as $query_event) {

            $totalACD = $query_event->Inbound + $query_event->Hold_Inbound;

            $totalOutbound = $query_event->OutBound + $query_event->Ring_Outbound + $query_event->Hold_Outbound;

            $totalBackoffice = $query_event->Gestion_BackOffice + $query_event->Inbound_Interno + $query_event->Ring_Inbound_Interno + $query_event->Hold_Inbound_Interno + $query_event->Outbound_Interno + $query_event->Ring_Outbound_Interno + $query_event->Hold_Outbound_Interno;

            $totalAuxiliares = $query_event->Break + $query_event->SSHH + $query_event->Refrigerio + $query_event->Feedback + $query_event->Capacitacion;

            $totalAuxiliaresBack = $totalAuxiliares + $totalBackoffice;

            $totalSuma = $query_event->ACD + $query_event->Break + $query_event->SSHH + $query_event->Refrigerio + $query_event->Feedback + $query_event->Capacitacion + $query_event->Gestion_BackOffice + $query_event->Inbound + $query_event->OutBound + $query_event->Ring_Inbound + $query_event->Ring_Outbound + $query_event->Hold_Inbound + $query_event->Hold_Outbound + $query_event->Ring_Inbound_Interno + $query_event->Inbound_Interno + $query_event->Outbound_Interno + $query_event->Ring_Outbound_Interno + $query_event->Hold_Inbound_Interno + $query_event->Hold_Outbound_Interno + $query_event->Ring_Inbound_Transfer + $query_event->Inbound_Transfer + $query_event->Hold_Inbound_Transfer + $query_event->Ring_Outbound_Transfer + $query_event->Hold_Outbound_Transfer + $query_event->Outbound_Transfer + $query_event->Desconectado;

            $tiempoLogeo = $totalSuma - $query_event->Desconectado;

            $totalOcupacion = ($totalACD + $totalOutbound)/($tiempoLogeo - $totalAuxiliaresBack);

            $totalOcupacionBack = ($totalACD + $totalOutbound + $totalBackoffice)/($tiempoLogeo - $totalAuxiliares);

            $builderview[$posicion]['Name']                        = $query_event->date_register;
            $builderview[$posicion]['Fuera de Tiempo']             = conversorSegundosHoras($query_event->Login, false);
            $builderview[$posicion]['Disponible']                  = conversorSegundosHoras($query_event->ACD, false);
            $builderview[$posicion]['Break']                       = conversorSegundosHoras($query_event->Break, false);
            $builderview[$posicion]['SSHH']                        = conversorSegundosHoras($query_event->SSHH, false);
            $builderview[$posicion]['Refrigerio']                  = conversorSegundosHoras($query_event->Refrigerio, false);
            $builderview[$posicion]['Feedback']                    = conversorSegundosHoras($query_event->Feedback, false);
            $builderview[$posicion]['Capacitacion']                = conversorSegundosHoras($query_event->Capacitacion, false);
            $builderview[$posicion]['Gestion BackOffice']          = conversorSegundosHoras($query_event->Gestion_BackOffice, false);
            $builderview[$posicion]['Inbound']                     = conversorSegundosHoras($query_event->Inbound, false);
            $builderview[$posicion]['Ring Inbound']                = conversorSegundosHoras($query_event->Ring_Inbound, false);
            $builderview[$posicion]['Hold Inbound']                = conversorSegundosHoras($query_event->Hold_Inbound, false);
            $builderview[$posicion]['OutBound']                    = conversorSegundosHoras($query_event->OutBound, false);
            $builderview[$posicion]['Ring Outbound']               = conversorSegundosHoras($query_event->Ring_Outbound, false);
            $builderview[$posicion]['Hold Outbound']               = conversorSegundosHoras($query_event->Hold_Outbound, false);
            $builderview[$posicion]['Inbound Interno']             = conversorSegundosHoras($query_event->Inbound_Interno, false);
            $builderview[$posicion]['Ring Inbound Interno']        = conversorSegundosHoras($query_event->Ring_Inbound_Interno, false);
            $builderview[$posicion]['Hold Inbound Interno']        = conversorSegundosHoras($query_event->Hold_Inbound_Interno, false);
            $builderview[$posicion]['Outbound Interno']            = conversorSegundosHoras($query_event->Outbound_Interno, false);
            $builderview[$posicion]['Ring Outbound Interno']       = conversorSegundosHoras($query_event->Ring_Outbound_Interno, false);
            $builderview[$posicion]['Hold Outbound Interno']       = conversorSegundosHoras($query_event->Hold_Outbound_Interno, false);
            $builderview[$posicion]['Ring Inbound Transfer']       = conversorSegundosHoras($query_event->Ring_Inbound_Transfer, false);
            $builderview[$posicion]['Inbound Transfer']            = conversorSegundosHoras($query_event->Inbound_Transfer, false);
            $builderview[$posicion]['Hold Inbound Transfer']       = conversorSegundosHoras($query_event->Hold_Inbound_Transfer, false);
            $builderview[$posicion]['Ring Outbound Transfer']      = conversorSegundosHoras($query_event->Ring_Outbound_Transfer, false);
            $builderview[$posicion]['Hold Outbound Transfer']      = conversorSegundosHoras($query_event->Hold_Outbound_Transfer, false);
            $builderview[$posicion]['Outbound Transfer']           = conversorSegundosHoras($query_event->Outbound_Transfer, false);
            $builderview[$posicion]['Desconectado']                = conversorSegundosHoras($query_event->Desconectado, false);
            $builderview[$posicion]['Total ACD']                   = conversorSegundosHoras($totalACD, false);
            $builderview[$posicion]['Total Outbound']              = conversorSegundosHoras($totalOutbound, false);
            $builderview[$posicion]['Auxiliares']                  = conversorSegundosHoras($totalAuxiliares, false);
            $builderview[$posicion]['Auxiliares Backoffice']       = conversorSegundosHoras($totalAuxiliaresBack, false);
            $builderview[$posicion]['Nivel Ocupacion']             = (number_format($totalOcupacion,4)*100).' %';
            $builderview[$posicion]['Nivel Ocupacion Backoffice']  = (number_format($totalOcupacionBack,4)*100).' %';

            $posicion ++;
        }
        return $builderview;
    }

    protected function collection_detail_event_report($builderview_detail_event_report){
        $eventconsolidatedcollection                = new Collector;
        foreach ($builderview_detail_event_report as $view) {
            $eventconsolidatedcollection->push([
                'Name'                       => $view['Name'],
                'Fuera de Tiempo'            => $view['Fuera de Tiempo'],
                'Disponible'                 => $view['Disponible'],
                'Break'                      => $view['Break'],
                'SSHH'                       => $view['SSHH'],
                'Refrigerio'                 => $view['Refrigerio'],
                'Feedback'                   => $view['Feedback'],
                'Capacitacion'               => $view['Capacitacion'],
                'Gestion BackOffice'         => $view['Gestion BackOffice'],
                'Inbound'                    => $view['Inbound'],
                'OutBound'                   => $view['OutBound'],
                'Ring Inbound'               => $view['Ring Inbound'],
                'Ring Outbound'              => $view['Ring Outbound'],
                'Hold Inbound'               => $view['Hold Inbound'],
                'Hold Outbound'              => $view['Hold Outbound'],
                'Ring Inbound Interno'       => $view['Ring Inbound Interno'],
                'Inbound Interno'            => $view['Inbound Interno'],
                'Outbound Interno'           => $view['Outbound Interno'],
                'Ring Outbound Interno'      => $view['Ring Outbound Interno'],
                'Hold Inbound Interno'       => $view['Hold Inbound Interno'],
                'Hold Outbound Interno'      => $view['Hold Outbound Interno'],
                'Ring Inbound Transfer'      => $view['Ring Inbound Transfer'],
                'Inbound Transfer'           => $view['Inbound Transfer'],
                'Hold Inbound Transfer'      => $view['Hold Inbound Transfer'],
                'Ring Outbound Transfer'     => $view['Ring Outbound Transfer'],
                'Hold Outbound Transfer'     => $view['Hold Outbound Transfer'],
                'Outbound Transfer'          => $view['Outbound Transfer'],
                'Desconectado'               => $view['Desconectado'],
                'Total ACD'                  => $view['Total ACD'],
                'Total Outbound'             => $view['Total Outbound'],
                'Auxiliares'                 => $view['Auxiliares'],
                'Auxiliares Backoffice'      => $view['Auxiliares Backoffice'],
                'Nivel Ocupacion'            => '<b>'.$view['Nivel Ocupacion'].'</b>',
                'Nivel Ocupacion Backoffice' => '<b>'.$view['Nivel Ocupacion Backoffice'].'</b>'
            ]);
        }
        return $eventconsolidatedcollection;
    }

    public function export_details_events_report(Request $request){
        return call_user_func_array([$this,'export_details_events_report_'.$request->format_export], [$request->days, $request->filter_rol, $request->group_filter]);
    }

    protected function export_details_events_report_csv($days, $filter_rol, $type_report){
        $filename               = 'details_events_report_'.substr(time(),6,4);
        $builderview            = $this->builderview_detail_event_report($this->query_detail_event_report($days, $filter_rol, $type_report));
        $this->BuilderExport($builderview,$filename,'csv','exports');

        $data = [
            'succes'    => true,
            'path'      => [
                'http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.csv'
            ]
        ];

        return $data;
    }

    protected function export_details_events_report_excel($days, $filter_rol, $type_report){
        $filename = 'details_events_report_'.time();
        $query    = $this->query_detail_event_report($days, $filter_rol, $type_report);

        Excel::create($filename, function($excel) use($query) {
            $excel->sheet('Details Events Report', function($sheet) use($query) {
                $sheet->fromArray($this->builderview_detail_event_report($query));
            });

        })->store('xlsx','exports');

        $data = [
            'succes'    => true,
            'path'      => ['http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.xlsx']
        ];

        return $data;
    }
}
