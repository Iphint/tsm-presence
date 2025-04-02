<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceAdminController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        $user = Auth::user();
        $query = Presence::whereHas('user', function ($query) use ($user) {
            $query->where('outlet_cabang', $user->outlet_cabang);
        });
    
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
    
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', '=', $request->date);
        }
    
        $presences = $query->paginate(50);
        return view('admin.presensi.index', compact('presences'));
    }
    
}
