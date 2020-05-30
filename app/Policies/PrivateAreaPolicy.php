<?php

namespace App\Policies;

use App\Conta;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PrivateAreaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function view(User $user,Conta $conta)
    {
        if ($user->id == $conta->user_id){
            return true;
        }


        foreach ($user->autorizacoesContas as $autorizacao){

            if ($autorizacao->pivot->so_leitura == 1){

            }

            if($autorizacao->id == $conta->id && $autorizacao->pivot->so_leitura == 0){
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function details(User $user, Conta $conta)
    {
        if ($user->id == $conta->user_id){
            return true;
        }
        foreach ($user->autorizacoesContas as $autorizacao){


            if($autorizacao->id == $conta->id){
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function delete(User $user, Conta $conta)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function restore(User $user, Conta $conta)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function forceDelete(User $user, Conta $conta)
    {
        //
    }
}
