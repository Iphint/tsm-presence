<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Presence::whereHas('user', function ($query) use ($user) {
            $query->where('outlet_cabang', $user->outlet_cabang);
        });
        $query = Presence::whereHas('user', function ($query) use ($user) {
            $query->where('outlet_cabang', $user->outlet_cabang);
        });

        $presences = $query->paginate(30);

        return view('admin.presensi.index', compact('presences'));
    }
}
