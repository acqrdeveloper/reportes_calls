<?php

namespace Cosapi\Http\Controllers;

use Illuminate\Http\Request;

use Cosapi\Models\Message;
use Cosapi\Models\DetalleViewMessage;

use Illuminate\Support\Facades\DB;

use Cosapi\Http\Requests;
use Cosapi\Http\Controllers\Controller;

class BroadcastMessageController extends CosapiController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->fecha_evento) {
                return $this->list_queues();
            } else {

                $arrayReport = $this->reportAction(array(),'');

                $arrayMerge = array_merge(array(
                    'routeReport'           => 'elements.broadcast.broadcast_message',
                    'titleReport'           => 'Broadcast Message',
                    'exportReport'          => '',
                    'nameRouteController'   => 'broadcast_message'
                ),$arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }
    }

    public function list_queues()
    {
        return 'Mensaje de Prueba';
    }

    public function getBroadcastMessage()
    {
        $users = \DB::table('messages')
          ->select(DB::raw('CONCAT(users.primer_nombre ," ",users.apellido_paterno) as nombrePublicador'), 'messages.message', 'messages.created_at')
          ->join('users', 'users.id', '=', 'messages.user_id')
          ->join('estados', 'estados.id', '=', 'messages.estado_id')
          ->leftJoin('detail_view_message', 'messages.id', '=', 'detail_view_message.message_id')
          ->whereNull('detail_view_message.message_id')
          ->get();

        $DetalleViewMessage = DetalleViewMessage::Select()
                              ->with('state', 'user')
                              ->get()->toArray();

        return response()->json(['getBroadcastMessage' => $users], 200);
    }
}
