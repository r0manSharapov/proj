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


        $request->validate(['password' => ['required', 'string', 'min:4'],]);


        $user = Auth::user();

        Auth::logout();

        $userID = $user->id;

       //apagar movimentos feitos por esse user
        DB::table('movimentos')
            ->select('id')
            ->whereIn('conta_id', function($query) use ($userID){
            $query->select('id')
                ->from(DB::table('contas'))
                ->where('user_id', $userID);

        })->delete();

        //apagar contas com esse user
        DB::delete('delete from contas where user_id=?',[$userID]);
        //apagar autorizacoes desse user
        DB::delete('delete from autorizacoes_contas where user_id=?',[$userID]);
        //apagar o user

        $user->delete();



       return redirect('/');
    }

    public function delete(){

        return view('delete');
    }
}
