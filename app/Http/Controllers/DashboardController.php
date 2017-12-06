<?php

namespace Cosapi\Http\Controllers;

use Carbon\Carbon;
use Cosapi\Models\AgentOnline;
use Cosapi\Models\Anexo;
use Cosapi\Models\Eventos;
use Cosapi\Models\Cdr;
use Cosapi\Models\Kpis;
use Cosapi\Models\Queue_Log;
use Cosapi\Models\Queues;
use Cosapi\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends IncomingCallsController
{
    /**
     * [dashboard_01 Función que llama a la vista del Dashboard 1]
     * @return [view] [returna vista HTML del Dashboard 1]
     */
    public function dashboard_01()
    {
        return view('elements/dashboard/dashboard_01');
    }

    public function getVariablesGlobals(Request $request)
    {
        try {
            $listProfile = [];
            $usersProfile = User::select(DB::raw('users.id as id, users.primer_nombre as primer_nombre, users.apellido_paterno as apellido_paterno, users.role as role, users_profile.avatar as avatar'))
                            ->leftJoin('agent_online', 'agent_online.agent_user_id', '=', 'users.id')
                            ->leftJoin('users_profile', 'users.id', '=', 'users_profile.user_id')
                            ->get()->toArray();

            foreach ($usersProfile as $users) {
                $listProfile[$users['id']]['avatar'] = ($users['avatar'] == null) ? 'default_avatar.png' : $users['avatar'];
                $listProfile[$users['id']]['nameComplete'] = $users['primer_nombre'] . ' ' . $users['apellido_paterno'];
                $listProfile[$users['id']]['role'] = $users['role'];
            }

            $listEventos = Eventos::select('id', 'name')->Orderby('id')->get()->toArray();
            return response()->json([
              'listAllUserProfile' => $listProfile,
              'listAllEventos' => $listEventos,
              'hourServer' => $this->ShowDateAndTimeCurrent('justTheTime'),
              'dateServer' => $this->ShowDateAndTimeCurrent('justTheDate'),
              'textDateServer' => $this->ShowDateAndTimeCurrent('personalizeDate')
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getEventKpi(Request $request)
    {
        if ($request->ajax()) {
            try {
                $kpis = Kpis::all();

                if ($request->rangeDateSearch === 'forDay') {
                    $dateStart = Carbon::now()->startOfday();
                    $dateEnd = Carbon::now()->endOfday();
                } else {
                    $dateStart = Carbon::now()->startOfMonth();
                    $dateEnd = Carbon::now()->endOfMonth();
                }

                foreach ($kpis as $kpi) {
                    $metrica['action'] = $kpi->symbol ? true : false;
                    $metrica['symbol'] = $kpi->symbol ? $kpi->symbol : '';
                    $metrica['time'] = $kpi->time ? $kpi->time : 'a';

                    $nameEvent = $this->get_events(str_replace('_time', '', $kpi->name));
                    $groupEvent = $this->get_events($nameEvent);

                    $queueLog = Queue_Log::select()
                                    ->whereIn('event', $groupEvent)
                                    ->whereBetween('datetime', [$dateStart, $dateEnd])
                                    ->filtro_time($metrica)
                                    ->count();

                    $resultKpis[$kpi->name] = [
                        'message' => $queueLog,
                        'symbol' => $kpi->symbol,
                        'time' => $kpi->time
                      ];
                }
                return response()->json([$resultKpis], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
    }

    public function getQuantityCalls(Request $request)
    {
        if ($request->nameAgent) {
            try {
                $query_calls = $this->query_calls(date('Y-m-d') . ' - ' . date('Y-m-d'), 'calls_completed', $request->nameAgent);
                $QuantityCalls = count($query_calls);

                return response()->json(['message' => $QuantityCalls], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
    }

    public function panelAgentStatusSummary(Request $request)
    {
        try {
            $AgentOnline = AgentOnline::select(DB::raw('agent_role, event_id, eventos.name as event_name, count(1) as quantity'))
                            ->join('eventos', 'eventos.id', '=', 'event_id')
                            ->whereIn('agent_role', $request->filterRoles)
                            ->groupBy('event_id')
                            ->get()->toArray();
            return response()->json(['message' => $AgentOnline], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getListQueues (Request $request) {
        try {
            $query = Queues::select()
                        ->with('music')
                        ->where('estado_id','=','1')
                        ->orderBy('queues_priority_id', 'desc')
                        ->get()->toArray();
            return response()->json(['listQueues' => $query], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function panelGroupStatistics(Request $request)
    {
        try {
            $Answer = 0;
            $Unanswer = 0;
            $totalReceived = 0;
            $timeInQueue = 0;

            $totalCallDurationInbound = 0;
            $avgWait = 0;
            $avgCallDuration = 0;
            $percentageAnswer = 0;
            $percentageUnanswer = 0;

            $Queue_Log = Queue_Log::select(DB::raw('event, SUM(ABS(info1)) as timeInQueue, SUM(ABS(info2)) AS timeCallDuration, count(1) AS quantityEvent '))
                          ->where(DB::raw('DATE(datetime)'), date('Y-m-d'))
                          ->groupBy('event')
                          ->get()
                          ->toArray();

            $days = explode(' - ', date('Y-m-d') . ' - ' . date('Y-m-d'));
            $range_annexed = Anexo::select('name')->where('estado_id', '1')->get()->toArray();
            $tamano_anexo = $this->lengthAnnexed();

            $OutgoingCallsController = Cdr::Select(DB::raw('SUM(billsec) AS billsec'))
                                        ->whereIn(DB::raw('LENGTH(src)'), $tamano_anexo)
                                        ->where('dst', 'not like', '*%')
                                        ->where('disposition', '=', 'ANSWERED')
                                        ->where('lastapp', '=', 'Dial')
                                        ->whereIn('src', $range_annexed)
                                        ->filtro_days($days)
                                        ->get()
                                        ->toArray();

            for ($i = 0; $i < count($Queue_Log); $i++) {
                if ($Queue_Log[$i]['event'] != 'ABANDON') {
                    $Answer += $Queue_Log[$i]['quantityEvent'];
                    $totalCallDurationInbound += $Queue_Log[$i]['timeCallDuration'];
                } else {
                    $Unanswer += $Queue_Log[$i]['quantityEvent'];
                }
                $timeInQueue += $Queue_Log[$i]['timeInQueue'];
                $totalReceived += $Queue_Log[$i]['quantityEvent'];
            }
            $avgWait = (($Answer + $Unanswer) != 0) ? $timeInQueue / ($Answer + $Unanswer) : 0;
            $avgCallDuratioInbound = ($Answer != 0) ? $totalCallDurationInbound / ($Answer) : 0;
            $percentageAnswer = ($totalReceived != 0) ? ($Answer * 100) / $totalReceived : 0;
            $percentageUnanswer = ($totalReceived != 0) ? ($Unanswer * 100) / $totalReceived : 0;

            return response()->json([
                'avgWait' => conversorSegundosHoras(intval($avgWait), false),
                'avgCallDuration' => conversorSegundosHoras(intval($avgCallDuratioInbound), false),
                'percentageAnswer' => convertDecimales($percentageAnswer, 2),
                'percentageUnanswer' => convertDecimales($percentageUnanswer, 2),
                'totalCallDurationInbound' => conversorSegundosHoras(intval($totalCallDurationInbound), false),
                'totalCallDurationOutbound' => conversorSegundosHoras(intval($OutgoingCallsController[0]['billsec']), false)
      ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
