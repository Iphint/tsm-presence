<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Outlets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserMasterController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('master.users.index', ['users' => $users]);
    }
    public function show(User $user)
    {
        return view('master.users.show', compact('user'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $outlets = Outlets::all();
        $jabatans = Jabatan::all();

        return view('master.users.edit', compact('user', 'outlets', 'jabatans'));
    }
    public function create()
    {
        $outlets = Outlets::all();
        $jabatans = Jabatan::all();

        return view('master.users.create', compact('outlets', 'jabatans'));
    }
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'outlet_cabang' => 'required|string|max:255',
            'duration' => 'nullable|date_format:Y-m-d',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nik' => 'required|string|max:16|unique:users,nik',
            'npwp' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'role' => 'required|in:master_admin,admin,pegawai',
            'bpjs' => 'nullable|string|max:15',
            'ketenagakerjaan' => 'nullable|string|max:15',
            'alamat' => 'required|string|max:255',
            'ptkp' => 'required|string|max:20',
            'no_rek' => 'required|string|max:50',
        ]);

        // Menyimpan foto jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Simpan data user ke database
        User::create([
            'name' => $request->name,
            'posisi' => $request->posisi,
            'outlet_cabang' => $request->outlet_cabang,
            'duration' => $request->duration,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'npwp' => $request->npwp,
            'photo' => $photoPath,
            'role' => $request->role,
            'bpjs' => $request->bpjs,
            'ketenagakerjaan' => $request->ketenagakerjaan,
            'ptkp' => $request->ptkp,
            'no_rek' => $request->no_rek,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'posisi' => 'required|string|max:255',
                'outlet_cabang' => 'required|string|max:255',
                'duration' => 'nullable|date',
                'email' => 'required|email|unique:users,email,' . $id,
                'nik' => 'required|string|max:16|unique:users,nik,' . $id,
                'npwp' => 'nullable|string|max:15',
                'bpjs' => 'nullable|string|max:15',
                'ketenagakerjaan' => 'nullable|string|max:15',
                'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
                'alamat' => 'required|string|max:255',
                'ptkp' => 'required|string|max:20',
                'role' => 'required|in:master_admin,admin,pegawai',
                'no_rek' => 'required|max:50',
            ]);
            $user = User::findOrFail($id);
            if ($request->hasFile('photo')) {
                if ($user->photo && Storage::exists('public/' . $user->photo)) {
                    Storage::delete('public/' . $user->photo);
                }
                $user->photo = $request->file('photo')->store('photos', 'public');
            }
            $user->update([
                'name' => $request->name,
                'posisi' => $request->posisi,
                'outlet_cabang' => $request->outlet_cabang,
                'duration' => $request->duration,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'bpjs' => $request->bpjs,
                'role' => $request->role,
                'ketenagakerjaan' => $request->ketenagakerjaan,
                'ptkp' => $request->ptkp,
                'no_rek' => $request->no_rek,
            ]);

            return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', 'Data sudah digunakan! Periksa kembali.')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui user.')->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo && Storage::exists('public/' . $user->photo)) {
            Storage::delete('public/' . $user->photo);
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
