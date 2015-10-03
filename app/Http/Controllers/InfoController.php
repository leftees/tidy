<?php

namespace Tidy\Http\Controllers;

use Illuminate\Http\Request;
use Tidy\Http\Requests;
use Tidy\Http\Controllers\Controller;

class InfoController extends Controller
{

    public function serverTime()
    {
        return response()->json(['time' => date('c')]);
    }

}
