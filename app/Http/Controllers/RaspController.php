<?php

namespace App\Http\Controllers;

use App\Raspberry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RaspController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);
            $consultaTipo = DB::select('SELECT * FROM tipo_raspberry');
            //verificando o nivel de permissao da pessoa logada.
            if ($user->permissao_id_fk == 1 || $user->permissao_id_fk == '1') {
                return view("Administrativo.configuracoes", compact('consultaTipo', 'user', 'consultaPopup'));

            } else {
                return redirect('/admin');

            }
        } else {
            return redirect('/login');

        }

    }

    //Dados dos RaspBerry
    public function raspBerry()
    {
        //Trazendo dos os dados dos RaspBerry do banco de dados
        $raspberry = DB::select('SELECT tipo_raspberry.tipo_rasp_id as id_rasp,tipo_raspberry.nome_tipo_rasp as tipo_raspberry, raspberry_id, raspberry.nome as nome, raspberry.ip as ip FROM raspberry INNER JOIN tipo_raspberry ON raspberry.tipo_id_fk = tipo_raspberry.tipo_rasp_id');

        //Criando dos botões via DataTables, e referenciando aos ID dos RaspBerry
        return DataTables::of($raspberry)
            ->addColumn('action', function ($raspberry) {
                return '<a  onclick="statusRaspBerry(' . $raspberry->raspberry_id . ')" class="ui gren right floated icon button acoes"><i class="eye icon" ></i></a>' .
                '<a  onclick="editarRaspberry(' . $raspberry->raspberry_id . ')" class="ui yellow right floated icon button acoes"><i class="edit icon" ></i></a>' .
                '<a  onclick="deletaRaspBerry(' . $raspberry->raspberry_id . ')" class="ui red right floated icon button acoes"><i class="trash icon" ></i></a>';
            })->make(true);
    }

    public function adicionarRaspBerry(Request $request)
    {
        //Criando dados para a tabela Raspberry
        $adicionarraspberry = Raspberry::create([
            'nome' => $request->nomeRasp,
            'ip' => $request->identificacao,
            'tipo_id_fk' => $request->tipoRasp,

        ]);
        return response()->json($request);
    }

    public function editarRaspBerry($id)
    {
        //Editando dado pelo ID selecionado
        $editardados = Raspberry::join('tipo_raspberry', 'tipo_raspberry.tipo_rasp_id', 'tipo_id_fk')->find($id);
        return $editardados;
    }

    public function atualizarRaspBerry(Request $request)
    {
        //Atualizando dados do RaspBerry
        $atualizardados = Raspberry::find($request->idRasp);
        $atualizardados->nome = $request->nomeRasp;
        $atualizardados->ip = $request->identificacao;
        $atualizardados->tipo_id_fk = $request->tipoRasp;
        $atualizardados->update();

        return $atualizardados;
    }

    public function deletarRaspBerry($id)
    {
        //Apagando usuario pelo ID
        Raspberry::destroy($id);
    }
}
