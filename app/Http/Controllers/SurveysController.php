<?php

namespace Cosapi\Http\Controllers;

use Illuminate\Http\Request;
use Cosapi\Collector\Collector;

use Cosapi\Models\TipoEncuesta;
use Excel;
use DB;

class SurveysController extends CosapiController
{
    /**
     * [index Función que trae la vista o datos del reporte de Surveys]
     * @param  Request $request [Variable que recibe datos enviados por POT]
     * @return [array]           [Retorna vista o array de datos del reporte de Surveys]
     */
    public function index(Request $request)
    {             
        if ($request->ajax()){
            if ($request->fecha_evento){
                return $this->list_surveys($request->fecha_evento, $request->evento);
            }else{

                $arrayReport = $this->reportAction(array(
                    'boxReport','dateHourFilter','dateFilter','viewDateSearch','viewButtonExport'
                ),'');

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.surveys.surveys',
                    'titleReport'           => 'Report of Surveys',
                    'exportReport'          => 'export_surveys',
                    'nameRouteController'   => ''
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }
    }



    /**
     * [list_surveys Función para obtener los datos a cargar en el repote Surveys]
     * @param  [string] $fecha_evento [Fecha a consultar]
     * @return [array]                [Array de datos de los reportes Surveys]
     */
    protected function list_surveys($fecha_evento, $evento){
        $query_surveys         = $this->query_surveys($fecha_evento,$evento);        
        $builderview           = $this->builderview($query_surveys);
        $surveyscollection     = $this->surveyscollection($builderview);   
        $list_call_surveys     = $this->FormatDatatable($surveyscollection);    

        return $list_call_surveys;
    }


    /**
     * [export Función que permite exportar el reporte de Incoming Calls]
     * @param  Request $request [Retorna datos enviados por POST]
     * @return [array]          [Array con la ubicación de los archivos exportados]
     */
    public function export(Request $request){
        $export_surveys  = call_user_func_array([$this,'export_'.$request->format_export], [$request->days]);
        return $export_surveys;
    }


    /**
     * [query_surveys Función que consulta a la Base de Datos información sobre reportes Sruveys]
     * @param  [string] $days [Fecha a consultar]
     * @return [array]        [Array con datos de la consulta realizada]
     */
    protected function query_surveys($fecha_evento,$events){

        $number_of_questions = 1;       
        $days                           = explode(' - ', $fecha_evento);
        $events_id                      = $this->get_events($events);

        $query_surveys['survey']        = \DB::select('call sp_list_surveys("'.$days[0].'","'.$days[1].'",'.$events_id.')');
        $survey_detail                  = \DB::select('call sp_list_surveys_detail("'.$days[0].'","'.$days[1].'",'.$events_id.')');
        $query_surveys['survey_detail'] = $this->buildeResult($survey_detail,$number_of_questions);
        return $query_surveys;
    } 


    /**
     * [get_events Función que muestra los eventos en base a la acción a realizar]
     * @param  [string] $events [Tipo de reportes de resumen]
     * @return [array]          [Eventos que comforman el tipo de reporte]
     */
    protected function get_events($events){

        switch($events){
            case 'surveys_inbound' :
                $events             = 'Entrante';
            break;
            case 'surveys_outbound' :
                $events             = 'Saliente';
            break;
            case 'surveys_released' :
                $events             = 'Liberada';
            break;
        }

        $events_id  = TipoEncuesta::select('id')->where('name','=',$events)->get()->toArray();
        return $events_id[0]['id'];
    }



    /**
     * [buildeResult Función que contruye la información de los resultados]
     * @param  [array] $survey_detail [Resultado de la consulta de la información de la encuesta]
     * @return [array]                     [Array armado con datos ordenados obtenidos]
     */
    protected function buildeResult($survey_detail,$number_of_questions){
        $buildeResult    = [];
        $increment          = 1;
        foreach ($survey_detail as $detail) {
            if(!isset($buildeResult[$detail->encuesta_id])){
                for ($increment = 1; $increment <= $number_of_questions; $increment++) { 
                    $buildeResult[$detail->encuesta_id]['question_'.$increment]     ='-';
                    $buildeResult[$detail->encuesta_id]['answer_'.$increment]    ='-';
                }
                $increment = 1;
            }
            $buildeResult[$detail->encuesta_id]['question_'.$increment]  = $detail->question;
            $buildeResult[$detail->encuesta_id]['answer_'.$increment] = $detail->answer;
            $increment++;
        }

        return $buildeResult;
    }

    /**
     * [builderview Función que prepara los datos de la consulta para sermostrados en la vista]
     * @param  [array] $query_surveys [Datos obetenidos de la base de datos de reporte Surveys]
     * @return [array]                [Array con con los datos modificados para la vista]
     */
    protected function builderview($query_surveys){
        $builderview    = [];
        $posicion       = 0;
        foreach ($query_surveys['survey'] as $surveys) {

            if(!isset($query_surveys['survey_detail'][$surveys->Id]['question_1'])){
                    $query_surveys['survey_detail'][$surveys->Id]['question_1']  ='-';
                    $query_surveys['survey_detail'][$surveys->Id]['answer_1'] ='-';             
            }

            if(!isset($query_surveys['survey_detail'][$surveys->Id]['question_2'])){
                $query_surveys['survey_detail'][$surveys->Id]['question_2']  ='-';
                $query_surveys['survey_detail'][$surveys->Id]['answer_2'] ='-'; 
            }

            if($surveys->Skill == ''){$surveys->Skill = '-';}
            
            $builderview[$posicion]['Type Survey']          = $surveys->SurveyType;
            $builderview[$posicion]['Date']                 = $surveys->Date;
            $builderview[$posicion]['Hour']                 = $surveys->Time;
            $builderview[$posicion]['Username']             = $surveys->Username;
            $builderview[$posicion]['Anexo']                = $surveys->Anexo;
            $builderview[$posicion]['Telephone']            = $surveys->Telephone;
            $builderview[$posicion]['Skill']                = $surveys->Skill;
            $builderview[$posicion]['Opcion IVR']           = $surveys->OpcionIVR;
            $builderview[$posicion]['Duration Call']        = conversorSegundosHoras($surveys->DurationCall,false);
            $builderview[$posicion]['Duration Survey']      = conversorSegundosHoras($surveys->DurationSurvey,false);
            $builderview[$posicion]['Question_01']          = $query_surveys['survey_detail'][$surveys->Id]['question_1'];
            $builderview[$posicion]['Answer_01']            = $query_surveys['survey_detail'][$surveys->Id]['answer_1'];
            $builderview[$posicion]['Question_02']          = $query_surveys['survey_detail'][$surveys->Id]['question_2'];
            $builderview[$posicion]['Answer_02']            = $query_surveys['survey_detail'][$surveys->Id]['answer_2'];
            $builderview[$posicion]['Action']               = $surveys->Evento;

            $posicion ++;
        }

        return $builderview;
    }


    /**
     * [surveyscollection Función que pasa los datos de un Array a una Collection]
     * @param  [array]      $query_calls [Array con los dato de reportes Surveys]
     * @return [collection]              [Collection con datos del repote Sruveys]
     */
    protected function surveyscollection($builderview){
        $surveyscollection                 = new Collector;
        foreach ($builderview as $view) {
            $surveyscollection->push([
                
                'Type Survey'       =>  $view['Type Survey'],
                'Date'              =>  $view['Date'],
                'Hour'              =>  $view['Hour'],
                'DateTime'          =>  $view['Date'].' '.$view['Hour'],
                'Username'          =>  $view['Username'],
                'Anexo'             =>  $view['Anexo'],
                'Telephone'         =>  $view['Telephone'],
                'Skill'             =>  $view['Skill'],
                'Opcion IVR'        =>  $view['Opcion IVR'],
                'Duration Call'     =>  $view['Duration Call'],
                'Duration Survey'   =>  $view['Duration Survey'],
                'Question_01'       =>  $view['Question_01'],
                'Answer_01'         =>  $view['Answer_01'],
                'Question_02'       =>  $view['Question_02'],
                'Answer_02'         =>  $view['Answer_02'],
                'Action'            =>  $view['Action']
            ]);
        }
        return $surveyscollection;
    }


    /**
     * [export_csv Function que retorna la ubicación de los datos a exportar en CSV]
     * @param  [string] $days [Fecha de la consulta]
     * @return [array]        [Array con la ubicación donde se a guardado el archivo exportado en CSV]
     */
    protected function export_csv($days){
        $filenamefirst              = 'surveys_inbound';
        $filenamesecond             = 'surveys_outbound';
        $filenamethird              = 'surveys_released';
        $filetime                   = time();

        $events = [$filenamefirst,$filenamesecond,$filenamethird];

        for($i=0;$i<count($events);$i++){
            $builderview = $this->builderview($this->query_surveys($days,$events[$i]));
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
        $filename               = 'report_surveys_'.time();
        Excel::create($filename, function($excel) use($days) {

            $excel->sheet('Inbound', function($sheet) use($days) {
                $sheet->fromArray($this->builderview($this->query_surveys($days,'surveys_inbound')));
            });

            $excel->sheet('Outbound', function($sheet) use($days) {
                $sheet->fromArray($this->builderview($this->query_surveys($days,'surveys_outbound')));
            });


            $excel->sheet('Released', function($sheet) use($days) {
                $sheet->fromArray($this->builderview($this->query_surveys($days,'surveys_released')));
            });


        })->store('xlsx','exports');

        $data = [
            'succes'    => true,
            'path'      => ['http://'.$_SERVER['HTTP_HOST'].'/exports/'.$filename.'.xlsx']
        ];

        return $data;
    }   

}
