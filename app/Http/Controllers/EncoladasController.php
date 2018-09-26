<?php

namespace Cosapi\Http\Controllers;

use Carbon\Carbon;
use Cosapi\Collector\Collector;
use Cosapi\Models\CallWaiting;
use Illuminate\Http\Request;

class EncoladasController extends CosapiController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      if ($request->fecha_evento) {
        return $this->list_encoladas();
      } else {

        $arrayReport = $this->reportAction(array(), '');

        $arrayMerge = array_merge(array(
          'routeReport' => 'elements.manage.asterisk.encoladas',
          'titleReport' => 'Encoladas',
          'exportReport' => 'export_list_encoladas',
          'nameRouteController' => 'manage_encoladas'
        ), $arrayReport);

        return view('elements/index')->with($arrayMerge);
      }
    }
  }

  public function list_encoladas()
  {
    $query_sound_massive_list = $this->encoladas_list_query();
    $builderview = $this->builderview($query_sound_massive_list);
    $outgoingcollection = $this->outgoingcollection($builderview);
    $sound_massive_list = $this->FormatDatatable($outgoingcollection);

    return $sound_massive_list;
  }

  protected function encoladas_list_query()
  {
    $call_waiting = CallWaiting::select()->get();
    foreach ($call_waiting as $k => $v){
      $call_waiting[$k]['start_call'] = $this->diffTime($v['start_call']);
    }
    return $call_waiting;
  }

  protected function builderview($sound_massive_list_query)
  {
    $posicion = 0;
    foreach ($sound_massive_list_query as $query) {
      $builderview[$posicion]['Id'] = $query['id'];
      $builderview[$posicion]['Name_Queue'] = $query['name_queue'];
      $builderview[$posicion]['Name_Number'] = $query['name_number'];
      $builderview[$posicion]['Number_Phone'] = $query['number_phone'];
      $builderview[$posicion]['Start_Call'] = $query['start_call'];
      $posicion++;
    }

    if (!isset($builderview)) {
      $builderview = [];
    }

    return $builderview;
  }

  protected function outgoingcollection($builderview)
  {
    $outgoingcollection = new Collector();
    $i = 0;
    foreach ($builderview as $view) {
      $i++;
      $outgoingcollection->push([
        'Id' => $i,
        'Name_Queue' => $view['Name_Queue'],
        'Name_Number' => $view['Name_Number'],
        'Number_Phone' => $view['Number_Phone'],
        'Start_Call' => $view['Start_Call'],
        'Actions' => '<span data-toggle="tooltip" data-placement="left" title="Eliminar Llamada Encolada">
                        <a class="btn btn-danger btn-xs" onclick="responseModal(' . "'div.dialogAsterisk','form_template_encoladas','" . $view['Id'] . "'" . ')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-trash" aria-hidden="true"></i></a>
                      </span>',
      ]);
    }
    return $outgoingcollection;
  }

  public function formDeleteEncolada(Request $request)
  {
    $call_waiting = $this->getDataEncoladaId($request->valueID);
    if (isset($call_waiting[0])) {
      return view('layout/recursos/forms/templates/encoladas/form_status')->with(array(
        'idTemplateQueue' => $call_waiting[0]['id'],
        'nameTemplateQueue' => $call_waiting[0]['name_proyect'],
        'phone' => $call_waiting[0]['number_phone'],
        'duration' => $call_waiting[0]['start_call'],
      ));
    } else {
      return view('layout/recursos/forms/templates/encoladas/form_status')->with(['message' => 'Esta llamada encolada ha sido contestada o eliminada.']);
    }
  }

  public function getDataEncoladaId($call_waiting_id)
  {
    $call_waiting = CallWaiting::select()
      ->where('id', $call_waiting_id)
      ->get()
      ->toArray();
    return $call_waiting;
  }

  function diffTime($milliseconds)
  {
    $datetimeFormat = 'Y-m-d H:i:s';
    $timestamp = $milliseconds / 1000;
    $lastDate = date($datetimeFormat, $timestamp);
    $resp = Carbon::now()->diff(Carbon::parse($lastDate), true);
    $h = ($resp->h >= 10) ? $resp->h : '0' . $resp->h;
    $i = ($resp->i >= 10) ? $resp->i : '0' . $resp->i;
    $s = ($resp->s >= 10) ? $resp->s : '0' . $resp->s;
    return $h . ':' . $i . ':' . $s;
  }

  public function deleteEncoladaId(Request $request)
  {
    if ($request->ajax()) {
      $rpta = CallWaiting::where('id', $request->encoladaId)->delete();
      if ($rpta) {
        return ['message' => 'Success'];
      }
      return ['message' => 'Error'];
    }
    return ['message' => 'Error'];
  }
}
