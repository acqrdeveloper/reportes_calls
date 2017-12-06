<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Models\Anexo;
use Cosapi\Models\Queues;
use Cosapi\Models\User;
use Cosapi\Models\Users_Queues;
use Cosapi\Models\QueuePriority;

use Illuminate\Support\Facades\DB;
use Cosapi\Models\DetalleEventos;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Datatables;
use Excel;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class CosapiController extends Controller
{
    public function __construct()
    {
        if (!Session::has('UserId')) {
            Session::put('UserId', Auth::user()->id);
        }
        if (!Session::has('UserRole')) {
            Session::put('UserRole', Auth::user()->role);
        }
        if (!Session::has('UserName')) {
            Session::put('UserName', Auth::user()->primer_nombre.' '.Auth::user()->apellido_paterno);
        }
        if (!Session::has('UserSystem')) {
            Session::put('UserSystem', Auth::user()->username);
        }

        // Tipo de password modificado
        $type_password = 0;
        if (Auth::user()->password == '$2y$10$9TTAuZKJgHLvDfDlvt2fY.vWlj2EqwG6iGLJ.zuaxbqaA3.EBXPOW') {
            $type_password = 1;
        }
        Session::put('UserPassword', $type_password);

        Session::put('UserAnexo', 'Sin Anexo');
        $Anexos = Anexo::select('name')->where('user_id', '=', Auth::user()->id)->get()->toArray();
        if (count($Anexos) != 0) {
            $name_anexo = $Anexos[0]['name'];
            Session::put('UserAnexo', $name_anexo);
        }

        $this->UserId       = Session::get('UserId')        ;
        $this->UserRole     = Session::get('UserRole')      ;
        $this->UserName     = Session::get('UserName')      ;
        $this->UserSystem   = Session::get('UserSystem')    ;
        $this->UserPassword = Session::get('UserPassword')  ;
        $this->UserAnexo    = Session::get('UserAnexo')     ;
    }

    /**
     * [MostrarFechaActual Función que permite obtener la Fecha Actual]
     */
    protected function ShowDateAndTimeCurrent($filter)
    {
        if ($filter === 'all') {
            return Carbon::now()->toDateTimeString();
        }
        if ($filter === 'justTheDate') {
            return Carbon::now()->toDateString();
        }
        if ($filter === 'justTheTime') {
            return Carbon::now()->toTimeString();
        }
        if ($filter === 'personalizeDate') {
            return Date::now()->format('l j \\d\\e F \\d\\e Y');
        }
    }

    /**
     * [MostrarFechaActual Función que permite obtener la Fecha Actual]
     */
    protected function MostrarFechaActual()
    {
        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        return $date;
    }

    /**
     * [MostrarSoloHora Función que permite extraer la hora de la fecha completa '2016-10-25 12:55:42' => '12:55:42']
     * @param [datetime] $fecha [Fecha en formato Datetime, Ejem: '2016-10-02 15:45:44']
     */
    protected function MostrarSoloHora($fecha)
    {
        $date='00:00:00';
        if (! empty($fecha)) {
            $date = Carbon::parse($fecha);
            $date = $date->toTimeString();
        }
        return $date;
    }

    /**
     * [MostrarSoloFecha Función que permite extraer la fecha de la fecha completa '2016-10-25 12:55:42' => '2016-10-25']
     * @param [datetime] $fecha [Fecha en formato Datetime, Ejem: '2016-10-02 15:45:44']
     */
    protected function MostrarSoloFecha($fecha)
    {
        if (! empty($fecha)) {
            $date = Carbon::parse($fecha);
            $date = $date->toDateString();
            return $date;
        }
    }

    /**
     * [FormatDatatable Función que retorna en formato Datatable]
     * @param [Collection] $collection [Collection con los datos a mostrar en los reportes]
     */
    protected function FormatDatatable($collection)
    {
        return Datatables::of($collection)->make(true);
    }

    /**
     * [BuilderExport Función que permite crear archivoz para exportar]
     * @param [Array]  $array    [Manda los datos a exportar]
     * @param [String] $namefile [Nombre del archivo a generar]
     * @param [String] $format   [Formato en que va a exportar Ejmple: CSV,Excel]
     * @param [Array]  $location [Ubicación del archivo exportado]
     */
    protected function BuilderExport($array, $namefile, $format, $location)
    {
        Excel::create($namefile, function ($excel) use ($array,$namefile) {
            $excel->sheet($namefile, function ($sheet) use ($array) {
                $sheet->fromArray($array);
            });
        })->store($format, $location);
    }

    /**
     * [get_ultimo_evento Función que permite obtener el último eventodel usuario]
     * @param  [int]   $user_id [Id del usuario]
     * @return [Array]          [Array con el ultimo evento realizado por el agente]
     */
    protected function get_ultimo_evento($user_id)
    {
        $ultimo_evento   = DetalleEventos::Select('evento_id')
                         ->where('user_id', '=', $user_id)
                         ->orderby('fecha_evento', 'desc')
                         ->first();

        return $ultimo_evento;
    }


    /**
     * [registrar_eventos description]
     * @param  [string] $evento_id     [El id del evento de pausa que acciono el agente via web.]
     * @param  [string] $user_id       [Capturar el ID del usuario conectado]
     * @param  [string] $anexo         [El anexo del agente]
     * @param  [string] $fecha_evento  [La fecha de la realización del evento (Nivel de Ocupacion)]
     * @param  [string] $fecha_really  [La fecha real de realización del evento]
     * @param  [string] $observaciones [Obersvación del evento]
     */
    public function registrar_eventos($evento_id, $user_id, $anexo = '', $fecha_evento = '', $fecha_really = '', $observaciones = '')
    {
        /** Guarda Eventos  */
        if ($fecha_evento == '') {
            $fecha_evento = Carbon::now();
        } else {
            $fecha_evento = $fecha_evento;
        }
        if ($fecha_really == '') {
            $fecha_really = Carbon::now();
        } else {
            $fecha_really = $fecha_really;
        }

        \DB::table('detalle_eventos')->insert(array(
            'evento_id'     => $evento_id,
            'user_id'       => $user_id,
            'fecha_evento'  => $fecha_evento,
            'date_really'   => Carbon::now(),
            'anexo'         => $anexo,
            'observaciones' => $observaciones
        ));
    }

    /**
     * [Función que devuelte la lista de vdn de las Colas]
     * @return Array $list_queues
     */
    protected function list_vdn()
    {
        $list_queues                                = [];
        $query_queues                               = Queues::select()->get()->toArray();
        foreach ($query_queues as $queues) {
            $list_queues[$queues['name']]['vdn']    = $queues['vdn'];
        }
        return $list_queues;
    }

    /**
     * [Funcion que retorna las Colas que pueden visualzarce ]
     * @return array $queues_proyect [Array con la colas]
     */
    protected function queues_proyect()
    {
        $queues_proyect     = [];
        $posicion           = 0;
        $query_queues       = Queues::select()->get()->toArray();
        foreach ($query_queues as $queues) {
            $queues_proyect[$posicion] = $queues['name'];
            $posicion++;
        }
        return $queues_proyect;
    }

    /**
     * [Función que lista usuarios del sistema]
     * @param $id_usuario   [Array con id de los usuarios a mostrar información]
     * @return mixed        [Array con datos de los usuarios solicitados]
     */
    protected function query_user($id_usuario)
    {
        $Users                  = User::select()
                                        ->filtro_usuarios($id_usuario)
                                        ->where('estado_id', '=', '1')
                                        ->orderBy('primer_nombre')
                                        ->orderBy('apellido_paterno')
                                        ->orderBy('apellido_paterno')
                                        ->get()
                                        ->toArray();
        return $Users;
    }

    /**
     * [Función que lista datos de las colas]
     * @return array [Array con datos de cada cola registrada en el sistema]
     */
    protected function list_queue()
    {
        $list_prioridad     = [];
        $Colas              = Queues::select()
                                    ->with('estrategia', 'prioridad')
                                    ->where('estado_id', '=', 1)
                                    ->get()->toArray();
        foreach ($Colas as $Cola) {
            $list_prioridad[$Cola['id']]['id']         = $Cola['id'];
            $list_prioridad[$Cola['id']]['name']       = $Cola['name'];
            $list_prioridad[$Cola['id']]['estrategia'] = $Cola['estrategia']['name'];
            $list_prioridad[$Cola['id']]['prioridad']  = $Cola['prioridad']['name'];
            $list_prioridad[$Cola['id']]['vdn']        = $Cola['vdn'];
        }
        return $list_prioridad;
    }

    /**
     * @param $evento_id : El id del evento de pausa que acciono el agente via web.
     * @param $user_id   : Capturar el ID del usuario conectado.
     */
    public function register_event($evento_id, $user_id, $user_rol, $anexo = '', $fecha_evento = '', $observaciones = '', $date_really ='')
    {
        /** Guarda Eventos  */
        if ($fecha_evento == '') {
            $fecha_evento = Carbon::now();
        } else {
            $fecha_evento = $fecha_evento;
        }
        if ($date_really  == null) {
            $date_really  = null;
        } else {
            $date_really  = Carbon::now();
        }

        \DB::table('detalle_eventos')->insert(array(
            'evento_id'     => $evento_id,
            'user_id'       => $user_id,
            'fecha_evento'  => $fecha_evento,
            'date_really'   => $date_really,
            'anexo'         => $anexo,
            'observaciones' => $observaciones,
            'ip_cliente'    => $_SERVER['REMOTE_ADDR'],
            'user_rol'      => $user_rol
        ));
    }


    public function register_agent_dashboard($user_name, $anexo)
    {
        \DB::table('agent_online')->insert(array(
            'name_agent'     => 'Agent/'.$user_name,
            'number_annexed' => $anexo,
            'name_event'     => 'Login'
        ));
    }

    /**
     * [Function que devuelve datos de el primer logueo realizado por el usuario]
     * @return array
     */
    protected function UltimateEventLogin()
    {
        $users      = DetalleEventos::Select(DB::raw('count(*) as cant_event,id,date_really,fecha_evento'))
            ->where('user_id', '=', $this->UserId)
            ->where('evento_id', '=', 11)
            ->where(DB::raw('DATE(fecha_evento)'), '=', date('Y-m-d'))
            ->orderBy('id', 'asc')
            ->get();
        foreach ($users as $user) {
            $cant_event     = $user->cant_event;
            $date_really    = $user->date_really;
            $fecha_evento   = $user->fecha_evento;
            $id             = $user->id;
        }

        return array($cant_event,$date_really, $fecha_evento, $id);
    }

    /**
     * [Funcion para obtener el tamaño de los anexos]
     */
    protected function lengthAnnexed()
    {
        return Anexo::select(DB::raw('LENGTH(name) AS annexed_length'))->groupBy(DB::raw('LENGTH(name)'))->get()->toArray();
    }

    /**
     * [Funcion para crear una carpeta y no crearla si ya existe]
     */
    public function makeDirectory($path, $mode = 0777, $recursive = false, $force = false)
    {
        if ($force) {
            return @mkdir($path, $mode, $recursive);
        } else {
            return mkdir($path, $mode, $recursive);
        }
    }

    public function getQueueGlobal()
    {
        return Queues::Select()->get()->toArray();
    }

    public function getQueuesUserGlobal($userID)
    {
        return Users_Queues::Select()->where('user_id', $userID)->get()->toArray();
    }

    public function getPriorityGlobal()
    {
        return  QueuePriority::Select()->get()->toArray();
    }

    protected function getQueuestoUserGlobal($QueuesUser, $Queues, $weightPriority)
    {
        $resultArray = $QueuesUser;
        foreach ($QueuesUser as $keyUserQueue => $valUserQueue) {
            foreach ($Queues as $keyQueue => $valQueue) {
                if ($valUserQueue['queue_id'] == $valQueue['id']) {
                    foreach ($weightPriority as $keyWeight => $valWeight) {
                        if ($valUserQueue['priority'] == $valWeight['id']) {
                            $resultArray[$keyUserQueue] = $valUserQueue + array('Queues' => $valQueue) + array('Priority' => $valWeight);
                        }
                    }
                }
            }
        }
        return $resultArray;
    }

    protected function getUserGlobal($userID)
    {
        return User::Select()->where('id', $userID)->get()->toArray();
    }

    function customDataFilter(){
        $listUsers  = User::Select()
                        ->where('estado_id', '=', '1')
                        ->whereNotIn('role', ['admin'])
                        ->orderBy('primer_nombre')
                        ->orderBy('apellido_paterno')
                        ->orderBy('apellido_materno')
                        ->get()
                        ->toArray();

        $customData = array();

        foreach ($listUsers as $key => $user){
            $customData['listUsers']['idUser'][$key] = $user['id'];
            $customData['listUsers']['fullName'][$key] = $user['primer_nombre'].' '.$user['segundo_nombre'].' '.$user['apellido_paterno'].' '.$user['apellido_materno'];
        }

        return $customData;
    }

    /**
     * [reportAction Función que habilita las opciones que existen en los reportes]
     * @param boxReport Habilita el contenedor de las opciones del reporte
     * @param dateHourFilter Habilita el contenedor donde se encuentra los input para poder filtrar por fecha, hora, tipo, y el boton que ejecuta la busqueda
     * @param dateFilter Habilita el input para poder filtrar por fechas los reportes
     * @param viewDateSearch Habilita la función para que muestre un calendario completo
     * @param viewDateSingleSearch Habilita la función para que muestre un calendario simple
     * @param viewHourSearch Habilita el input para filtrar por una hora o media hora
     * @param viewRolTypeSearch Habilita el filtro por rol
     * @param viewButtonSearch Habilita el boton para ejecutar la busqueda
     * @param viewButtonExport Habilita los botones para exportar la informaci
     * @param viewCustomFilter
     * @param $customDataFilter
     * @return Devuelve un array con las opciones del reporte
     */

    function reportAction($arrayAction, $customDataFilter){
        return array(
            'boxReport'             => in_array('boxReport',$arrayAction) ? true : false,
            'dateHourFilter'        => in_array('dateHourFilter',$arrayAction) ? true : false,
            'dateFilter'            => in_array('dateFilter',$arrayAction) ? true : false,
            'viewDateSearch'        => in_array('viewDateSearch',$arrayAction) ? true : false,
            'viewDateSingleSearch'  => in_array('viewDateSingleSearch',$arrayAction) ? true : false,
            'viewHourSearch'        => in_array('viewHourSearch',$arrayAction) ? true : false,
            'viewRolTypeSearch'     => in_array('viewRolTypeSearch',$arrayAction) ? true : false,
            'viewButtonSearch'      => in_array('viewButtonSearch',$arrayAction) ? true : false,
            'viewButtonExport'      => in_array('viewButtonExport',$arrayAction) ? true : false,
            'viewCustomFilter'      => in_array('viewCustomFilter',$arrayAction) ? true : false,
            'customDataFilter'      => $customDataFilter
        );
    }
}
