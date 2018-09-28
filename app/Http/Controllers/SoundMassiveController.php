<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Cosapi\Models\SoundMassive;
use Illuminate\Http\Request;

define('PATH_MASSIVE', '/cosapi_data/archivos_asterisk/voces/massive/');

class SoundMassiveController extends CosapiController
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      if ($request->fecha_evento) {
        return $this->prepare();
      } else {
        $arrayReport = $this->reportAction(array(), '');
        $arrayMerge = array_merge(array(
          'routeReport' => 'layout.recursos.forms.sound_massive.index',
          'titleReport' => 'Manage Sound Massive',
          'exportReport' => 'export_list_sound_massive',
          'nameRouteController' => 'manage_sound_massive'
        ), $arrayReport);
        return view('elements/index')->with($arrayMerge);
      }
    }
  }

  public function formChangeStatus(Request $request)
  {
    $getSoundMassive = $this->getSoundMassive($request->valueID);
    return view('layout/recursos/forms/sound_massive/form_status')->with(array(
      'idSoundMassive' => $getSoundMassive[0]['id'],
      'nameSoundMassive' => $getSoundMassive[0]['name_massive'],
      'Status' => $getSoundMassive[0]['estado_id']
    ));
  }
  public function saveFormSoundMassiveStatus(Request $request)
  {
    if ($request->ajax()) {
      SoundMassive::where('id', '!=', $request->soundMassiveID)
        ->update([
          'estado_id' => 2
        ]);
      $statusSoundMassive = ($request->statusSoundMassive == 1 ? 2 : 1);
      $soundMassiveQueryStatus = SoundMassive::where('id', $request->soundMassiveID)
        ->update([
          'estado_id' => $statusSoundMassive
        ]);
      if ($soundMassiveQueryStatus) {
        return ['message' => 'Success'];
      }
      return ['message' => 'Error'];
    }
    return ['message' => 'Error'];
  }

  function getDataList($id = null)
  {
    if (is_null($id)) {
      return SoundMassive::get();
    } else {
      return SoundMassive::where('id', $id)->first();
    }
  }
  function builderview($getDataList)
  {
    $posicion = 0;
    foreach ($getDataList as $query) {
      $builderview[$posicion]['id'] = $query['id'];
      $builderview[$posicion]['name_massive'] = $query['name_massive'];
      $builderview[$posicion]['state_masive'] = $query['state_masive'];
      $builderview[$posicion]['state_ivr'] = $query['state_ivr'];
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
      $statusMassive = ($view['state_masive'] == 1 ? 'Activo' : 'Inactivo');
      $statusIvr = ($view['state_ivr'] == 1 ? 'Activo' : 'Inactivo');
      $datacollection->push([
        'id' => $i,
        'name_massive' => $view['name_massive'],
        'state_masive' => '<span class="label label-' . ($statusMassive == 'Activo' ? 'success' : 'danger') . ' labelFix">' . $statusMassive . '</span>',
        'state_ivr' => '<span class="label label-' . ($statusIvr == 'Activo' ? 'success' : 'danger') . ' labelFix">' . $statusIvr . '</span>',
        'actions' => '<span data-toggle="tooltip" data-placement="left" title="Editar">
                        <a class="btn btn-warning btn-xs" onclick="responseModal(' . "'div.dialogAsterisk','form_edit_sound_massive','" . $view['id'] . "'" . ')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-edit" aria-hidden="true"></i></a>
                      </span>
                      <span data-toggle="tooltip" data-placement="left" title="Eliminar">
                        <a class="btn btn-danger btn-xs" onclick="responseModal(' . "'div.dialogAsterisk','form_delete_sound_massive','" . $view['id'] . "'" . ')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-trash" aria-hidden="true"></i></a>
                      </span>',
      ]);
    }
    return $datacollection;
  }

  function prepare()
  {
    $getDataList = $this->getDataList();
    $builderview = $this->builderview($getDataList);
    $dataCollection = $this->dataCollection($builderview);
    $FormatDatatable = $this->FormatDatatable($dataCollection);
    return $FormatDatatable;
  }

  function formCreate()
  {
    return view('layout.recursos.forms.sound_massive.form_create');
  }
  function formEdit(Request $request)
  {
    $dataSM = $this->getDataList((int)$request->valueID);
    $allStatus = [1=>'Activar con Audio',2=>'Activar sin Audio',3=>'Desactivar Todos'];
    return view('layout.recursos.forms.sound_massive.form_edit',compact('dataSM','allStatus'));
  }
  function formDelete(Request $request)
  {
    $dataSM = $this->getDataList((int)$request->valueID);
    return view('layout.recursos.forms.sound_massive.form_delete',compact('dataSM'));
  }

  function create(Request $request)
  {
    $this->validate($request, [
      "name_massive" => "required",
    ]);
    if ($request->ajax()) {
      $rpta = (new SoundMassive())->insert([
        "name_massive" => $request->name_massive,
        "route_massive" => PATH_MASSIVE . str_replace(' ', '_', trim(strtolower($request->name_massive))),
        "state_masive" => 2,
        "state_ivr" => 2,
      ]);
      if ($rpta) {
        return ['message' => 'Success'];
      }
      return ['message' => 'Error'];
    }
    return ['message' => 'Error'];
  }
  function update(Request $request)
  {
    $this->validate($request, [
      "name_massive" => "required",
      "state" => "required",
    ]);
    if ($request->ajax()) {
      $insertStatus = [];
      if($request->state == 3){
        $insertStatus = [2,2];
      }else if($request->state == 2){
        $insertStatus = [2,1];
      }else if($request->state == 1){
        $insertStatus = [1,2];
      }
      $rpta = SoundMassive::where('id', (int)$request->sound_massive_id)->update([
        "name_massive" => $request->name_massive,
        "route_massive" => PATH_MASSIVE . str_replace(' ', '_', trim(strtolower($request->name_massive))),
        "state_masive" => $insertStatus[0],
        "state_ivr" => $insertStatus[1],
      ]);
      if ($rpta) {
        return ['message' => 'Success'];
      }
      return ['message' => 'Error'];
    }
    return ['message' => 'Error'];
  }
  function delete(Request $request)
  {
    $this->validate($request, [
      "sound_massive_id" => "required",
    ]);
    if ($request->ajax()) {
      $rpta = SoundMassive::where('id', $request->sound_massive_id)->delete();
      if ($rpta) {
        return ['message' => 'Success'];
      }
      return ['message' => 'Error'];
    }
    return ['message' => 'Error'];
  }
  function status()
  {

  }
}
