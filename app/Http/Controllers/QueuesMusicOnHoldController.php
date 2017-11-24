<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Cosapi\Models\QueuesMusicOnHold;
use Illuminate\Http\Request;

use Cosapi\Http\Requests;
use Cosapi\Http\Controllers\Controller;

class QueuesMusicOnHoldController extends CosapiController
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
                return $this->list_music_on_hold();
            } else {
                return view('elements/index')->with(array(
                    'routeReport'           => 'elements.manage.asterisk.asterisk_music_on_hold',
                    'titleReport'           => 'Manage Music On Hold',
                    'boxReport'             => false,
                    'dateHourFilter'        => false,
                    'dateFilter'            => false,
                    'viewDateSearch'        => false,
                    'viewDateSingleSearch'  => false,
                    'viewHourSearch'        => false,
                    'viewRolTypeSearch'     => false,
                    'viewButtonSearch'      => false,
                    'viewButtonExport'      => false,
                    'exportReport'          => '',
                    'nameRouteController'   => 'manage_music_on_hold'
                ));
            }
        }
    }

    public function list_music_on_hold()
    {
        $query_music_on_hold_list       = $this->music_on_hold_list_query();
        $builderview                    = $this->builderview($query_music_on_hold_list);
        $outgoingcollection             = $this->outgoingcollection($builderview);
        $music_on_hold_list             = $this->FormatDatatable($outgoingcollection);
        return $music_on_hold_list;
    }

    protected function music_on_hold_list_query()
    {
        $template_queues_list_query = QueuesMusicOnHold::select()
            ->get();
        return $template_queues_list_query;
    }

    protected function builderview($template_queues_list_query)
    {
        $posicion = 0;
        foreach ($template_queues_list_query as $query) {
            $builderview[$posicion]['Id']                       = $query['id'];
            $builderview[$posicion]['Name']                     = $query['name_music'];
            $builderview[$posicion]['Mode']                     = $query['mode_music'];
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
                'Mode'                  => $view['Mode'],
                'Status'                => '<span class="label label-'.($Status == 'Activo' ? 'success' : 'danger').' labelFix">'.$Status.'</span>'
            ]);
        }
        return $outgoingcollection;
    }
}
