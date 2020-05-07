<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('changePassword');
    } 
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'password_confirmation' => ['required','string','min:4'],
        ]);

        Auth::user()->password=Hash::make($validated['password']);
        Auth::user()->save();

        return view('home');
    }
}
