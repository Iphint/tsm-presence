<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Outlets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $outlets = Outlets::all();
        $jabatans = Jabatan::all();

        return view('auth.register', compact('outlets', 'jabatans'));
    }
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'outlet_cabang' => 'required|string|max:255',
            'duration' => 'nullable|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|string|max:20|unique:users',
            'npwp' => 'nullable|string|max:20',
            'role' => 'required|in:admin,magang,pegawai',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Simpan data user
        $user = User::create([
            'name' => $request->name,
            'posisi' => $request->posisi,
            'outlet_cabang' => $request->outlet_cabang,
            'duration' => $request->duration,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'npwp' => $request->npwp,
            'role' => $request->role,
            'photo' => $photoPath,
        ]);

        // Redirect ke login
        return view('auth.login');
    }
}
