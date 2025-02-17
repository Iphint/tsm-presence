<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburanPegawaiController extends Controller
{
    public function index()
    {
        $lemburs = Lembur::where('user_id', Auth::user()->id)->get();
        return view('pegawai.lemburan.index', compact('lemburs'));
    }
    public function create()
    {
        return view('pegawai.lemburan.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'start_lembur' => 'required|date_format:H:i',
            'selesai_lembur' => 'required|date_format:H:i',
        ]);

        list($startHour, $startMinute) = explode(':', $request->start_lembur);
        list($endHour, $endMinute) = explode(':', $request->selesai_lembur);

        $startTotalMinutes = ($startHour * 60) + $startMinute;
        $endTotalMinutes = ($endHour * 60) + $endMinute;

        if ($endTotalMinutes < $startTotalMinutes) {
            $diffInMinutes = ($endTotalMinutes + 1440) - $startTotalMinutes;
        } else {
            $diffInMinutes = $endTotalMinutes - $startTotalMinutes;
        }

        $diffInHours = floor($diffInMinutes / 60);
        $salaryLembur = $diffInHours * 15000;

        Lembur::create([
            'user_id' => Auth::user()->id,
            'tanggal' => $request->tanggal,
            'start_lembur' => $request->start_lembur,
            'selesai_lembur' => $request->selesai_lembur,
            'salary_lembur' => $salaryLembur,
            'tugas' => $request->tugas,
        ]);

        return redirect()->route('lembur-pegawai.index')->with('success', 'Lemburan berhasil diajukan.');
    }

    public function edit($id)
    {
        $lembur = Lembur::findOrFail($id);
        return view('pegawai.lemburan.edit', compact('lembur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'start_lembur' => 'required|date_format:H:i',
            'selesai_lembur' => 'required|date_format:H:i|after:start_lembur',
        ]);

        $lembur = Lembur::findOrFail($id);
        $lembur->update([
            'tanggal' => $request->tanggal,
            'start_lembur' => $request->start_lembur,
            'selesai_lembur' => $request->selesai_lembur,
        ]);

        return redirect()->route('lemburan.index')->with('success', 'Lemburan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->delete();

        return redirect()->route('lemburan.index')->with('success', 'Lemburan berhasil dihapus.');
    }
}
