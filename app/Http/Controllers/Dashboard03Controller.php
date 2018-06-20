<?php

namespace Cosapi\Http\Controllers;

use Illuminate\Http\Request;

use Cosapi\Http\Requests;
use Cosapi\Http\Controllers\Controller;

class Dashboard03Controller extends CosapiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('elements/dashboard03/dashboard03');
    }

}
