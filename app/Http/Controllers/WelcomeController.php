<?php

namespace App\Http\Controllers;


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
        $totalUtilizadores = DB::table('users')->count();
        $totalContas= DB::table('contas')->where('deleted_at',null)->count();
        $totalMovimentos=DB::table('movimentos')->count();


        return view('welcome')
            ->withTotalUtilizadores($totalUtilizadores)
            ->withTotalContas($totalContas)
            ->withTotalMovimentos($totalMovimentos);
    }

}
