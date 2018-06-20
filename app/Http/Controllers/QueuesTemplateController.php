<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Cosapi\Http\Requests\QueuesTemplateRequest;
use Cosapi\Models\QueuesMusicOnHold;
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

                $arrayReport = $this->reportAction(array(),'');

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.manage.asterisk.template.template_queues',
                    'titleReport'           => 'Manage Template Queues',
                    'exportReport'          => '',
                    'nameRouteController'   => 'manage_template_queues'
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
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
                'Actions'               => '<span data-toggle="tooltip" data-placement="left" title="Edit Template Queue"><a class="btn btn-warning btn-xs" onclick="responseModal('."'div.dialogAsterisk','form_template_queues','".$view['Id']."'".')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-edit" aria-hidden="true"></i></a></span>
                                            <span data-toggle="tooltip" data-placement="left" title="Change Status"><a class="btn btn-danger btn-xs" onclick="responseModal('."'div.dialogAsterisk','form_status_template_queues','".$view['Id']."'".')" data-toggle="modal" data-target="#modalAsterisk"><i class="fa fa-retweet" aria-hidden="true"></i></a>'
            ]);
        }
        return $outgoingcollection;
    }

    public function formChangeStatus(Request $request)
    {
        $getTemplateQueues   = $this->getTemplateQueue($request->valueID);
        return view('layout/recursos/forms/templates/queues/form_status')->with(array(
            'idTemplateQueue'     => $getTemplateQueues[0]['id'],
            'nameTemplateQueue'   => $getTemplateQueues[0]['name_template'],
            'Status'              => $getTemplateQueues[0]['estado_id']
        ));
    }

    public function formTemplateQueues(Request $request)
    {
        $options    = $this->getOptions();
        $countMusicOnHold = $this->countMusicOnHold();
        if ($request->valueID == null) {
            return view('layout/recursos/forms/templates/queues/form_template_queues')->with(array(
                'updateForm'             => false,
                'optionsMusicOnHold'     => $options['MusicOnHold'],
                'idTemplateQueue'        => '',
                'nameTemplateQueue'      => '',
                'selectedMusicOnHold'    => '',
                'selectedJoinEmpty'      => '',
                'timeOut'                => '',
                'memberDelay'            => '',
                'selectedRingInUse'      => '',
                'selectedAutoPause'      => '',
                'selectedAutoPauseBusy'  => '',
                'wrapUptime'             => '',
                'maxLen'                 => '',
                'countMusicOnHold'       => $countMusicOnHold
            ));
        } else {
            $getTemplateQueue = $this->getTemplateQueue($request->valueID);
            return view('layout/recursos/forms/templates/queues/form_template_queues')->with(array(
                'updateForm'             => true,
                'optionsMusicOnHold'     => $options['MusicOnHold'],
                'idTemplateQueue'        => $request->valueID,
                'nameTemplateQueue'      => $getTemplateQueue[0]['name_template'],
                'selectedMusicOnHold'    => $getTemplateQueue[0]['music_onhold'],
                'selectedJoinEmpty'      => $getTemplateQueue[0]['empty_template'],
                'timeOut'                => $getTemplateQueue[0]['timeout_template'],
                'memberDelay'            => $getTemplateQueue[0]['memberdelay_template'],
                'selectedRingInUse'      => $getTemplateQueue[0]['ringinuse_template'],
                'selectedAutoPause'      => $getTemplateQueue[0]['autopause_template'],
                'selectedAutoPauseBusy'  => $getTemplateQueue[0]['autopausebusy_template'],
                'wrapUptime'             => $getTemplateQueue[0]['wrapuptime_template'],
                'maxLen'                 => $getTemplateQueue[0]['maxlen_template'],
                'countMusicOnHold'       => $countMusicOnHold
            ));
        }
    }

    public function getTemplateQueue($idTemplateQueue)
    {
        $template_queue = QueuesTemplate::Select()
            ->with('musicOnHold')
            ->where('id', $idTemplateQueue)
            ->get()
            ->toArray();
        return $template_queue;
    }

    public function getOptions()
    {
        $musicOnHold = QueuesMusicOnHold::Select()
            ->where('estado_id','=','1')
            ->get()
            ->toArray();

        $options['MusicOnHold']  = $musicOnHold;
        return $options;
    }

    public function countMusicOnHold()
    {
        $countMusicOnHold = QueuesMusicOnHold::Select()
            ->where('estado_id', '=', '1')
            ->count();
        return $countMusicOnHold;
    }

    public function saveFormTemplateQueuesStatus(Request $request)
    {
        if ($request->ajax()) {
            $statusTemplateQueue = ($request->statusTemplateQueue == 1 ? 2 : 1);
            $queueTemplateQueryStatus = QueuesTemplate::where('id', $request->templateQueueID)
                ->update([
                    'estado_id' => $statusTemplateQueue
                ]);
            if ($queueTemplateQueryStatus) {
                return ['message' => 'Success'];
            }
            return ['message' => 'Error'];
        }
        return ['message' => 'Error'];
    }

    public function saveFormTemplateQueues(QueuesTemplateRequest $request)
    {
        if ($request->ajax()) {
            $teamplateQueueQuery = QueuesTemplate::updateOrCreate([
                'id' => $request->templateQueueID
            ], [
                'name_template' => $request->nameTemplateQueue,
                'music_onhold' => $request->selectedMusicOnHold,
                'empty_template' => $request->selectedJoinEmpty,
                'timeout_template' => $request->timeOut,
                'memberdelay_template' => $request->memberDelay,
                'ringinuse_template' => $request->selectedRingInUse,
                'autopause_template' => $request->selectedAutoPause,
                'autopausebusy_template' => $request->selectedAutoPauseBusy,
                'wrapuptime_template' => $request->wrapUptime,
                'maxlen_template' => $request->maxLen,
                'estado_id' => '1'
            ]);

            $action = ($request->templateQueueID ? 'updated' : 'create');
            if ($teamplateQueueQuery) {
                return ['message' => 'Success', 'action' => $action];
            }
            return ['message' => 'Error'];
        }
        return ['message' => 'Error'];
    }
}
