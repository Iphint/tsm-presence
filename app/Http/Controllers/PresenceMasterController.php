<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Jabatan;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceMasterController extends Controller
{
    public function index(Request $request)
    {
        $query = Presence::with('user')
            ->whereHas('user', function ($q) {
                $q->where('role', '!=', 'master_admin');
            })
            ->orderBy('created_at', 'desc');
    
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('posisi', 'like', '%' . $search . '%')
                    ->orWhere('outlet_cabang', 'like', '%' . $search . '%');
            });
        }
    
        if ($request->has('date') && $request->date != '') {
            $date = $request->date;
            $query->whereDate('created_at', '=', $date);
        }
    
        $presences = $query->paginate(50);
        
        foreach ($presences as $presence) {
            $datang = $presence->datang ? Carbon::parse($presence->datang) : null;
            $pulang = $presence->pulang ? Carbon::parse($presence->pulang) : null;
            if ($datang && $pulang) {
                $totalMinutes = $datang->diffInMinutes($pulang);
            } elseif ($datang) {
                $totalMinutes = 8 * 60;
            } else {
                $totalMinutes = 0;
            }
            $totalMinutes = min($totalMinutes, 8 * 60);
            $totalHours = intdiv($totalMinutes, 60);
            $totalRemainingMinutes = $totalMinutes % 60;
            $presence->totalWorkTime = "{$totalHours} Jam {$totalRemainingMinutes} Menit";

            if ($datang) {
                $hour = $datang->hour;
                if ($hour >= 6 && $hour < 14) {
                    $shift = "Pagi";
                } elseif ($hour >= 14 && $hour < 22) {
                    $shift = "Sore";
                } else {
                    $shift = "Tidak Diketahui";
                }
            } else {
                $shift = "Tidak Diketahui";
            }
    
            $presence->shift = $shift;
        }
    
        return view('master.presensi.index', compact('presences'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'datang'   => 'nullable|date',
            'pulang'   => 'nullable|date|after_or_equal:datang',
            'keterangan' => 'nullable|string',
            'status'   => 'required|in:masuk,off,sakit,izin,cuti,absent',
        ]);
        $presence = Presence::findOrFail($id);
        $presence->update([
            'datang'   => $request->datang,
            'pulang'   => $request->pulang,
            'keterangan' => $request->keterangan,
            'status'   => $request->status,
        ]);
        return redirect()->route('presence.index')->with('success', 'Data presensi berhasil diperbarui.');
    }
    public function verifyPresence(Request $request)
    {
        $presence = Presence::find($request->presence_id);

        if (!$presence) {
            return response()->json(['error' => 'Data presensi tidak ditemukan'], 404);
        }

        // Pastikan status bisa diverifikasi
        if (!in_array($presence->status, ['off', 'izin', 'sakit', 'cuti'])) {
            return response()->json(['error' => 'Status ini tidak perlu diverifikasi'], 400);
        }

        $user = $presence->user;
        $jabatan = Jabatan::where('nama_jabatan', $user->posisi)->first();
        $gajiPokok = $jabatan ? $jabatan->gaji_pokok : 0;
        $gajiHarian = $gajiPokok / 26;

        // Tambahkan gaji sesuai status
        Gaji::updateOrCreate(
            ['user_id' => $user->id, 'tanggal' => Carbon::today()->toDateString()],
            ['gaji' => $gajiHarian]
        );

        $presence->verified = true;
        $presence->save();

        return response()->json(['success' => true]);
    }
}
