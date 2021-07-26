<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PerguntaRespondida;

class PerguntasRespondidasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $perguntasRespondidas = PerguntaRespondida::get();
        return view('questoesRespondidas.index', compact('perguntasRespondidas'));
    }
}
