<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Cosapi\Models\SoundMassive;
use Illuminate\Http\Request;

class SoundMassiveController extends CosapiController
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
                return $this->list_sound_massive();
            } else {
                return view('elements/index')->with(array(
                    'routeReport'           => 'elements.manage.asterisk.asterisk_sound_massive',
                    'titleReport'           => 'Manage Sound Massive',
                    'boxReport'             => false,
                    'dateHourFilter'        => false,
                    'dateFilter'            => false,
                    'viewDateSearch'        => false,
                    'viewDateSingleSearch'  => false,
                    'viewHourSearch'        => false,
                    'viewRolTypeSearch'     => false,
                    'viewButtonSearch'      => false,
                    'viewButtonExport'      => false,
                    'exportReport'          => 'export_list_sound_massive',
                    'nameRouteController'   => 'manage_sound_massive'
                ));
            }
        }
    }

    public function list_sound_massive()
    {
        $query_sound_massive_list   = $this->sound_massive_list_query();
        $builderview                = $this->builderview($query_sound_massive_list);
        $outgoingcollection         = $this->outgoingcollection($builderview);
        $sound_massive_list         = $this->FormatDatatable($outgoingcollection);
        return $sound_massive_list;
    }

    protected function sound_massive_list_query()
    {
        $sound_massive_list_query = SoundMassive::select()
            ->get();
        return $sound_massive_list_query;
    }

    protected function builderview($sound_massive_list_query)
    {
        $posicion = 0;
        foreach ($sound_massive_list_query as $query) {
            $builderview[$posicion]['Id']                       = $query['id'];
            $builderview[$posicion]['Name']                     = $query['name_massive'];
            $builderview[$posicion]['Status']                   = $query['estado_id'];
            $posicion ++;
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
            $Status = ($view['Status'] == 1 ? 'Activo' : 'Inactivo');
            $outgoingcollection->push([
                'Id'                    => $i,
                'Name'                  => $view['Name'],
                'Status'                => '<span class="label label-'.($Status == 'Activo' ? 'success' : 'danger').' labelFix">'.$Status.'</span>',
                'Actions'               => '<span data-toggle="tooltip" data-placement="left" title="Change Status"><a class="btn btn-danger btn-xs" onclick="responseModal('."'div.dialogAsterisk','form_status_sound_massive','".$view['Id']."'".')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-retweet" aria-hidden="true"></i></a></span>'
            ]);
        }
        return $outgoingcollection;
    }

    public function formChangeStatus(Request $request)
    {
        $getSoundMassive   = $this->getSoundMassive($request->valueID);
        return view('layout/recursos/forms/sound_massive/form_status')->with(array(
            'idSoundMassive'    => $getSoundMassive[0]['id'],
            'nameSoundMassive'  => $getSoundMassive[0]['name_massive'],
            'Status'            => $getSoundMassive[0]['estado_id']
        ));
    }

    public function getSoundMassive($idSoundMassive)
    {
        $soundMassive = SoundMassive::Select()
            ->where('id', $idSoundMassive)
            ->get()
            ->toArray();
        return $soundMassive;
    }

    public function saveFormSoundMassiveStatus(Request $request)
    {
        if ($request->ajax()) {
            SoundMassive::where('id', '!=' , $request->soundMassiveID)
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
}
