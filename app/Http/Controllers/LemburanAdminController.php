<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburanAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $lemburs = Lembur::whereHas('user', function ($query) use ($user) {
            $query->where('outlet_cabang', $user->outlet_cabang);
        })->with('user')->get();

        return view('admin.lemburan.index', compact('lemburs'));
    }
    public function edit($id)
    {
        $lembur = Lembur::findOrFail($id);
        return view('admin.lemburan.edit', compact('lembur'));
    }
    public function show($id)
    {
        $lembur = Lembur::findOrFail($id);
        return view('admin.lemburan.show', compact('lembur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'start_lembur' => 'required|date_format:H:i:s',
            'selesai_lembur' => 'required|date_format:H:i:s',
            'action' => 'required|in:pending,approved,rejected',
        ]);

        $lembur = Lembur::findOrFail($id);
        $lembur->update([
            'tanggal' => $request->tanggal,
            'start_lembur' => $request->start_lembur,
            'selesai_lembur' => $request->selesai_lembur,
            'action' => $request->action,
        ]);

        return redirect()->route('lembur-admin.index')->with('success', 'Lemburan berhasil diupdate.');
    }
}
