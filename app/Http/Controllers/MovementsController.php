<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;

class MovementsController extends Controller
{
    public function index(){
        $movimentos = Movimento::pluck('conta_id', 'data', 'valor', 'tipo');

        return view('movements.index')->whihMovimentos($movimentos);
    }
}
