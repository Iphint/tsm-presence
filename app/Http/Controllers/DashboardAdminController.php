<?php

namespace App\Http\Controllers;

use App\Models\Outlets;
use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $outletCabang = $user->outlet_cabang;
        $users = User::where('outlet_cabang', $user->outlet_cabang)->count();
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth();
        $endOfMonth = $now->endOfMonth();

        if ($user->outlet) {
            $namaOutlet = $user->outlet->nama_outlet;
        } else {
            $namaOutlet = 'Data outlet tidak tersedia';
        }

        $presences = Presence::where('user_id', $user->id)
            ->whereMonth('datang', $now->month)
            ->whereYear('datang', $now->year)
            ->get();

        $totalKehadiran = $presences->count();

        return view('admin.dashboard.index', compact('namaOutlet', 'outletCabang', 'users','totalKehadiran'));
    }
}
