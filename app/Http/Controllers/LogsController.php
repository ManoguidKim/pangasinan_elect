<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;

class LogsController extends Controller
{

    public function index()
    {
        return view('logs.index');
    }

    public function adminLog()
    {
        return view('systemadmin.log.activity.index');
    }

    public function showAdminLog(Municipality $municipality)
    {
        return view(
            'systemadmin.log.activity.show',
            [
                'municipalId' => $municipality->id,
                'municipalityName' => $municipality->name
            ]
        );
    }
}
