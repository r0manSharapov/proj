<?php


namespace App\Http\Controllers;


//use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController
{
    public function index()
    {

        return view('settings');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'nif' => ['nullable','numeric', 'digits:9'],
            'telefone' => ['nullable','numeric', 'digits:9'],
            'foto'=>['nullable'],
        ]);

        $name = $validated['name'];
        $email = $validated['email'];
        $nif = $validated['nif'];
        $telefone = $validated['telefone'];
        $foto = $validated['foto'];

        DB::update('update users set name = ?,email=?,nif=?,telefone=?,foto=? where id = ?',[$name,$email,$nif,$telefone,$foto,Auth::User()->id]);

        Auth::user()->save();

        return back()->with('message','Profile updated');
    }

    public function destroy(Request $request)
    {
        if(!(Hash::check($request->get('password'),Auth::user()->password))){
            return back()->with('error','Incorrect password');
        }

        $validated = $request->validate(['password' => ['required', 'string', 'min:4'],]);

        $user = Auth::user();

        Auth::logout();

        $user->delete();
        DB::delete('delete from movimentos where conta_id=?',[Auth::user()->id]);
        DB::delete('delete from contas where user_id=?',[Auth::user()->id]);

        DB::delete('delete from autorizacoes_conta where user_id=?',[Auth::user()->id]);

       return redirect('/');
    }

    public function delete(){
        return view('delete');
    }
}
