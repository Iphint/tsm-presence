<?php

namespace App\Http\Controllers;

use App\Models\Outlets;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanPegawaiController extends Controller
{
    public function index()
    {
        $outlets = Outlets::all();
        return view('pegawai.pengajuan.index', compact('outlets'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'datang'     => 'required|date',
            'pulang'     => 'nullable|date|after_or_equal:datang',
            'location'   => 'nullable|string',
            'status'     => 'required|in:masuk,off,sakit,izin,cuti,absent',
            'keterangan' => 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('presences', 'public');
        }

        Presence::create([
            'user_id' => Auth::id(),
            'datang'     => $request->datang,
            'pulang'     => $request->pulang,
            'location'   => $request->location,
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
            'image'      => $imagePath,
        ]);

        return redirect()->route('presence-pegawai.index')->with('success', 'Data presensi berhasil disimpan.');
    }
}
