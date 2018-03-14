<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Collector\Collector;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends CosapiController
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->fecha_evento != null) {
//                if ($request->group_filter == "groupAgent") {
                $data = $this->byUserAll($request);
                $builderview = $this->builderview2($data);
                $outgoingcollection = $this->outgoingcollection2($builderview);
                return $this->FormatDatatable($outgoingcollection);
//                }
//                else {
//                    $data = $this->byUser(null, $request);
//                    $builderview = $this->builderview($data);
//                    $outgoingcollection = $this->outgoingcollection($builderview);
//                    return $this->FormatDatatable($outgoingcollection);
//                }
            } else {
                $arrayReport = $this->reportAction(array(
                    'boxReport', 'dateHourFilter', 'dateFilter', 'viewDateSingleSearch', 'viewRolTypeSearch', 'viewButtonSearch', 'viewButtonExport'
                ), '');
                $arrayMerge = array_merge(array(
                    'routeReport' => 'elements.details_events_report.report_thirty',
                    'titleReport' => 'Report Level',
                    'exportReport' => 'export_level_events_report',
                    'nameRouteController' => ''
                ), $arrayReport);

                return view('elements/index')->with($arrayMerge);
            }
        }
    }

    public function byUserAll($request)
    {
        $users = DB::select("select * from users");
        $data = [];
        foreach ($users as $key => $user) {
            array_push($data, [$user->primer_nombre . " " . $user->apellido_paterno => $this->byUser($user, $request)]);
        }
        return $data;
    }

    public function byUser($user = null, $request = null)
    {
        $hours = [
            "00:00:00",
            "00:30:00",
            "01:00:00",
            "01:30:00",
            "02:00:00",
            "02:30:00",
            "03:00:00",
            "03:30:00",
            "04:00:00",
            "04:30:00",
            "05:00:00",
            "05:30:00",
            "06:00:00",
            "06:30:00",
            "07:00:00",
            "07:30:00",
            "08:00:00",
            "08:30:00",
            "09:00:00",
            "09:30:00",
            "10:00:00",
            "10:30:00",
            "11:00:00",
            "11:30:00",
            "12:00:00",
            "12:30:00",
            "13:00:00",
            "13:30:00",
            "14:00:00",
            "14:30:00",
            "15:00:00",
            "15:30:00",
            "16:00:00",
            "16:30:00",
            "17:00:00",
            "17:30:00",
            "18:00:00",
            "18:30:00",
            "19:00:00",
            "19:30:00",
            "20:00:00",
            "20:30:00",
            "21:00:00",
            "21:30:00",
            "22:00:00",
            "22:30:00",
            "23:00:00",
            "23:30:00"
        ];
        $data = [];
        $login = 0;
        $acd = 0;
        $break = 0;
        $sshh = 0;
        $refrigerio = 0;
        $feedback = 0;
        $capacitacion = 0;
        $backoffice = 0;
        $inbound = 0;
        $outbound = 0;
        $ring_inbound = 0;
        $ring_outbound = 0;
        $hold_inbound = 0;
        $hold_outbound = 0;
        $ring_inbound_interno = 0;
        $inbound_interno = 0;
        $outbound_interno = 0;
        $ring_outbound_interno = 0;
        $hold_inbound_interno = 0;
        $hold_outbound_interno = 0;
        $ring_inbound_transfer = 0;
        $ring_outbound_transfer = 0;
        $inbound_transfer = 0;
        $hold_inbound_transfer = 0;
        $hold_outbound_transfer = 0;
        $outbound_transfer = 0;
        $desconectado = 0;
        $events = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28];
        $current_range_hour = "";
        $current_user_id = "";
        //
        //Recorrer array horas

        foreach ($hours as $k => $v) {
            //Variables
            $i = $k;
            $j = $k + 1;
            $total = 0;
            $temp_diff_ini = 0;
            $temp_diff_fin = 0;
            $set = false;
            $last_data = null;
            //Params procedure
//            echo ($request);
            if (isset($request->fecha_evento)) {
                $date_to_arr = explode(" - ", $request->fecha_evento);
            } else {
                $date_to_arr = explode(" - ", $request->days);
            }
            $pfecha_ini = $date_to_arr[0];
            $pfecha_fin = $date_to_arr[1];

            if ($user != null) {
                $puser_id = $user->id;
            } else {
                $puser_id = 48;
            }
            $prol = $request->filter_rol;
            //Validar posicion para el rango de horario
            if (isset($hours[$k + 1])) {
                $query = DB::select("CALL SP_REPORT_30('" . $pfecha_ini . "','" . $pfecha_fin . "','" . $hours[$k] . "','" . $hours[$k + 1] . "'," . $puser_id . ",'" . $prol . "'); ");
            } else {
                $query = DB::select("CALL SP_REPORT_30('" . $pfecha_ini . "','" . $pfecha_fin . "','" . $hours[$k] . "','" . $hours[0] . "','" . $puser_id . "','" . $prol . "'); ");
            }
            //Si hay registros
            if (count($query)) {
                if (isset($hours[$k + 1])) {
                    $range_hour = $hours[$k] . " - " . $hours[$k + 1];
                } else {
                    $range_hour = $hours[$k] . " - " . $hours[0];
                }
                //Ultimo indice
                $index_final = count($query) - 1;
                //Recorrer registros
                foreach ($query as $kk => $vv) {

                    //Validar si estamos tratando el mismo usuario
                    if ($user != null) {
                        if ($vv->user_id != $current_user_id) {
                            $data = [];
                        }
                        if ($vv->user_id == $user->id) {
                            $current_user_id = $vv->user_id;
                        }
                    }

//##
                    if (isset($query[$kk + 1])) {
                        $diff_total = $this->getDiffDatetime($vv->date_event, $query[$kk + 1]->date_event, true);
                    } else {
                        $diff_total = $this->getDiffDatetime($vv->date_event, $query[0]->date_event, true);
                    }
                    //Primera regla
                    //Si es el primer indice
                    if ($kk == 0) {
                        $h = (new \DateTime($query[$kk]->date_event))->format("H:i:s");
                        if ($h != $hours[$i]) {
                            $temp_diff_ini = $this->getDiffDatetime($query[$kk]->date_event, $hours[$i], true);
                        }
                    }
                    //Segunda regla
                    //Si es el ultimo indice
                    if ($kk == $index_final) {
                        $h = (new \DateTime($query[$index_final]->date_event))->format("H:i:s");
                        if ($h != $hours[$j]) {
                            $temp_diff_fin = $this->getDiffDatetime($query[$index_final]->date_event, $hours[$j], true);
                        }
                    }
                    //Recorrer array rango por hora armado
                    for ($g = 0; $g <= count($hours); $g++) {
                        //Si es diferente al rango de hora
                        if ($range_hour != $current_range_hour) {
                            //Reinicializar estados
                            $login = 0;
                            $acd = 0;
                            $break = 0;
                            $sshh = 0;
                            $refrigerio = 0;
                            $feedback = 0;
                            $capacitacion = 0;
                            $backoffice = 0;
                            $inbound = 0;
                            $outbound = 0;
                            $ring_inbound = 0;
                            $ring_outbound = 0;
                            $hold_inbound = 0;
                            $hold_outbound = 0;
                            $ring_inbound_interno = 0;
                            $inbound_interno = 0;
                            $outbound_interno = 0;
                            $ring_outbound_interno = 0;
                            $hold_inbound_interno = 0;
                            $hold_outbound_interno = 0;
                            $ring_inbound_transfer = 0;
                            $ring_outbound_transfer = 0;
                            $inbound_transfer = 0;
                            $hold_inbound_transfer = 0;
                            $hold_outbound_transfer = 0;
                            $outbound_transfer = 0;
                            $desconectado = 0;
                            //Reinicializar total
                            $total = 0;
                        }
                        //Validar si seguimos en el rango de hora
                        if (isset($hours[$g + 1])) {
                            if ($range_hour == $hours[$g] . " - " . $hours[$g + 1]) {
                                //Set variable con rango de hora actual
                                $current_range_hour = $range_hour;
                            }
                        }
                    }
                    //Validar evento existente
                    $do = false;
                    for ($x = 0; $x <= count($events); $x++) {
                        if ($x == $vv->evento_id) {
                            $do = true;
                            break;
                        } else {
                            $do = false;
                        }
                    }
                    //Set ultimo indice para recalcular
                    if ($kk == $index_final) {
                        $diff_total = 0;
                        $set = true;
                        $last_data = array_merge(["data" => $vv], ["range" => $hours[$i] . " - " . $hours[$j]]);
                    } else {
                        $set = false;
                        $last_id = null;
                    }
                    //Validar y Cargar por evento
                    if ($do) {
                        switch ($vv->evento_id) {
                            case 1:
                                $acd += $diff_total;
                                break;
                            case 2:
                                $break += $diff_total;
                                break;
                            case 3:
                                $sshh += $diff_total;
                                break;
                            case 4:
                                $refrigerio += $diff_total;
                                break;
                            case 5:
                                $feedback += $diff_total;
                                break;
                            case 6:
                                $capacitacion += $diff_total;
                                break;
                            case 7:
                                $backoffice += $diff_total;
                                break;
                            case 8:
                                $inbound += $diff_total;
                                break;
                            case 9:
                                $outbound += $diff_total;
                                break;
                            case 11:
                                $login += $diff_total;
                                break;
                            case 12:
                                $ring_inbound += $diff_total;
                                break;
                            case 13:
                                $ring_outbound += $diff_total;
                                break;
                            case 15:
                                $desconectado += $diff_total;
                                break;
                            case 16:
                                $hold_inbound += $diff_total;
                                break;
                            case 17:
                                $hold_outbound += $diff_total;
                                break;
                            case 18:
                                $ring_inbound_interno += $diff_total;
                                break;
                            case 19:
                                $inbound_interno += $diff_total;
                                break;
                            case 20:
                                $outbound_interno += $diff_total;
                                break;
                            case 21:
                                $ring_outbound_interno += $diff_total;
                                break;
                            case 22:
                                $hold_inbound_interno += $diff_total;
                                break;
                            case 23:
                                $hold_outbound_interno += $diff_total;
                                break;
                            case 24:
                                $ring_inbound_transfer += $diff_total;
                                break;
                            case 25:
                                $inbound_transfer += $diff_total;
                                break;
                            case 26:
                                $hold_inbound_transfer += $diff_total;
                                break;
                            case 27:
                                $ring_outbound_transfer += $diff_total;
                                break;
                            case 28:
                                $hold_outbound_transfer += $diff_total;
                                break;
                            case 29:
                                $outbound_transfer += $diff_total;
                                break;
                        }
                    } else {
                        switch ($vv->evento_id) {
                            case 1:
                                $acd = $diff_total;
                                break;
                            case 2:
                                $break = $diff_total;
                                break;
                            case 3:
                                $sshh = $diff_total;
                                break;
                            case 4:
                                $refrigerio = $diff_total;
                                break;
                            case 5:
                                $feedback = $diff_total;
                                break;
                            case 6:
                                $capacitacion = $diff_total;
                                break;
                            case 7:
                                $backoffice = $diff_total;
                                break;
                            case 8:
                                $inbound = $diff_total;
                                break;
                            case 9:
                                $outbound = $diff_total;
                                break;
                            case 11:
                                $login = $diff_total;
                                break;
                            case 12:
                                $ring_inbound = $diff_total;
                                break;
                            case 13:
                                $ring_outbound = $diff_total;
                                break;
                            case 15:
                                $desconectado = $diff_total;
                                break;
                            case 16:
                                $hold_inbound = $diff_total;
                                break;
                            case 17:
                                $hold_outbound = $diff_total;
                                break;
                            case 18:
                                $ring_inbound_interno = $diff_total;
                                break;
                            case 19:
                                $inbound_interno = $diff_total;
                                break;
                            case 20:
                                $outbound_interno = $diff_total;
                                break;
                            case 21:
                                $ring_outbound_interno = $diff_total;
                                break;
                            case 22:
                                $hold_inbound_interno = $diff_total;
                                break;
                            case 23:
                                $hold_outbound_interno = $diff_total;
                                break;
                            case 24:
                                $ring_inbound_transfer = $diff_total;
                                break;
                            case 25:
                                $inbound_transfer = $diff_total;
                                break;
                            case 26:
                                $hold_inbound_transfer = $diff_total;
                                break;
                            case 27:
                                $ring_outbound_transfer = $diff_total;
                                break;
                            case 28:
                                $hold_outbound_transfer = $diff_total;
                                break;
                            case 29:
                                $outbound_transfer = $diff_total;
                                break;
                        }
                    }
                    //Calcular total, no sumar los ultimos registros para estabilizar los 30 min
                    if ($kk != $index_final) {
                        $total += $diff_total;
                    }
                    //##

                }//Fin ciclo $query
                //Calcular diferencias temporales
                //Si tiene temporal inicial Ej: [00:00:00 - 00:30:00] -> 00:10:00 = 10 min
                if ($temp_diff_ini > 0) {
                    $total = $total + $temp_diff_ini;
                }
                //Si tiene temporal fin Ej: [00:00:00 - 00:30:00] -> 00:25:00 = 5 min
                if ($temp_diff_fin > 0) {
                    $total = $total + $temp_diff_fin;
                }
                //Acondicionar los resultados de diferencia por estado
                if ($set) {
                    if ($last_data != null) {
                        if ($hours[$i] . " - " . $hours[$j] == $last_data["range"]) {
                            switch ($last_data["data"]->evento_id) {
                                case 1:
                                    $acd += $temp_diff_fin;
                                    break;
                                case 2:
                                    $break += $temp_diff_fin;
                                    break;
                                case 3:
                                    $sshh += $temp_diff_fin;
                                    break;
                                case 4:
                                    $refrigerio += $temp_diff_fin;
                                    break;
                                case 5:
                                    $feedback += $temp_diff_fin;
                                    break;
                                case 6:
                                    $capacitacion += $temp_diff_fin;
                                    break;
                                case 7:
                                    $backoffice += $temp_diff_fin;
                                    break;
                                case 8:
                                    $inbound += $temp_diff_fin;
                                    break;
                                case 9:
                                    $outbound += $temp_diff_fin;
                                    break;
                                case 11:
                                    $login += $temp_diff_fin;
                                    break;
                                case 12:
                                    $ring_inbound += $temp_diff_fin;
                                    break;
                                case 13:
                                    $ring_outbound += $temp_diff_fin;
                                    break;
                                case 15:
                                    $desconectado += $temp_diff_fin;
                                    break;
                                case 16:
                                    $hold_inbound += $temp_diff_fin;
                                    break;
                                case 17:
                                    $hold_outbound += $temp_diff_fin;
                                    break;
                                case 18:
                                    $ring_inbound_interno += $temp_diff_fin;
                                    break;
                                case 19:
                                    $inbound_interno += $temp_diff_fin;
                                    break;
                                case 20:
                                    $outbound_interno += $temp_diff_fin;
                                    break;
                                case 21:
                                    $ring_outbound_interno += $temp_diff_fin;
                                    break;
                                case 22:
                                    $hold_inbound_interno += $temp_diff_fin;
                                    break;
                                case 23:
                                    $hold_outbound_interno += $temp_diff_fin;
                                    break;
                                case 24:
                                    $ring_inbound_transfer += $temp_diff_fin;
                                    break;
                                case 25:
                                    $inbound_transfer += $temp_diff_fin;
                                    break;
                                case 26:
                                    $hold_inbound_transfer += $temp_diff_fin;
                                    break;
                                case 27:
                                    $ring_outbound_transfer += $temp_diff_fin;
                                    break;
                                case 28:
                                    $hold_outbound_transfer += $temp_diff_fin;
                                    break;
                                case 29:
                                    $outbound_transfer += $temp_diff_fin;
                                    break;
                            }
                        }
                    }
                }
            } else {
                $login = 0;
                $acd = 0;
                $break = 0;
                $sshh = 0;
                $refrigerio = 0;
                $feedback = 0;
                $capacitacion = 0;
                $backoffice = 0;
                $inbound = 0;
                $outbound = 0;
                $ring_inbound = 0;
                $ring_outbound = 0;
                $hold_inbound = 0;
                $hold_outbound = 0;
                $ring_inbound_interno = 0;
                $inbound_interno = 0;
                $outbound_interno = 0;
                $ring_outbound_interno = 0;
                $hold_inbound_interno = 0;
                $hold_outbound_interno = 0;
                $ring_inbound_transfer = 0;
                $ring_outbound_transfer = 0;
                $inbound_transfer = 0;
                $hold_inbound_transfer = 0;
                $hold_outbound_transfer = 0;
                $outbound_transfer = 0;
                $desconectado = 0;
                $total = 0;
                $temp_diff_ini = 0;
                $temp_diff_fin = 0;
            }
            //Set por rango de hora y estado
            if (isset($hours[$j])) {
                $data[$hours[$i] . " - " . $hours[$j]]["acd"] = $acd;
                $data[$hours[$i] . " - " . $hours[$j]]["break"] = $break;
                $data[$hours[$i] . " - " . $hours[$j]]["sshh"] = $sshh;
                $data[$hours[$i] . " - " . $hours[$j]]["refrigerio"] = $refrigerio;
                $data[$hours[$i] . " - " . $hours[$j]]["feedback"] = $feedback;
                $data[$hours[$i] . " - " . $hours[$j]]["capacitacion"] = $capacitacion;
                $data[$hours[$i] . " - " . $hours[$j]]["backoffice"] = $backoffice;
                $data[$hours[$i] . " - " . $hours[$j]]["inbound"] = $inbound;
                $data[$hours[$i] . " - " . $hours[$j]]["outbound"] = $outbound;
                $data[$hours[$i] . " - " . $hours[$j]]["login"] = $login;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_inbound"] = $ring_inbound;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_outbound"] = $ring_outbound;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_inbound"] = $hold_inbound;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_outbound"] = $hold_outbound;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_inbound_interno"] = $ring_inbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["inbound_interno"] = $inbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["outbound_interno"] = $outbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_outbound_interno"] = $ring_outbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_inbound_interno"] = $hold_inbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_outbound_interno"] = $hold_outbound_interno;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_inbound_transfer"] = $ring_inbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["inbound_transfer"] = $inbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_inbound_transfer"] = $hold_inbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["ring_outbound_transfer"] = $ring_outbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["hold_outbound_transfer"] = $hold_outbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["outbound_transfer"] = $outbound_transfer;
                $data[$hours[$i] . " - " . $hours[$j]]["desconectado"] = $desconectado;

                $data[$hours[$i] . " - " . $hours[$j]]["total"] = $total;
                $data[$hours[$i] . " - " . $hours[$j]]["diff_inicial"] = $temp_diff_ini;
                $data[$hours[$i] . " - " . $hours[$j]]["diff_final"] = $temp_diff_fin;
            } else {
                $data[$hours[$i] . " - " . $hours[0]]["acd"] = $acd;
                $data[$hours[$i] . " - " . $hours[0]]["break"] = $break;
                $data[$hours[$i] . " - " . $hours[0]]["sshh"] = $sshh;
                $data[$hours[$i] . " - " . $hours[0]]["refrigerio"] = $refrigerio;
                $data[$hours[$i] . " - " . $hours[0]]["feedback"] = $feedback;
                $data[$hours[$i] . " - " . $hours[0]]["capacitacion"] = $capacitacion;
                $data[$hours[$i] . " - " . $hours[0]]["backoffice"] = $backoffice;
                $data[$hours[$i] . " - " . $hours[0]]["inbound"] = $inbound;
                $data[$hours[$i] . " - " . $hours[0]]["outbound"] = $outbound;
                $data[$hours[$i] . " - " . $hours[0]]["login"] = $login;
                $data[$hours[$i] . " - " . $hours[0]]["ring_inbound"] = $ring_inbound;
                $data[$hours[$i] . " - " . $hours[0]]["ring_outbound"] = $ring_outbound;
                $data[$hours[$i] . " - " . $hours[0]]["hold_inbound"] = $hold_inbound;
                $data[$hours[$i] . " - " . $hours[0]]["hold_outbound"] = $hold_outbound;
                $data[$hours[$i] . " - " . $hours[0]]["ring_inbound_interno"] = $ring_inbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["inbound_interno"] = $inbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["outbound_interno"] = $outbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["ring_outbound_interno"] = $ring_outbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["hold_inbound_interno"] = $hold_inbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["hold_outbound_interno"] = $hold_outbound_interno;
                $data[$hours[$i] . " - " . $hours[0]]["ring_inbound_transfer"] = $ring_inbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["inbound_transfer"] = $inbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["hold_inbound_transfer"] = $hold_inbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["ring_outbound_transfer"] = $ring_outbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["hold_outbound_transfer"] = $hold_outbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["outbound_transfer"] = $outbound_transfer;
                $data[$hours[$i] . " - " . $hours[0]]["desconectado"] = $desconectado;

                $data[$hours[$i] . " - " . $hours[0]]["total"] = $total;
                $data[$hours[$i] . " - " . $hours[0]]["diff_inicial"] = $temp_diff_ini;
                $data[$hours[$i] . " - " . $hours[0]]["diff_final"] = $temp_diff_fin;
            }
        }

        return $data;

    }

    public function getDiffDatetime($datetime_ini, $datetime_fin, $onlyTime = false)
    {
        if ($onlyTime) {
            $first = Carbon::parse(Carbon::parse($datetime_ini)->format("H:i:s"));
            $second = Carbon::parse(Carbon::parse($datetime_fin)->format("H:i:s"));
            return $first->diffInSeconds($second);// 10 min
        } else {
            $first = Carbon::parse($datetime_ini);
            $second = Carbon::parse($datetime_ini);
            return $first->diffInSeconds($second);// 10 min
        }
    }

    public function export_level_events_report(Request $request)
    {
        return call_user_func_array([$this, 'export_level_events_report_' . $request->format_export], [$request]);
    }

    protected function builderview($data, $type = '')
    {
        $posicion = 0;
        $builderview = [];

        foreach ($data as $key => $value) {
            $value = (object)$value;


            $totalACD = $value->inbound + $value->hold_inbound;
            $totalOutbound = $value->outbound + $value->ring_outbound + $value->hold_outbound;
            $totalBackoffice = $value->backoffice
                + $value->inbound_interno
                + $value->ring_inbound_interno
                + $value->hold_inbound_interno
                + $value->outbound_interno
                + $value->ring_outbound_interno
                + $value->hold_outbound_interno;
            $totalAuxiliares = $value->break + $value->sshh + $value->refrigerio + $value->feedback + $value->capacitacion;
            $totalAuxiliaresBack = $totalAuxiliares + $totalBackoffice;
            $totalSuma = $value->acd
                + $value->break
                + $value->sshh
                + $value->refrigerio
                + $value->feedback
                + $value->capacitacion
                + $value->backoffice
                + $value->inbound
                + $value->outbound
                + $value->ring_inbound
                + $value->ring_outbound
                + $value->hold_inbound
                + $value->hold_outbound
                + $value->ring_inbound_interno
                + $value->inbound_interno
                + $value->outbound_interno
                + $value->ring_outbound_interno
                + $value->hold_inbound_interno
                + $value->hold_outbound_interno
                + $value->ring_inbound_transfer
                + $value->inbound_transfer
                + $value->hold_inbound_transfer
                + $value->ring_outbound_transfer
                + $value->hold_outbound_transfer
                + $value->outbound_transfer
                + $value->desconectado;
            $tiempoLogeo = $totalSuma - $value->desconectado;

            $n1 = ($totalACD + $totalOutbound);
            $n2 = ($tiempoLogeo - $totalAuxiliaresBack);
            if ($n1 > 0 && $n2 > 0) {
                $totalOcupacion = (float)(($totalACD + $totalOutbound) / ($tiempoLogeo - $totalAuxiliaresBack));
            } else {
                $totalOcupacion = 0;
            }
            $n3 = ($totalACD + $totalOutbound + $totalBackoffice);
            $n4 = ($tiempoLogeo - $totalAuxiliares);
            if ($n3 > 0 && $n4 > 0) {
                $totalOcupacionBack = (float)(($totalACD + $totalOutbound + $totalBackoffice) / ($tiempoLogeo - $totalAuxiliares));
            } else {
                $totalOcupacionBack = 0;
            }

            $builderview[$posicion]['User'] = (string)$key;
            $builderview[$posicion]['Rango'] = (string)$key;
            $builderview[$posicion]['Tiempo Diff Inicial'] = (string)$value->diff_inicial;
            $builderview[$posicion]['Disponible'] = (string)$value->acd;
            $builderview[$posicion]['Break'] = (string)$value->break;
            $builderview[$posicion]['SSHH'] = (string)$value->sshh;
            $builderview[$posicion]['Refrigerio'] = (string)$value->refrigerio;
            $builderview[$posicion]['Feedback'] = (string)$value->feedback;
            $builderview[$posicion]['Capacitacion'] = (string)$value->capacitacion;
            $builderview[$posicion]['Gestion BackOffice'] = (string)$value->backoffice;
            $builderview[$posicion]['Inbound'] = (string)$value->inbound;
            $builderview[$posicion]['OutBound'] = (string)$value->outbound;
            $builderview[$posicion]['Ring Inbound'] = (string)$value->ring_inbound;
            $builderview[$posicion]['Ring Outbound'] = (string)$value->ring_outbound;
            $builderview[$posicion]['Hold Inbound'] = (string)$value->hold_inbound;
            $builderview[$posicion]['Hold Outbound'] = (string)$value->hold_outbound;
            $builderview[$posicion]['Ring Inbound Interno'] = (string)$value->ring_inbound_interno;
            $builderview[$posicion]['Inbound Interno'] = (string)$value->inbound_interno;
            $builderview[$posicion]['Outbound Interno'] = (string)$value->outbound_interno;
            $builderview[$posicion]['Ring Outbound Interno'] = (string)$value->ring_outbound_interno;
            $builderview[$posicion]['Hold Inbound Interno'] = (string)$value->hold_inbound_interno;
            $builderview[$posicion]['Hold Outbound Interno'] = (string)$value->hold_outbound_interno;
            $builderview[$posicion]['Ring Inbound Transfer'] = (string)$value->ring_inbound_transfer;
            $builderview[$posicion]['Inbound Transfer'] = (string)$value->inbound_transfer;
            $builderview[$posicion]['Hold Inbound Transfer'] = (string)$value->hold_inbound_transfer;
            $builderview[$posicion]['Ring Outbound Transfer'] = (string)$value->ring_outbound_transfer;
            $builderview[$posicion]['Hold Outbound Transfer'] = (string)$value->hold_outbound_transfer;
            $builderview[$posicion]['Outbound Transfer'] = (string)$value->outbound_transfer;
            $builderview[$posicion]['Desconectado'] = (string)$value->desconectado;
            $builderview[$posicion]['Tiempo Diff Final'] = (string)$value->diff_final;
            $builderview[$posicion]['Total'] = (string)$value->total;
            $builderview[$posicion]['Nivel Ocupacion'] = (string)(number_format($totalOcupacion, 4) * 100) . ' %';
            $builderview[$posicion]['Nivel Ocupacion Backoffice'] = (string)(number_format($totalOcupacionBack, 4) * 100) . ' %';

            $posicion++;

        }

        if (!isset($builderview)) {
            $builderview = [];
        }

        return $builderview;
    }

    protected function builderview2($data, $type = '')
    {
        $posicion = 0;
        $builderview = [];
        foreach ($data as $k => $v) {
            foreach ($v as $kk => $vv) {
                foreach ($vv as $kkk => $vvv) {
                    $vvv = (object)$vvv;

                    $totalACD = $vvv->inbound + $vvv->hold_inbound;
                    $totalOutbound = $vvv->outbound + $vvv->ring_outbound + $vvv->hold_outbound;
                    $totalBackoffice = $vvv->backoffice
                        + $vvv->inbound_interno
                        + $vvv->ring_inbound_interno
                        + $vvv->hold_inbound_interno
                        + $vvv->outbound_interno
                        + $vvv->ring_outbound_interno
                        + $vvv->hold_outbound_interno;
                    $totalAuxiliares = $vvv->break + $vvv->sshh + $vvv->refrigerio + $vvv->feedback + $vvv->capacitacion;
                    $totalAuxiliaresBack = $totalAuxiliares + $totalBackoffice;
                    $totalSuma = $vvv->acd
                        + $vvv->break
                        + $vvv->sshh
                        + $vvv->refrigerio
                        + $vvv->feedback
                        + $vvv->capacitacion
                        + $vvv->backoffice
                        + $vvv->inbound
                        + $vvv->outbound
                        + $vvv->ring_inbound
                        + $vvv->ring_outbound
                        + $vvv->hold_inbound
                        + $vvv->hold_outbound
                        + $vvv->ring_inbound_interno
                        + $vvv->inbound_interno
                        + $vvv->outbound_interno
                        + $vvv->ring_outbound_interno
                        + $vvv->hold_inbound_interno
                        + $vvv->hold_outbound_interno
                        + $vvv->ring_inbound_transfer
                        + $vvv->inbound_transfer
                        + $vvv->hold_inbound_transfer
                        + $vvv->ring_outbound_transfer
                        + $vvv->hold_outbound_transfer
                        + $vvv->outbound_transfer
                        + $vvv->desconectado;
                    $tiempoLogeo = $totalSuma - $vvv->desconectado;

                    $n1 = ($totalACD + $totalOutbound);
                    $n2 = ($tiempoLogeo - $totalAuxiliaresBack);
                    if ($n1 > 0 && $n2 > 0) {
                        $totalOcupacion = (float)(($totalACD + $totalOutbound) / ($tiempoLogeo - $totalAuxiliaresBack));
                    } else {
                        $totalOcupacion = 0;
                    }
                    $n3 = ($totalACD + $totalOutbound + $totalBackoffice);
                    $n4 = ($tiempoLogeo - $totalAuxiliares);
                    if ($n3 > 0 && $n4 > 0) {
                        $totalOcupacionBack = (float)(($totalACD + $totalOutbound + $totalBackoffice) / ($tiempoLogeo - $totalAuxiliares));
                    } else {
                        $totalOcupacionBack = 0;
                    }


                    $builderview[$posicion]['User'] = (string)$kk;
                    $builderview[$posicion]['Rango'] = (string)$kkk;
                    $builderview[$posicion]['Tiempo Diff Inicial'] = (string)$vvv->diff_inicial;
                    $builderview[$posicion]['Disponible'] = (string)$vvv->acd;
                    $builderview[$posicion]['Break'] = (string)$vvv->break;
                    $builderview[$posicion]['SSHH'] = (string)$vvv->sshh;
                    $builderview[$posicion]['Refrigerio'] = (string)$vvv->refrigerio;
                    $builderview[$posicion]['Feedback'] = (string)$vvv->feedback;
                    $builderview[$posicion]['Capacitacion'] = (string)$vvv->capacitacion;
                    $builderview[$posicion]['Gestion BackOffice'] = (string)$vvv->backoffice;
                    $builderview[$posicion]['Inbound'] = (string)$vvv->inbound;
                    $builderview[$posicion]['OutBound'] = (string)$vvv->outbound;
                    $builderview[$posicion]['Ring Inbound'] = (string)$vvv->ring_inbound;
                    $builderview[$posicion]['Ring Outbound'] = (string)$vvv->ring_outbound;
                    $builderview[$posicion]['Hold Inbound'] = (string)$vvv->hold_inbound;
                    $builderview[$posicion]['Hold Outbound'] = (string)$vvv->hold_outbound;
                    $builderview[$posicion]['Ring Inbound Interno'] = (string)$vvv->ring_inbound_interno;
                    $builderview[$posicion]['Inbound Interno'] = (string)$vvv->inbound_interno;
                    $builderview[$posicion]['Outbound Interno'] = (string)$vvv->outbound_interno;
                    $builderview[$posicion]['Ring Outbound Interno'] = (string)$vvv->ring_outbound_interno;
                    $builderview[$posicion]['Hold Inbound Interno'] = (string)$vvv->hold_inbound_interno;
                    $builderview[$posicion]['Hold Outbound Interno'] = (string)$vvv->hold_outbound_interno;
                    $builderview[$posicion]['Ring Inbound Transfer'] = (string)$vvv->ring_inbound_transfer;
                    $builderview[$posicion]['Inbound Transfer'] = (string)$vvv->inbound_transfer;
                    $builderview[$posicion]['Hold Inbound Transfer'] = (string)$vvv->hold_inbound_transfer;
                    $builderview[$posicion]['Ring Outbound Transfer'] = (string)$vvv->ring_outbound_transfer;
                    $builderview[$posicion]['Hold Outbound Transfer'] = (string)$vvv->hold_outbound_transfer;
                    $builderview[$posicion]['Outbound Transfer'] = (string)$vvv->outbound_transfer;
                    $builderview[$posicion]['Desconectado'] = (string)$vvv->desconectado;
                    $builderview[$posicion]['Tiempo Diff Final'] = (string)$vvv->diff_final;
                    $builderview[$posicion]['Total'] = (string)$vvv->total;
                    $builderview[$posicion]['Nivel Ocupacion'] = (string)(number_format($totalOcupacion, 4) * 100) . ' %';
                    $builderview[$posicion]['Nivel Ocupacion Backoffice'] = (string)(number_format($totalOcupacionBack, 4) * 100) . ' %';
                    $posicion++;
                }
            }
        }

        if (!isset($builderview)) {
            $builderview = [];
        }

        return $builderview;
    }

    protected function outgoingcollection($builderview)
    {
        $data = new Collector();
        foreach ($builderview as $view) {
            $data->push([
                'User' => $view['User'],
                'Rango' => $view['Rango'],
                'Tiempo Diff Inicial' => $view['Tiempo Diff Inicial'],
                'Disponible' => $view['Disponible'],
                'Break' => $view['Break'],
                'SSHH' => $view['SSHH'],
                'Refrigerio' => $view['Refrigerio'],
                'Feedback' => $view['Feedback'],
                'Capacitacion' => $view['Capacitacion'],
                'Gestion BackOffice' => $view['Gestion BackOffice'],
                'Inbound' => $view['Inbound'],
                'OutBound' => $view['OutBound'],
                'Ring Inbound' => $view['Ring Inbound'],
                'Ring Outbound' => $view['Ring Outbound'],
                'Hold Inbound' => $view['Hold Inbound'],
                'Hold Outbound' => $view['Hold Outbound'],
                'Ring Inbound Interno' => $view['Ring Inbound Interno'],
                'Inbound Interno' => $view['Inbound Interno'],
                'Outbound Interno' => $view['Outbound Interno'],
                'Ring Outbound Interno' => $view['Ring Outbound Interno'],
                'Hold Inbound Interno' => $view['Hold Inbound Interno'],
                'Hold Outbound Interno' => $view['Hold Outbound Interno'],
                'Ring Inbound Transfer' => $view['Ring Inbound Transfer'],
                'Inbound Transfer' => $view['Inbound Transfer'],
                'Hold Inbound Transfer' => $view['Hold Inbound Transfer'],
                'Ring Outbound Transfer' => $view['Ring Outbound Transfer'],
                'Hold Outbound Transfer' => $view['Hold Outbound Transfer'],
                'Outbound Transfer' => $view['Outbound Transfer'],
                'Desconectado' => $view['Desconectado'],
                'Tiempo Diff Final' => $view['Tiempo Diff Final'],
                'Total' => $view['Total'],
                'Nivel Ocupacion' => '<b>' . $view['Nivel Ocupacion'] . '</b>',
                'Nivel Ocupacion Backoffice' => '<b>' . $view['Nivel Ocupacion Backoffice'] . '</b>'
            ]);

        }
        return $data;
    }

    protected function outgoingcollection2($builderview)
    {
        $data = new Collector();
        foreach ($builderview as $view) {
            $data->push([
                'User' => $view['User'],
                'Rango' => $view['Rango'],
                'Tiempo Diff Inicial' => $view['Tiempo Diff Inicial'],
                'Disponible' => $view['Disponible'],
                'Break' => $view['Break'],
                'SSHH' => $view['SSHH'],
                'Refrigerio' => $view['Refrigerio'],
                'Feedback' => $view['Feedback'],
                'Capacitacion' => $view['Capacitacion'],
                'Gestion BackOffice' => $view['Gestion BackOffice'],
                'Inbound' => $view['Inbound'],
                'OutBound' => $view['OutBound'],
                'Ring Inbound' => $view['Ring Inbound'],
                'Ring Outbound' => $view['Ring Outbound'],
                'Hold Inbound' => $view['Hold Inbound'],
                'Hold Outbound' => $view['Hold Outbound'],
                'Ring Inbound Interno' => $view['Ring Inbound Interno'],
                'Inbound Interno' => $view['Inbound Interno'],
                'Outbound Interno' => $view['Outbound Interno'],
                'Ring Outbound Interno' => $view['Ring Outbound Interno'],
                'Hold Inbound Interno' => $view['Hold Inbound Interno'],
                'Hold Outbound Interno' => $view['Hold Outbound Interno'],
                'Ring Inbound Transfer' => $view['Ring Inbound Transfer'],
                'Inbound Transfer' => $view['Inbound Transfer'],
                'Hold Inbound Transfer' => $view['Hold Inbound Transfer'],
                'Ring Outbound Transfer' => $view['Ring Outbound Transfer'],
                'Hold Outbound Transfer' => $view['Hold Outbound Transfer'],
                'Outbound Transfer' => $view['Outbound Transfer'],
                'Desconectado' => $view['Desconectado'],
                'Tiempo Diff Final' => $view['Tiempo Diff Final'],
                'Total' => $view['Total'],
                'Nivel Ocupacion' => '<b>' . $view['Nivel Ocupacion'] . '</b>',
                'Nivel Ocupacion Backoffice' => '<b>' . $view['Nivel Ocupacion Backoffice'] . '</b>'
            ]);

        }
        return $data;
    }

    protected function export_level_events_report_csv($request)
    {
        $filename = 'csv_' . time();
//        if ($request->group_filter == "groupAgent") {
        $builderview = $this->builderview2($this->byUserAll($request), 'export');
        $this->BuilderExport($builderview, $filename, 'csv', 'exports');
        $data = [
            'succes' => true,
            'path' => ['http://' . $_SERVER['HTTP_HOST'] . '/exports/' . $filename . '.csv']
        ];
        return $data;
//        }
//        else {
//            $builderview = $this->builderview($this->byUser(null, $request), 'export');
//        }

    }

    protected function export_level_events_report_excel($request)
    {
        $filename = 'exc_' . time();
//        if ($request->group_filter == "groupAgent") {
        $builderview = $this->builderview2($this->byUserAll($request), 'export');
        $this->BuilderExport($builderview, $filename, 'xlsx', 'exports');
        $data = [
            'succes' => true,
            'path' => ['http://' . $_SERVER['HTTP_HOST'] . '/exports/' . $filename . '.xlsx']
        ];
        return $data;
//        }
//        else {
//            $builderview = $this->builderview($this->byUser(null, $request), 'export');
//        }

    }

    //Entel-Dashboard - aquispe.developer@gmail.com
    function abandonadasPorHora(Request $request)
    {
        $hours = [
            "00:00 - 01:00",
            "01:00 - 02:00",
            "02:00 - 03:00",
            "03:00 - 04:00",
            "04:00 - 05:00",
            "05:00 - 06:00",
            "06:00 - 07:00",
            "07:00 - 08:00",
            "08:00 - 09:00",
            "09:00 - 10:00",
            "10:00 - 11:00",
            "11:00 - 12:00",
            "12:00 - 13:00",
            "13:00 - 14:00",
            "14:00 - 15:00",
            "15:00 - 16:00",
            "16:00 - 17:00",
            "17:00 - 18:00",
            "18:00 - 19:00",
            "19:00 - 20:00",
            "20:00 - 21:00",
            "21:00 - 22:00",
            "22:00 - 23:00",
            "23:00 - 00:00",
        ];
        $data = [];
        $sql = DB::select("SELECT HOUR(DATETIME) as 'hour',COUNT(1) AS 'cantidad' FROM queue_stats_mv 
                            WHERE DATE(DATETIME) = '".$request->pfecha."'
                            AND EVENT ='ABANDON'
                            GROUP BY HOUR(DATETIME);");

        foreach ($hours as $k => $v) {
            //Validacion si ya cargo $data
            if (count($data)) {
                if (isset($data[$k])) {
                    if ($hours[$k - 1] == array_divide($data[$k])[0][0]) {
                        array_splice($data, $k, 1);
                    }
                }
            }
            //Cargamos $data
            array_push($data, [$hours[$k] => 0]);
            //Cliclo $sql
            foreach ($sql as $kk => $vv) {
                if ($k + 1 == $vv->hour) {
                    array_push($data,[$hours[$k + 1] => $vv->cantidad]);
                } else {
                    continue;
                }
            }
        }
            return $data;
    }
    function abandonadasDiez(Request $request)
    {
        $hours = [
            "00:00 - 01:00",
            "01:00 - 02:00",
            "02:00 - 03:00",
            "03:00 - 04:00",
            "04:00 - 05:00",
            "05:00 - 06:00",
            "06:00 - 07:00",
            "07:00 - 08:00",
            "08:00 - 09:00",
            "09:00 - 10:00",
            "10:00 - 11:00",
            "11:00 - 12:00",
            "12:00 - 13:00",
            "13:00 - 14:00",
            "14:00 - 15:00",
            "15:00 - 16:00",
            "16:00 - 17:00",
            "17:00 - 18:00",
            "18:00 - 19:00",
            "19:00 - 20:00",
            "20:00 - 21:00",
            "21:00 - 22:00",
            "22:00 - 23:00",
            "23:00 - 00:00",
        ];
        $data = [];
        $sql = DB::select("SELECT HOUR(DATETIME) AS 'hour', COUNT(1) AS 'cantidad' FROM queue_stats_mv 
                                WHERE DATE(DATETIME) = '".$request->pfecha."'
                                AND TIME_TO_SEC(info1) <='10'
                                AND EVENT ='ABANDON'
                                GROUP BY HOUR(DATETIME);");
        foreach ($hours as $k => $v) {
            //Validacion si ya cargo $data
            if (count($data)) {
                if (isset($data[$k])) {
                    if ($hours[$k - 1] == array_divide($data[$k])[0][0]) {
                        array_splice($data, $k, 1);
                    }
                }
            }
            //Cargamos $data
            array_push($data, [$hours[$k] => 0]);
            //Cliclo $sql
            foreach ($sql as $kk => $vv) {
                if ($k + 1 == $vv->hour) {
                    array_push($data,[$hours[$k + 1] => $vv->cantidad]);
                } else {
                    continue;
                }
            }
        }
            return $data;
    }
    function abandonadasDiff(Request $request)
    {
        $hours = [
            "00:00 - 01:00",
            "01:00 - 02:00",
            "02:00 - 03:00",
            "03:00 - 04:00",
            "04:00 - 05:00",
            "05:00 - 06:00",
            "06:00 - 07:00",
            "07:00 - 08:00",
            "08:00 - 09:00",
            "09:00 - 10:00",
            "10:00 - 11:00",
            "11:00 - 12:00",
            "12:00 - 13:00",
            "13:00 - 14:00",
            "14:00 - 15:00",
            "15:00 - 16:00",
            "16:00 - 17:00",
            "17:00 - 18:00",
            "18:00 - 19:00",
            "19:00 - 20:00",
            "20:00 - 21:00",
            "21:00 - 22:00",
            "22:00 - 23:00",
            "23:00 - 00:00",
        ];
        $data=[];
        $abandonadasPorHora = $this->abandonadasPorHora($request);
        $abandonadasDiez = $this->abandonadasDiez($request);
        //Cliclo $sql
        foreach ($hours as $k => $v) {
            $res = 0;
            if(isset($abandonadasPorHora[$k]) && isset($abandonadasDiez[$k])){
            $n1 = (int)implode($abandonadasPorHora[$k]);
            $n2 = (int)implode($abandonadasDiez[$k]);
                if($n1 != $n2){
                    $res = $n1 - $n2;
                }
            }
            array_push($data, [$hours[$k] => $res]);
        }
        return $data;
    }
    function dashboard_04()
    {
        return view("dashboard.dashboard_04");
    }

}
