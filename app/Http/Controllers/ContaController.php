<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Conta;
use App\Movimento;
use App\Autorizacoes_conta;

class ContaController extends Controller
{

    public function softDelete(Conta $conta)
    {
        $id = $conta->id;
        $conta_delete = Conta::where('id', $id);
        $conta_delete->delete();
        Autorizacoes_conta::where('conta_id',$id)->delete();

        Movimento::where('conta_id',$id)->delete();

        return back()->with('message','Successfully deleted! You can still recover your account or permanently delete it!');
    }

    public function restore($conta_id)
    {
        $conta_restore = Conta::withTrashed()->where('id', $conta_id);
        $conta_restore->restore();
        $movimentos_restore = Movimento::withTrashed()->where('conta_id', $conta_id);
        $movimentos_restore->restore();

        return back()->with('message','Successfully recovered!');
    }

    public function destroy($conta_id)
    {
        Autorizacoes_conta::where('conta_id',$conta_id)->forceDelete();
        Movimento::where('conta_id',$conta_id)->forceDelete();
        Conta::where('id', $conta_id)->forceDelete();

        return back()->with('message','Successfully deleted!');
    }


    public function index(){
        $users= User::paginate(5);
        return view('privateArea.contas.addUserToAccount')->withAllUsers($users);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $usersSearch = User::where(function ($query) use($search) {
            $query->where('name','like','%'.$search.'%')
                ->orwhere('email','like','%'.$search.'%');
        });

        return view('privateArea.contas.addUserToAccount')->withAllUsers($usersSearch->paginate(5))
            ->withSearch($search);
    }

    public function updateUser(Request $request){
        $read = $request->get('read');
        $complete = $request->get('complete');
        if($read){
            Autorizacoes_conta::where('user_id',$read)->update(['so_leitura'=> '1']);

            return back()->with('message',"You changed the access type to read only!");
        }

        if($complete){
            Autorizacoes_conta::where('user_id',$complete)->update(['so_leitura'=> '0']);

            return back()->with('message',"You changed the access type to complete!");
        }

        return back();
    }

    public function showManageUsers(Conta $conta){
        $usersDaConta = $conta->autorizacoesUsers()->with('contas')->get();
        return view('privateArea.contas.manageSharedAccounts')->withUsersDaConta($usersDaConta)->withConta($conta);

    }

    public function showForm($conta){

         return view('privateArea.contas.addUser')->withConta($conta);
    }

    public function store(Request $request,$conta){

        $validated = $request->validate( [
            'email'=>['required', 'string', 'email', 'max:255','exists:users'], //verifica se existe
            'type_access'=>['required','integer','digits_between:0,1'],
        ]);

        $type = $validated['type_access'];
        $email = $validated['email'];

        $userID = User::where('email', $email)->first()->id;


        Autorizacoes_conta::create([
            'user_id'=> $userID,
            'conta_id'=>$conta->id,
            'so_leitura'=> $type,
            'deleted_at'=>null
        ])->save(); 

        $user = User::where('email',$email)->first();
        $firstname = head(explode(' ', trim($user->name)));
        $lastname = last (explode(' ', trim($user->name)));

        $usersDaConta = $conta->autorizacoesUsers()->with('contas')->get();

      return redirect()->route('viewManageUsers',['conta'=>$conta])->with('message',"You shared this account with $firstname $lastname successfully!")->withUsersDaConta($usersDaConta)->withConta($conta);
    }

    public function destroyUser(Request $request,$id){
        $delete = $request->get('delete');

        if($delete){
            Autorizacoes_conta::where('conta_id', $id)
            ->where('user_id', $delete)->forceDelete();
        }

        $user = User::where('id',$delete)->first();
        $firstname = head(explode(' ', trim($user->name)));
        $lastname = last (explode(' ', trim($user->name)));

        return back()->with('message',"You removed $firstname $lastname from this account!");
    }
}
