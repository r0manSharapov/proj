<?php

namespace App\Http\Controllers;

use App\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\User;


class PrivateAreaController extends Controller
{
    public function index(){
        $contas = Conta::all();
        return view('privateArea.index')->withContas($contas);
    }


    public function store($request){

        $request->validate([
            'name'=>['required'],
            'startBalance'=>['required']

        ]);

    }

}
