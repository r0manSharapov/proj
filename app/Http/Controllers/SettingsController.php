<?php



namespace App\Http\Controllers;


//use App\Rules\MatchOldPassword;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Conta;
use App\Movimento;
use App\Autorizacoes_conta;
use App\User;


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

        User::where('id',Auth::User()->id)
            ->update(
                [
                    'name'=>$name,
                    'email'=>$email,
                    'nif'=>$nif,
                    'telefone'=>$telefone,
                    'foto'=>$foto,
                ]
            );

        Auth::user()->save();

        return back()->with('message','Profile updated');
    }

    public function destroy(Request $request)
    {

        if(!(Hash::check($request->get('password'),Auth::user()->password))){
            return back()->with('error','Incorrect password');
        }

        $user = Auth::user();

        Auth::logout();

        $userID = $user->id;


        $contas = Conta::select('id')
            ->where('user_id',$userID);



        Movimento::whereIn('conta_id',$contas)->delete();

        $contas->delete();
        Autorizacoes_conta::select('conta_id')
            ->where('user_id',$userID)->delete();


        $user->delete();



       return redirect('/');
    }

    public function delete(){

        return view('delete');
    }
}
