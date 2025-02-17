<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Jabatan;
use App\Models\Kinerja;
use App\Models\Lembur;
use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GajiMasterController extends Controller
{
    private const TUNJANGAN_PER_TAHUN = 50000;
    private const MAX_TAHUN = 3;
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->format('Y-m'));

        $startOfMonth = Carbon::parse($bulan)->startOfMonth();
        $endOfMonth = Carbon::parse($bulan)->endOfMonth();

        $karyawans = User::where('role', '!=', 'master_admin')->get();
        $dataGaji = [];

        foreach ($karyawans as $karyawan) {
            $jabatan = Jabatan::where('nama_jabatan', $karyawan->posisi)->first();
            $gajiPokok = $jabatan ? $jabatan->gaji_pokok : 0;
            $gajiHarian = $gajiPokok / 26;
            $bpjs = $karyawan->bpjs ?? 0;
            $ketenagakerjaan = $karyawan->ketenagakerjaan ?? 0;

            $kinerja = Kinerja::where('user_id', $karyawan->id)
                ->where('bulan', $bulan)
                ->first();

            $tunjanganJabatan = $kinerja ? $kinerja->tunjangan_jabatan : 0;
            $tunjanganMasaKerja = $kinerja ? $kinerja->tunjangan_masa_kerja : 0;

            $workedDays = Presence::where('user_id', $karyawan->id)
                ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
                ->selectRaw('DATE(pulang) as work_day')
                ->distinct()
                ->count();

            $masukDays = Presence::where('user_id', $karyawan->id)
                ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
                ->where('status', 'masuk')
                ->selectRaw('DATE(pulang) as work_day')
                ->distinct()
                ->count();

            $izinDays = Presence::where('user_id', $karyawan->id)
                ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
                ->whereNotIn('status', ['masuk', 'absent'])
                ->selectRaw('DATE(pulang) as work_day')
                ->distinct()
                ->count();

            $absentDays = Presence::where('user_id', $karyawan->id)
                ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
                ->where('status', 'absent')
                ->selectRaw('DATE(pulang) as work_day')
                ->distinct()
                ->count();

            $salary = $workedDays * $gajiHarian;
            $masaKerjaTahun = $this->hitungMasaKerjaTahun($karyawan->duration);

            $lemburan = Lembur::where('user_id', $karyawan->id)
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
            $dendaAbsent = $absentDays * 50000;
            $totalGaji = $salary + $tunjanganMasaKerja + $totalGajiLembur + $tunjanganJabatan - $bpjs - $dendaAbsent - $ketenagakerjaan;

            $dataGaji[] = [
                'id' => $karyawan->id,
                'nama' => $karyawan->name,
                'gaji_pokok' => $gajiPokok,
                'gaji_harian' => $gajiHarian,
                'worked_days' => $workedDays,
                'masuk_days' => $masukDays,
                'izin_days' => $izinDays,
                'absent_days' => $absentDays,
                'salary' => $salary,
                'tunjangan_masa_kerja' => $tunjanganMasaKerja,
                'total_jam_lembur' => $totalJamLembur,
                'total_gaji_lembur' => $totalGajiLembur,
                'total_gaji' => $totalGaji,
                'bpjs' => $bpjs,
                'ketenagakerjaan' => $ketenagakerjaan,
                'tunjangan_jabatan' => $tunjanganJabatan,
                'denda_absent' => $dendaAbsent,
            ];
        }

        return view('master.gaji.index', compact('dataGaji', 'bulan'));
    }
    public function show($id, Request $request)
    {
        // Ambil bulan dari request atau gunakan bulan saat ini
        $bulan = $request->input('bulan', Carbon::now()->format('Y-m'));

        // Konversi ke format tanggal awal & akhir bulan
        $startOfMonth = Carbon::parse($bulan)->startOfMonth();
        $endOfMonth = Carbon::parse($bulan)->endOfMonth();

        // Ambil data karyawan berdasarkan ID
        $karyawan = User::findOrFail($id);

        // Ambil data jabatan & gaji
        $jabatan = Jabatan::where('nama_jabatan', $karyawan->posisi)->first();
        $gajiPokok = $jabatan ? $jabatan->gaji_pokok : 0;
        $tunjanganJabatan = $jabatan ? $jabatan->tunjangan_jabatan : 0;
        $gajiHarian = $gajiPokok / 26;
        $bpjs = $karyawan->bpjs ?? 0;

        // Hitung jumlah hari kerja
        $workedDays = Presence::where('user_id', $id)
            ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(pulang) as work_day')
            ->distinct()
            ->count();

        // Hitung jumlah hari masuk, izin, dan absent
        $masukDays = Presence::where('user_id', $id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'masuk')
            ->selectRaw('DATE(created_at) as work_day')
            ->distinct()
            ->count();

        $izinDays = Presence::where('user_id', $id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereNotIn('status', ['masuk', 'absent'])
            ->selectRaw('DATE(created_at) as work_day')
            ->distinct()
            ->count();

        $absentDays = Presence::where('user_id', $id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'absent')
            ->selectRaw('DATE(created_at) as work_day')
            ->distinct()
            ->count();

        // Hitung gaji berdasarkan hari kerja
        $salary = $workedDays * $gajiHarian;

        // Hitung tunjangan masa kerja
        $masaKerjaTahun = $this->hitungMasaKerjaTahun($karyawan->duration);
        $tunjanganMasaKerja = $this->hitungTunjanganMasaKerja($masaKerjaTahun);

        // Hitung lembur
        $lemburan = Lembur::where('user_id', $id)
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
        $dendaAbsent = $absentDays * 50000;
        $totalGaji = $salary + $tunjanganMasaKerja + $totalGajiLembur + $tunjanganJabatan - $bpjs - $dendaAbsent;

        // Format data untuk tampilan
        $gajiDetail = [
            'id' => $karyawan->id,
            'nama' => $karyawan->name,
            'gaji_pokok' => $gajiPokok,
            'gaji_harian' => $gajiHarian,
            'worked_days' => $workedDays,
            'masuk_days' => $masukDays,
            'izin_days' => $izinDays,
            'absent_days' => $absentDays,
            'salary' => $salary,
            'tunjangan_masa_kerja' => $tunjanganMasaKerja,
            'total_jam_lembur' => $totalJamLembur,
            'total_gaji_lembur' => $totalGajiLembur,
            'total_gaji' => $totalGaji,
            'bpjs' => $bpjs,
            'tunjangan_jabatan' => $tunjanganJabatan,
            'denda_absent' => $dendaAbsent,
        ];

        return view('master.gaji.show', compact('gajiDetail', 'bulan'));
    }
    public function edit($id)
    {
        $bulan = request('bulan', Carbon::now()->format('Y-m'));
        $user = User::findOrFail($id);
        $kinerja = Kinerja::where('user_id', $id)
            ->where('bulan', $bulan)
            ->first();
        return view('master.gaji.edit', compact('user', 'kinerja'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tunjangan_jabatan' => 'nullable|numeric|min:0',
            'tunjangan_masa_kerja' => 'nullable|numeric|min:0',
        ]);

        $kinerja = Kinerja::findOrFail($id);
        $kinerja->update([
            'tunjangan_jabatan' => $request->tunjangan_jabatan,
            'tunjangan_masa_kerja' => $request->tunjangan_masa_kerja,
        ]);

        return redirect()->route('salary.index')->with('success', 'Tunjangan berhasil diperbarui.');
    }

    private function hitungMasaKerjaTahun($duration)
    {
        if (empty($duration)) {
            return 0;
        }

        try {
            $tanggalMulai = Carbon::parse($duration);
            $tanggalSekarang = Carbon::now();

            $tanggalMulai->startOfDay();
            $tanggalSekarang->startOfDay();

            return $tanggalMulai->diffInYears($tanggalSekarang);
        } catch (\Throwable $th) {
            Log::error("Gagal mem-parse tanggal mulai kerja: " . $duration . " - " . $th->getMessage());
            return 0;
        }
    }

    private function hitungTunjanganMasaKerja($tahun)
    {
        $tahunPenuh = min(floor($tahun), self::MAX_TAHUN);
        return $tahunPenuh * self::TUNJANGAN_PER_TAHUN;
    }
}
