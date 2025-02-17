<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanPegawaiController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('master.jabatan.index', compact('jabatans'));
    }
}
