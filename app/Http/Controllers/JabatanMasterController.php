<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanMasterController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('master.jabatan.index', compact('jabatans'));
    }
    public function create()
    {
        return (view('master.jabatan.create'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric',
        ]);

        Jabatan::create($validated);

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan');
    }
    public function edit(Jabatan $jabatan)
    {
        return view('master.jabatan.edit', compact('jabatan'));
    }
    public function update(Request $request, Jabatan $jabatan)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_jabatan' => 'required|numeric',
        ]);

        $jabatan->update($validated);
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diupdate');
    }
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }
}
