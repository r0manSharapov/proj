<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Movimento;
use Illuminate\Http\Request;

class MovementsController extends Controller
{
    public function index(Request $request){

        $movimentos = Movimento::where('conta_id', $request->contaId)
                    ->orderBy('data', 'desc')
                    ->paginate(10);



        return view('movements.index')->withMovimentos($movimentos);

    }
}
