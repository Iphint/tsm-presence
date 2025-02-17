<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPegawaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth();
        $endOfMonth = $now->endOfMonth();

        $presences = Presence::where('user_id', $user->id)
            ->whereMonth('datang', $now->month)
            ->whereYear('datang', $now->year)
            ->get();

        $totalKehadiran = $presences->count();

        return view('pegawai.dashboard.index', compact('totalKehadiran'));
    }
}
