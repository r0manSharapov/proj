<?php



namespace App\Http\Controllers;


use Illuminate\Validation\Rule;

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

        return view('settings.index');
    }

    public function store(Request $request, User $user)
    {

        $userID= Auth::id();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userID)],
            'nif' => ['nullable','numeric', 'digits:9', Rule::unique('users', 'nif')->ignore($userID)],
            'telefone' => ['nullable','numeric', 'digits:9', Rule::unique('users', 'telefone')->ignore($userID)]
        ]);

        $name = $validated['name'];
        $email = $validated['email'];
        $nif = $validated['nif'];
        $telefone = $validated['telefone'];

        User::where('id',Auth::User()->id)
            ->update(
                [
                    'name'=>$name,
                    'email'=>$email,
                    'nif'=>$nif,
                    'telefone'=>$telefone,
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

        $userID=$user->id;

        $contas = Conta::
            withTrashed()->where('user_id',$userID)->select('id');

        Movimento::whereIn('conta_id',$contas)->forcedelete();
        Autorizacoes_conta::where('user_id',$userID)->orWhereIn('conta_id',$contas)->forcedelete();


        $contas->forcedelete();
        $user->delete();

       return redirect('/');
    }

    public function delete(){

        return view('settings.delete');
    }
}
