<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $workedDays = Presence::where('user_id', $user->id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();

        $dailySalary = 50000;
        $salary = $workedDays * $dailySalary;

        $gaji = Gaji::where('user_id', $user->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->first();

        if (!$gaji) {
            $gaji = new Gaji();
            $gaji->user_id = $user->id;
            $gaji->gaji = $salary;
            $gaji->tanggal = Carbon::now()->toDateString();
            $gaji->save();
        }

        return view('', compact('gaji', 'workedDays'));
    }
    public function show()
    {
        return view('pages.gaji.print');
    }
}
