<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class CancelasController extends Controller
{
    //variaveis privadas.
    private $usuario, $senha;

    public function __construct()
    {
        $this->usuario = "sysc@nc3l@_sup0rt3";
        $this->senha = "c@nc3l@_sup0rt3";
    }

    public function cancelaEntrada(Request $request)
    {
        $response = array();
        //verificando se as credenciais é igual as que estão nas variaveis
        if ($request->usuario != $this->usuario || $request->senha != $this->senha) {

            return redirect('/');

        } else {
            return view('Cancelas.entrada', compact('user', 'consultaPopup'));
        }
    }

    public function cancelaSaida(Request $request)
    {
        $response = array();
        if ($request->usuario != $this->usuario || $request->senha != $this->senha) {
            return redirect('/');

        } else {
        return view('Cancelas.saida', compact('user', 'consultaPopup'));
}
        // return response()->json($response);
    }
    //view cancela entrada
    // public function cancelaEntrada()
    // {
    //     // if (Auth::check()) {
    //     $user = Auth::user();
    //     //pegando apenas o id do Usuario logado
    //     // $idLogado = Auth::user()->id;
    //     //consultando permissao do usuario que ta logado
    //     // $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?');
    //     return view('Cancelas.entrada', compact('user', 'consultaPopup'));
    //     // } else {
    //     //     return redirect('/login');

    //     // }
    // }

    // public function cancelaSaida()
    // {
    //     // if (Auth::check()) {
    //     $user = Auth::user();
    //     //pegando apenas o id do Usuario logado
    //     // $idLogado = Auth::user()->id;
    //     //consultando permissao do usuario que ta logado
    //     // $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);
    //     return view('Cancelas.saida', compact('user', 'consultaPopup'));
    //     // } else {
    //     //     return redirect('/login');

    //     // }
    // }
}
