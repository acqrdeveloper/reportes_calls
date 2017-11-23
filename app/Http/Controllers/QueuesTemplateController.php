<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Cosapi\Models\QueuesTemplate;
use Illuminate\Http\Request;

class QueuesTemplateController extends CosapiController
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
                return $this->list_template_queues();
            } else {
                return view('elements/index')->with(array(
                    'routeReport'           => 'elements.manage.asterisk.template.template_queues',
                    'titleReport'           => 'Manage Template Queues',
                    'boxReport'             => false,
                    'dateHourFilter'        => false,
                    'dateFilter'            => false,
                    'viewDateSearch'        => false,
                    'viewDateSingleSearch'  => false,
                    'viewHourSearch'        => false,
                    'viewRolTypeSearch'     => false,
                    'viewButtonSearch'      => false,
                    'viewButtonExport'      => false,
                    'exportReport'          => 'export_list_template_queue',
                    'nameRouteController'   => 'manage_template_queues'
                ));
            }
        }
    }

    public function list_template_queues()
    {
        $query_template_queues_list     = $this->template_queues_list_query();
        $builderview                    = $this->builderview($query_template_queues_list);
        $outgoingcollection             = $this->outgoingcollection($builderview);
        $template_queues_list           = $this->FormatDatatable($outgoingcollection);
        return $template_queues_list;
    }

    protected function template_queues_list_query()
    {
        $template_queues_list_query = QueuesTemplate::select()
            ->with('musicOnHold')
            ->get();
        return $template_queues_list_query;
    }

    protected function builderview($template_queues_list_query)
    {
        $posicion = 0;
        foreach ($template_queues_list_query as $query) {
            $builderview[$posicion]['Id']                       = $query['id'];
            $builderview[$posicion]['Name']                     = $query['name_template'];
            $builderview[$posicion]['MusicOnHold']              = $query['musiconhold']['name_music'];
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
                'MusicOnHold'           => $view['MusicOnHold'],
                'Status'                => '<span class="label label-'.($Status == 'Activo' ? 'success' : 'danger').' labelFix">'.$Status.'</span>',
                'Actions'               => '<span data-toggle="tooltip" data-placement="left" title="Edit Template Queue"><a class="btn btn-warning btn-xs" onclick="responseModal('."'div.dialogAsterisk','form_queues','".$view['Id']."'".')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-edit" aria-hidden="true"></i></a></span>
                                            <span data-toggle="tooltip" data-placement="left" title="Change Status"><a class="btn btn-danger btn-xs" onclick="responseModal('."'div.dialogAsterisk','form_status_queue','".$view['Id']."'".')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-retweet" aria-hidden="true"></i></a>'
            ]);
        }
        return $outgoingcollection;
    }

    public function formChangeStatus(Request $request)
    {
        $getQueue   = $this->getTemplateQueue($request->valueID);
        return view('layout/recursos/forms/queues/form_status')->with(array(
            'idQueue'    => $getQueue[0]['id'],
            'nameQueue'  => $getQueue[0]['name'],
            'Status'     => $getQueue[0]['estado_id']
        ));
    }

    public function getTemplateQueue($idTemplateQueue)
    {
        $template_queue = QueuesTemplate::Select()
            ->where('id', $idTemplateQueue)
            ->get()
            ->toArray();
        return $template_queue;
    }
}
