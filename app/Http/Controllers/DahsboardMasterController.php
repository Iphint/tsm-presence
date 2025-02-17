<?php

namespace App\Http\Controllers;

use App\Models\Outlets;
use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;

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

        $totalOutlet = Outlets::count();

        return view('master.dashboard.index', compact('users', 'presensiBulanIni', 'jumlahPresensiBulanIni', 'totalOutlet'));
    }
}
