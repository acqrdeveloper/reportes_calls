<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Queue_Log extends Model
{
  protected $connection = 'laravel';
  protected $table = 'queue_stats_mv';
  protected $primaryKey = 'id';


  public function scopeFiltro_id_cdr($query, $value)
  {
    if (!empty($value)) {
      return $query->wherein('id_cdr', $value);
    }
  }

  public function scopeFiltro_events($query, $events)
  {

    if (!empty($events)) {
      return $query->whereIn('event', $events);
    }

  }

  public function scopeFiltro_days($query, $days)
  {

    if (!empty($days)) {
      return $query->whereBetween(DB::raw("CONVERT(varchar(10),datetime,120)"), $days);
    }

  }


  public function scopeSelect_fechamod($query, $rank_hour = 30)
  {
    return $query->Select(DB::raw("*,CONVERT(varchar(10),datetime,120) as fechamod, CONVERT(varchar,datetime,108) AS timemod,
        CONVERT(varchar(5),DATEADD(minute, (DATEPART(n,datetime)%$rank_hour) * -1 , datetime), 108) AS hourmod, 
        CONVERT(varchar(5), DATEADD(minute, (DATEPART (n, DATEADD(SECOND, + Cast(info2 as INT) , datetime) ) %$rank_hour) * -1, DATEADD(SECOND, + Cast(info2 as INT) , datetime)	) , 108) AS hour_final "));
  }


  public function scopeFiltro_hours($query, $hours)
  {

    if ($hours != '') {
      return $query->where(DB::raw("CONVERT(varchar(5), DATEADD(minute, DATEPART(n,DATETIME)%30 * -1, DATETIME), 108))"), 'like', $hours);
    }

  }


  public function scopeFiltro_user_rol($query, $rol, $user_name)
  {

    if ($rol == 'user' || $rol == 'backoffice') {
      return $query->where('agent', '=', 'Agent/' . $user_name);
    }

  }

  public function scopeFiltro_Time($query, $metrica)
  {
    if ($metrica['action'] == 'true') {
      return $query->where(DB::raw('CAST(info1 AS INTEGER)'), $metrica["symbol"], $metrica["time"]);
    }
  }

  public function scopeFiltro_tabla($query)
  {
    $module_list = '';
    $filters = Filter::select()->with('column', 'condition')->where('estado_id', '1')->get()->toArray();
    $modules = Module::select()->get()->toArray();

    foreach ($modules as $module) {
      $module_list[$module['id']] = $module['name'];
    }

    foreach ($filters as $key => $filter) {
      if ($module_list[$filter['column']['module_id']] == 'Queue_Log') {

        //Funcion que se le aplica a la columna de la tabla
        $column = ($filter['column']['apply'] != null) ? $filter['column']['apply'] . '(' . $filter['column']['name'] . ')' : $filter['column']['name'];

        //Funcion que aplica el usuario a la columna de la tabla
        $column = ($filter['apply'] != null) ? $filter['apply'] . '(' . $column . ')' : $column;

        $query = $query->where(DB::raw($column), $filter['condition']['name'], $filter['value']);
      }
    }

    return $query;
  }

  function scopeFiltro_usernameSearch($query, $username)
  {
    if ($username != '') {
      return $query->where('agent', '=', 'Agent/' . $username);
    }
  }
}
