<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardMagangController extends Controller
{
    public function index(){
        return view('magang.dashboard.index');
    }
}
