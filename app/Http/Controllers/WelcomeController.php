<?php

namespace App\Http\Controllers;
use App\User;
use App\Conta;
use App\Movimento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalUtilizadores = User::count();
        $totalContas= Conta::count();
        $totalMovimentos=Movimento::count();


        return view('welcome')
            ->withTotalUtilizadores($totalUtilizadores)
            ->withTotalContas($totalContas)
            ->withTotalMovimentos($totalMovimentos);
    }

}
