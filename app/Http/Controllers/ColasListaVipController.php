<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Cosapi\Models\ColaVip;
use Cosapi\Models\Queues;
use Illuminate\Http\Request;
use Cosapi\Http\Controllers\Controller;

class ColasListaVipController extends CosapiController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //Si la solicitud es desde javascript
    if ($request->ajax()) {
      if ($request->fecha_evento) {
        return $this->lista_colas_vip();
      } else {//Si la solicitud es desde PHP
        $arrayReport = $this->reportAction(array(), '');
        $arrayMerge = array_merge(array(
          'routeReport' => 'elements.colas_vip.index',
          'titleReport' => 'Lista de Colas Vip',
          'exportReport' => 'export_list_vip',
          'nameRouteController' => 'colas_lista_vip'
        ), $arrayReport);
        return view('elements/index')->with($arrayMerge);
      }
    }
  }

  function lista_colas_vip()
  {
    $getDataList = $this->getDataList();
    $builderview = $this->builderview($getDataList);
    $dataCollection = $this->dataCollection($builderview);
    $FormatDatatable = $this->FormatDatatable($dataCollection);
    return $FormatDatatable;
  }

  function getDataList($id = null)
  {
    if (is_null($id)) {
      return ColaVip::select(['queue_list_vip.id', 'queue_list_vip.name', 'queue_list_vip.number_telephone', 'queue_list_vip.queue_id', 'queues.name AS queue_name'])->join('queues', 'queues.id', '=', 'queue_list_vip.queue_id')->get();
    } else {
      return ColaVip::select(['queue_list_vip.id', 'queue_list_vip.name', 'queue_list_vip.number_telephone', 'queue_list_vip.queue_id', 'queues.name AS queue_name'])->join('queues', 'queues.id', '=', 'queue_list_vip.queue_id')->where('queue_list_vip.id', $id)->first();
    }
  }

  function builderview($getDataList)
  {
    $posicion = 0;
    foreach ($getDataList as $query) {
      $builderview[$posicion]['id'] = $query['id'];
      $builderview[$posicion]['name'] = $query['name'];
      $builderview[$posicion]['number_telephone'] = $query['number_telephone'];
      $builderview[$posicion]['queue_id'] = $query['queue_id'];
      $builderview[$posicion]['queue_name'] = $query['queue_name'];
      $posicion++;
    }
    if (!isset($builderview)) {
      $builderview = [];
    }
    return $builderview;
  }

  function dataCollection($builderview)
  {
    $datacollection = new Collector();
    $i = 0;
    foreach ($builderview as $view) {
      $i++;
      $datacollection->push([
        'id' => $i,
        'name' => $view['name'],
        'number_telephone' => $view['number_telephone'],
        'queue_id' => $view['queue_id'],
        'queue_name' => $view['queue_name'],
        'actions' => '<span data-toggle="tooltip" data-placement="left" title="Editar Cola Vip">
                        <a class="btn btn-success btn-xs" onclick="responseModal(' . "'div.dialogAsterisk','form_edit_cola_vip','" . $view['id'] . "'" . ')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-edit" aria-hidden="true"></i></a>
                      </span>
                      <span data-toggle="tooltip" data-placement="left" title="Eliminar Cola Vip">
                        <a class="btn btn-danger btn-xs" onclick="responseModal(' . "'div.dialogAsterisk','form_delete_cola_vip','" . $view['id'] . "'" . ')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-trash" aria-hidden="true"></i></a>
                      </span>',
      ]);
    }
    return $datacollection;
  }

  function showFormDelete(Request $request)
  {
    $dataVip = $this->getDataList((int)$request->valueID);
    return view('elements.colas_vip.form_delete', compact('dataVip'));
  }

  function showFormEdit(Request $request)
  {
    $dataVip = $this->getDataList((int)$request->valueID);
    $dataQueue = Queues::get();
    return view('elements.colas_vip.form_edit', compact('dataVip', 'dataQueue'));
  }

  function showFormCreate(Request $request)
  {
    $dataQueue = Queues::get();
    return view('elements.colas_vip.form_create', compact('dataVip', 'dataQueue'));
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      "name" => "required",
      "number_telephone" => "required",
      "queue_id" => "required",
    ]);
    if ($request->ajax()) {
      $rpta = (new ColaVip())->insert([
        "name" => strtoupper($request->name),
        "number_telephone" => trim($request->number_telephone),
        "queue_id" => (int)$request->queue_id,
      ]);
      if ($rpta) {
        return ['message' => 'Success'];
      }
      return ['message' => 'Error'];
    }
    return ['message' => 'Error'];
  }

  public function update(Request $request)
  {
    $this->validate($request, [
      "name" => "required",
      "number_telephone" => "required",
      "queue_id" => "required",
    ]);
    if ($request->ajax()) {
      $rpta = ColaVip::where('id', $request->queue_vip_id)->update([
        "name" => strtoupper($request->name),
        "number_telephone" => trim($request->number_telephone),
        "queue_id" => (int)$request->queue_id,
      ]);
      if ($rpta) {
        return ['message' => 'Success'];
      }
      return ['message' => 'Error'];
    }
    return ['message' => 'Error'];
  }

  public function destroy(Request $request)
  {
    $this->validate($request, [
      "queue_vip_id" => "required",
    ]);
    if ($request->ajax()) {
      $rpta = ColaVip::where('id', $request->queue_vip_id)->delete();
      if ($rpta) {
        return ['message' => 'Success'];
      }
      return ['message' => 'Error'];
    }
    return ['message' => 'Error'];
  }

}
