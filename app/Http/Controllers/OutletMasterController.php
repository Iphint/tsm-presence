<?php

namespace App\Http\Controllers;

use App\Models\Outlets;
use Illuminate\Http\Request;

class OutletMasterController extends Controller
{
    public function index()
    {
        $outlets = Outlets::all();
        return view('master.outlets.index', compact('outlets'));
    }
    public function create()
    {
        return view('master.outlets.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_outlet' => 'required|string|max:255',
            'alamat' => 'required|string'
        ]);

        Outlets::create($validated);

        return redirect()
            ->route('outlet.index')
            ->with('success', 'Outlet berhasil ditambahkan');
    }
    public function edit(Outlets $outlet)
    {
        return view('master.outlets.edit', compact('outlet'));
    }
    public function update(Request $request, Outlets $outlet)
    {
        $validated = $request->validate([
            'nama_outlet' => 'required|string|max:255',
            'alamat' => 'required|string'
        ]);

        $outlet->update($validated);
        return redirect()->route('outlet.index')->with('success', 'Outlet berhasil diupdate');
    }
    public function destroy(Outlets $outlet)
    {
        $outlet->delete();
        return redirect()->route('outlet.index')->with('success', 'Outlet berhasil dihapus');
    }
}
