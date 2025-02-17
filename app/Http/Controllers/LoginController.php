<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role == 'master_admin') {
                return redirect()->route('dashboard.index');
            } elseif ($user->role == 'pegawai') {
                return redirect()->route('dashboard-pegawai.index');
            } elseif ($user->role == 'magang') {
                return redirect()->route('dashboard-magang.index');
            } else {
                return redirect()->route('dashboard-admin.index');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('login.index')->with('success', 'Berhasil logout.');
    }
}
