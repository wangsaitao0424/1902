<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function event()
    {
        echo 1111;
        echo $_GET['echostr'];
    }
}
