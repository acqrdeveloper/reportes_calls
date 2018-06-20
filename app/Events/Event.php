<?php

namespace Cosapi\Events;

use Cosapi\Http\Controllers\CosapiController;
use Illuminate\Support\Facades\Auth;

abstract class Event extends  CosapiController
{
    public  function obtener_userid(){
        return Auth::user()->id;
    }

    public  function obtener_userRole(){
        return Auth::user()->role;
    }
}
