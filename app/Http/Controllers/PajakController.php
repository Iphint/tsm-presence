<?php

namespace App\Http\Controllers;

use App\Exports\PajakExport;
use App\Models\Jabatan;
use App\Models\Kinerja;
use App\Models\Lembur;
use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PajakController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($bulan)->startOfMonth();
        $endOfMonth = Carbon::parse($bulan)->endOfMonth();

        // Ambil bulan sebelumnya
        $bulanSebelumnya = Carbon::parse($bulan)->subMonth()->format('Y-m');
        $startOfLastMonth = Carbon::parse($bulanSebelumnya)->startOfMonth();
        $endOfLastMonth = Carbon::parse($bulanSebelumnya)->endOfMonth();

        // Bulan sebelumnya
        $bulanSebelumnya = Carbon::parse($bulan)->subMonth()->format('Y-m');
        $startOfLastMonth = Carbon::parse($bulanSebelumnya)->startOfMonth();
        $endOfLastMonth = Carbon::parse($bulanSebelumnya)->endOfMonth();

        // Ambil semua karyawan sekaligus
        $karyawans = User::where('role', '!=', 'master_admin')->get();
        $userIds = $karyawans->pluck('id');

        $dataPajak = [];

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

            $workedDaysLastMonth = Presence::where('user_id', $karyawan->id)
                ->whereBetween('pulang', [$startOfLastMonth, $endOfLastMonth])
                ->selectRaw('DATE(pulang) as work_day')
                ->distinct()
                ->count();

            $absentDaysLastMonth = Presence::where('user_id', $karyawan->id)
                ->whereBetween('pulang', [$startOfLastMonth, $endOfLastMonth])
                ->where('status', 'absent')
                ->selectRaw('DATE(pulang) as work_day')
                ->distinct()
                ->count();

            $salaryLastMonth = $workedDaysLastMonth * $gajiHarian;
            $lemburanLastMonth = Lembur::where('user_id', $karyawan->id)
                ->whereMonth('tanggal', $startOfLastMonth->month)
                ->whereYear('tanggal', $startOfLastMonth->year)
                ->where('action', 'approved')
                ->get();

            $totalGajiLemburLastMonth = $lemburanLastMonth->sum('salary_lembur');
            $dendaAbsentLastMonth = $absentDaysLastMonth * 50000;
            $netSalaryLastMonth = $salaryLastMonth + $totalGajiLemburLastMonth - $bpjs - $dendaAbsentLastMonth - $ketenagakerjaan;

            $salary = $workedDays * $gajiHarian;
            $tanggalPemotongan = $endOfMonth->toDateString();
            $masaKerjaTahun = $this->hitungMasaKerjaTahun($karyawan->duration);

            $lemburan = Lembur::where('user_id', $karyawan->id)
                ->whereMonth('tanggal', $startOfMonth->month)
                ->whereYear('tanggal', $startOfMonth->year)
                ->where('action', 'approved')
                ->get();

            $totalGajiLembur = $lemburan->sum('salary_lembur');
            $dendaAbsent = $absentDays * 50000;
            $totalGaji = $salary + $tunjanganMasaKerja + $totalGajiLembur + $tunjanganJabatan - $bpjs - $dendaAbsent - $ketenagakerjaan;

            $dataPajak[] = [
                'id' => $karyawan->id,
                'nama' => $karyawan->name,
                'nik' => $karyawan->nik,
                'npwp' => $karyawan->npwp,
                'alamat' => $karyawan->alamat,
                'ptkp' => $karyawan->ptkp,
                'gaji_pokok' => $gajiPokok,
                'salary' => $salary,
                'totalGaji' => $totalGaji,
                'tanggal_pemotongan' => $tanggalPemotongan,
                'net_salary_bulan_sebelumnya' => $netSalaryLastMonth,
            ];
        }

        return view('master.pajak.index', compact('dataPajak', 'bulan'));
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->format('Y-m'));
        $dataPajak = $this->getDataPajak($bulan);

        return Excel::download(new PajakExport($dataPajak), 'Laporan_Pajak_' . $bulan . '.xlsx');
    }

    private function getDataPajak($bulan)
    {
        try {
            $startOfMonth = Carbon::parse($bulan)->startOfMonth();
            $endOfMonth = Carbon::parse($bulan)->endOfMonth();

            $bulanSebelumnya = Carbon::parse($bulan)->subMonth()->format('Y-m');
            $startOfLastMonth = Carbon::parse($bulanSebelumnya)->startOfMonth();
            $endOfLastMonth = Carbon::parse($bulanSebelumnya)->endOfMonth();

            $karyawans = User::where('role', '!=', 'master_admin')->get();

            $dataPajak = [];

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
                    ->distinct()
                    ->count('pulang');

                $absentDays = Presence::where('user_id', $karyawan->id)
                    ->whereBetween('pulang', [$startOfMonth, $endOfMonth])
                    ->where('status', 'absent')
                    ->distinct()
                    ->count('pulang');

                $workedDaysLastMonth = Presence::where('user_id', $karyawan->id)
                    ->whereBetween('pulang', [$startOfLastMonth, $endOfLastMonth])
                    ->distinct()
                    ->count('pulang');

                $absentDaysLastMonth = Presence::where('user_id', $karyawan->id)
                    ->whereBetween('pulang', [$startOfLastMonth, $endOfLastMonth])
                    ->where('status', 'absent')
                    ->distinct()
                    ->count('pulang');

                $salaryLastMonth = $workedDaysLastMonth * $gajiHarian;
                $lemburanLastMonth = Lembur::where('user_id', $karyawan->id)
                    ->whereBetween('tanggal', [$startOfLastMonth, $endOfLastMonth])
                    ->where('action', 'approved')
                    ->sum('salary_lembur');

                $dendaAbsentLastMonth = $absentDaysLastMonth * 50000;
                $netSalaryLastMonth = $salaryLastMonth + $lemburanLastMonth - $bpjs - $dendaAbsentLastMonth - $ketenagakerjaan;

                $salary = $workedDays * $gajiHarian;
                $lemburan = Lembur::where('user_id', $karyawan->id)
                    ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                    ->where('action', 'approved')
                    ->sum('salary_lembur');

                $dendaAbsent = $absentDays * 50000;
                $totalGaji = $salary + $tunjanganMasaKerja + $lemburan + $tunjanganJabatan - $bpjs - $dendaAbsent - $ketenagakerjaan;

                $dataPajak[] = [
                    'id' => $karyawan->id,
                    'nama' => $karyawan->name,
                    'nik' => $karyawan->nik,
                    'npwp' => $karyawan->npwp,
                    'alamat' => $karyawan->alamat,
                    'ptkp' => $karyawan->ptkp,
                    'gaji_pokok' => $gajiPokok,
                    'salary' => $salary,
                    'totalGaji' => $totalGaji,
                    'tanggal_pemotongan' => $endOfMonth->toDateString(),
                    'net_salary_bulan_sebelumnya' => $netSalaryLastMonth,
                ];
            }

            return collect($dataPajak);
        } catch (\Exception $e) {
            Log::error('Error mendapatkan data pajak: ' . $e->getMessage());
            return collect([]);
        }
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
}
