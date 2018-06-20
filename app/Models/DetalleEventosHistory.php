<?php

namespace Cosapi\Models;

use Cosapi\Models\DetalleEventos;

class DetalleEventosHistory extends DetalleEventos
{
    protected $connection   = 'laravel';
    protected $table 		    = 'detalle_eventos_history';


    public function scopeFiltro_user_rol($query,$rol,$users)
    {

        if( $rol == 'user' || $rol == 'backoffice')
        {
            return    $query->where('user_id','=',$users);
        }

    }
}
