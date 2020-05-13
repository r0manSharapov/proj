<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('settings.changePassword');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if(!(Hash::check($request->get('current_password'),$user->password))){
            return back()->with('error','Your current password doesnt match with the one provided!');
        }

        if(strcmp($request->get('current_password'),$request->get('password')) == 0){
            return back()->with('error','Your new password cant be the same as the old password.');
        }

        if(!strcmp($request->get('password'),$request->get('password_confirmation')) == 0){
            return back()->with('error','Your new password confirmation doesnt match new password');
        }

        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            //'password_confirmation' => ['required','string','min:4'],
        ]);

        $user->password=Hash::make($validated['password']);
        $user->save();

        return back()->with('message',"Password changed successfully");
    }
}
