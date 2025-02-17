<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DahsboardMasterController extends Controller
{
    public function index()
    {
        $users = User::count();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $presensiBulanIni = Presence::whereMonth('pulang', $currentMonth)
            ->whereYear('pulang', $currentYear)
            ->get();

        $jumlahPresensiBulanIni = Presence::whereMonth('pulang', $currentMonth)
            ->whereYear('pulang', $currentYear)
            ->count();

        return view('master.dashboard.index', compact('users', 'presensiBulanIni', 'jumlahPresensiBulanIni'));
    }
}
