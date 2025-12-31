<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('profile.index', [
            'tab' => $request->query('tab')
        ]);
    }
}
