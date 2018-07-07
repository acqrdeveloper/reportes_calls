<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleEventos extends Model
{
    protected $connection   = 'laravel';
    protected $table 		    = 'detalle_eventos';


    public function evento(){
        return $this->belongsTo('Cosapi\Models\Eventos');
    }

    public function user(){
        return $this->belongsTo('Cosapi\Models\User');
    }

    public function scopeFiltro_days($query,$days)
    {

        if( ! empty($days))
        {
            return    $query->whereBetween(DB::raw("CONVERT(varchar(10),fecha_evento,120)"),$days);
        }

    }

    public function scopeSelect_fechamod($query)
    {
        return $query->Select(DB::raw("*,CONVERT(varchar(10),fecha_evento,120) as fechamod, CONVERT(varchar,fecha_evento,108) AS timemod,
        CONVERT(varchar(5), DATEADD(minute, (DATEPART(n, fecha_evento) %30) * -1, getdate()), 108) AS hourmod " ));
    }

    public function scopeFiltro_user_rol($query,$rol,$users)
    {

        if( $rol == 'user' || $rol == 'backoffice')
        {
            return    $query->where('user_id','=',$users);
        }

    }
}
