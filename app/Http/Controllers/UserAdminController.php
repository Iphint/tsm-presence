<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::where('outlet_cabang', $user->outlet_cabang)->get();
        return view('admin.users.index', compact('users'));
    }
}
