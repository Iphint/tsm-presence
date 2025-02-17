<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Jabatan;
use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresencePegawaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $presences = Presence::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->get();
        return view('pegawai.presensi.index', compact('presences'));
    }
    public function create()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $presence = Presence::where('user_id', $user->id)
            ->whereDate('datang', $today)
            ->first();

        return view('pegawai.presensi.create', compact('presence'));
    }
    public function markArrival(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $existingPresence = Presence::where('user_id', Auth::id())
            ->whereDate('datang', $today)
            ->first();

        if ($existingPresence) {
            return response()->json(['error' => 'You have already marked arrival for today'], 400);
        }

        $presence = new Presence();
        $presence->user_id = Auth::id();
        $presence->datang = $request->datang;
        $presence->location = 'Latitude: ' . $request->latitude . ', Longitude: ' . $request->longitude;
        $presence->status = 'masuk';
        $presence->save();

        return response()->json(['success' => true]);
    }

    public function markDeparture(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $presence = Presence::where('user_id', $user->id)
            ->whereDate('datang', $today)
            ->first();

        if (!$presence) {
            return response()->json(['error' => 'You need to mark arrival before departure'], 400);
        }

        if (!is_null($presence->pulang)) {
            return response()->json(['error' => 'You have already marked departure today'], 400);
        }

        $jabatan = Jabatan::where('nama_jabatan', $user->posisi)->first();
        $gajiPokok = $jabatan ? $jabatan->gaji_pokok : 0;
        $gajiHarian = $gajiPokok / 26;

        $presence->pulang = $request->pulang;
        $presence->location = "Latitude: {$request->latitude}, Longitude: {$request->longitude}";
        $presence->save();

        // Update atau buat entri gaji harian
        Gaji::updateOrCreate(
            ['user_id' => $user->id, 'tanggal' => $today],
            ['gaji' => $gajiHarian]
        );

        return response()->json(['success' => true]);
    }
    public function dailyCheck()
    {
        $today = Carbon::today()->toDateString();
        $users = User::all();

        foreach ($users as $user) {
            $presence = Presence::where('user_id', $user->id)
                ->whereDate('datang', $today)
                ->first();

            if (!$presence) {
                $newPresence = new Presence();
                $newPresence->user_id = $user->id;
                $newPresence->datang = $today;
                $newPresence->pulang = $today;
                $newPresence->status = 'absent';
                $newPresence->save();
            }
        }

        return "Daily check completed.";
    }
}
