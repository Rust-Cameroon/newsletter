<?php

namespace App\Http\Controllers;

use App\Models\SetTune;

class AppController extends Controller
{
    public function notificationTune()
    {
        $tune = SetTune::where('status', 1)->first();

        return asset($tune->tune);
    }
}
