<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class AgentesOnline extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'agentes_online';
    protected $primaryKey   = 'id';

    public function scopeSelect_fechamod($query)
    {
        return $query->Select(DB::raw(" CONVERT(varchar,fecha_evento,103) AS date_agent, CONVERT(varchar(5),fecha_evento,108) AS hour_agent, COUNT(*) AS quantity " ));
    }

    public function scopeFiltro_days($query,$days)
    {

        if( ! empty($days))
        {
            return    $query->whereBetween(DB::raw(" CONVERT(varchar(10),fecha_evento,120)"),$days);
        }

    }
}
