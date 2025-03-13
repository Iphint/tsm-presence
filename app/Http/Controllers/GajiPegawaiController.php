<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Jabatan;
use App\Models\Kinerja;
use App\Models\Lembur;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GajiPegawaiController extends Controller
{
    private const TUNJANGAN_PER_TAHUN = 50000;

    public function index()
    {
        $user = Auth::user();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $jabatan = Jabatan::where('nama_jabatan', $user->posisi)->first();
        $gajiPokok = $jabatan ? $jabatan->gaji_pokok : 0;
        $gajiHarian = $gajiPokok / 26;
        $bulanSekarang = Carbon::now()->format('Y-m');
    
        // Ambil data kinerja user
        $kinerja = Kinerja::where('user_id', $user->id)->where('bulan', $bulanSekarang)->first();
        $tunjanganJabatan = $kinerja ? $kinerja->tunjangan_jabatan : 0;
        $potongan = $kinerja ? $kinerja->potongan : 0; 
    
        // Hitung tunjangan masa kerja
        $masaKerjaTahun = $this->hitungMasaKerjaTahun($user->duration);
        $tunjanganMasaKerja = $this->hitungTunjanganMasaKerja($masaKerjaTahun);
    
        // Hitung jumlah hari kerja
        $workedDays = Presence::where('user_id', $user->id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();
    
        $masukDays = Presence::where('user_id', $user->id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->where('status', 'masuk')
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();
    
        $izinDays = Presence::where('user_id', $user->id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->where('status', 'izin')
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();
    
        $absentDays = Presence::where('user_id', $user->id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->where('status', 'absent')
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();
    
        // Hitung gaji pokok berdasarkan hari kerja
        $salary = $workedDays * $gajiHarian;
    
        // Hitung lembur
        $lemburan = Lembur::where('user_id', $user->id)
            ->whereMonth('tanggal', $startOfMonth->month)
            ->whereYear('tanggal', $startOfMonth->year)
            ->where('action', 'approved')
            ->get();
    
        $totalJamLembur = 0;
        foreach ($lemburan as $lembur) {
            $start = Carbon::createFromFormat('H:i:s', $lembur->start_lembur);
            $end = Carbon::createFromFormat('H:i:s', $lembur->selesai_lembur);
    
            if ($end->format('H:i:s') === '00:00:00') {
                $end = Carbon::createFromFormat('H:i:s', '24:00:00');
            }
    
            $jamLembur = abs($end->diffInHours($start));
            $totalJamLembur += $jamLembur;
        }
    
        $totalGajiLembur = $lemburan->sum('salary_lembur');
    
        // Hitung total gaji termasuk potongan
        $totalGaji = $salary + $tunjanganMasaKerja - $potongan;
    
        // Simpan/update data ke kinerja bulanan
        $this->simpanKinerjaBulanan($user, $jabatan, $tunjanganMasaKerja);
    
        return view('pegawai.gaji.index', compact(
            'workedDays',
            'tunjanganMasaKerja',
            'jabatan',
            'totalJamLembur',
            'totalGaji',
            'totalGajiLembur',
            'salary',
            'masukDays',
            'izinDays',
            'absentDays',
            'potongan'
        ));
    }
    private function hitungMasaKerjaTahun($duration)
    {
        if (empty($duration)) {
            return 0;
        }

        try {
            $tanggalMulai = Carbon::parse($duration)->startOfDay();
            $tanggalSekarang = Carbon::now()->startOfDay();

            $bulanKerja = $tanggalMulai->diffInMonths($tanggalSekarang);
            $tahunKerja = floor($bulanKerja / 12);

            return $tahunKerja;
        } catch (\Throwable $th) {
            Log::error("Gagal mem-parse tanggal mulai kerja: " . $duration . " - " . $th->getMessage());
            return 0;
        }
    }
    private function hitungTunjanganMasaKerja($tahun)
    {
        $tahunPenuh = min(floor($tahun), 3);
        return $tahunPenuh * self::TUNJANGAN_PER_TAHUN;
    }
    public function print()
    {
        $user = Auth::user();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $gaji = Gaji::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->sum('gaji');

        if (!$gaji) {
            abort(404);
        }

        $bulanSekarang = Carbon::now()->format('Y-m');
        $kinerja = Kinerja::where('user_id', $user->id)
            ->where('bulan', $bulanSekarang)
            ->first();

        $tunjanganJabatan = $kinerja ? $kinerja->tunjangan_jabatan : 0;
        $tunjanganMasaKerja = $kinerja ? $kinerja->tunjangan_masa_kerja : 0;
        $potongan = $kinerja ? $kinerja->potongan : 0; 

        $jabatan = Jabatan::where('nama_jabatan', $user->posisi)->first();
        $gajiPokok = $jabatan ? $jabatan->gaji_pokok : 0;

        $gajiHarian = $gajiPokok / 26;

        $workedDays = Presence::where('user_id', $user->id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();

        $absentDays = Presence::where('user_id', $user->id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->where('status', 'absent')
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();

        $dendaAbsent = $absentDays * 50000;
        $salary = $workedDays * $gajiHarian;

        $jabatan = Jabatan::where('nama_jabatan', $user->posisi)->first();
        $workedDays = $this->getWorkedDays($user);
        $masaKerjaTahun = $this->hitungMasaKerjaTahun($user->duration);

        $bpjs = $user->bpjs;
        $ketenagakerjaan = $user->ketenagakerjaan;

        $lemburan = Lembur::where('user_id', $user->id)
            ->whereMonth('tanggal', $startOfMonth->month)
            ->whereYear('tanggal', $startOfMonth->year)
            ->where('action', 'approved')
            ->get();

        $totalGajiLembur = $lemburan->sum('salary_lembur');

        $totalSalary = $salary + $tunjanganMasaKerja + $tunjanganJabatan + $totalGajiLembur - $bpjs - $ketenagakerjaan - $dendaAbsent - $potongan;

        return view('pegawai.gaji.print', compact('user', 'gaji', 'jabatan', 'workedDays', 'tunjanganMasaKerja', 'totalSalary', 'bpjs', 'totalGajiLembur', 'workedDays', 'salary', 'tunjanganJabatan', 'ketenagakerjaan', 'dendaAbsent', 'potongan'));
    }
    private function getWorkedDays($user)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return Presence::where('user_id', $user->id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();
    }
    private function simpanKinerjaBulanan($user, $jabatan, $tunjanganMasaKerja)
    {
        $bulan = Carbon::now()->format('Y-m');
        $kinerja = Kinerja::firstOrCreate(
            [
                'user_id' => $user->id,
                'bulan' => $bulan
            ],
            [
                'tunjangan_jabatan' => $jabatan->tunjangan_jabatan ?? 0,
                'tunjangan_masa_kerja' => $tunjanganMasaKerja,
                'potongan' => 0
            ]
        );
        $kinerja->update([
            'tunjangan_jabatan' => $jabatan->tunjangan_jabatan ?? 0,
            'tunjangan_masa_kerja' => $tunjanganMasaKerja,
            'potongan' => $kinerja->potongan ?? 0
        ]);
    }
}
