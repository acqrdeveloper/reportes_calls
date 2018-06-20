<?php

namespace Cosapi\Listeners;

use Cosapi\Events\LoginUsers;
use Cosapi\Models\AgentOnline;
use Cosapi\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

class LastLogin
{

    private $auth;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  LoginUsers  $event
     * @return void
     */
    public function handle(LoginUsers $event)
    {
        $event->register_event('11', $event->obtener_userid(), $event->obtener_userRole(),'','','',null);
    }
}