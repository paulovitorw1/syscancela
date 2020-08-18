<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RegistroControlador extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);
            $consultaTipoTransito = DB::select('SELECT * FROM tipo_transito');
            //Retorna a View Registros
            return view('Administrativo.registros', compact('consultaTipoTransito', 'user', 'consultaPopup'));
        } else {
            return redirect('/login');

        }

    }

    public function indexJson()
    {
        $registro = DB::select('SELECT
        transito.transito_id, condutor.nome, condutor.tipo, condutor.identificacao, condutor.setor_curso as curos_setor,condutor.email,
        condutor.telefone, veiculo.veiculo_id, veiculo.marca, veiculo.modelo, veiculo.ano, veiculo.placa, tipo_transito.descricao_tipo_transito,
        transito.tipo_transito_id_fk as transitoTipo, DATE_FORMAT(transito.data_de_criacao, "%d/%m/%Y") AS dataDoTransito FROM transito
        LEFT JOIN veiculo ON transito.veiculo_id_fk = veiculo.veiculo_id
        INNER JOIN tipo_transito ON transito.tipo_transito_id_fk = tipo_transito.tipo_transito_id
        INNER JOIN condutor ON transito.condutor_id_fk = condutor.condutor_id ORDER BY transito.data_de_criacao DESC');

        return Datatables::of($registro)
            ->addColumn('action', function ($registro) {
                return '<a onclick="dadosDoCondutor(' . $registro->transito_id . ', ' . $registro->veiculo_id . ')" class="ui icon  button" id="icon_vieww" target="_blank" ><i class="eye icon" id="icon_view"></i></a>';
            })
            ->make(true);
    }
    public function indexJsonModal(Request $request)
    {
        $ValorTransito = $request->id_transito;
        $consultaRegistro = DB::select('SELECT transito.transito_id, condutor.nome, condutor.tipo, condutor.identificacao,
        condutor.setor_curso as curos_setor,condutor.email, condutor.telefone, veiculo.veiculo_id,
        veiculo.img_veiculo,  veiculo.marca, veiculo.modelo, veiculo.ano, veiculo.placa, tipo_transito.descricao_tipo_transito,
        transito.tipo_transito_id_fk as transitoTipo, transito.data_de_criacao as dataDoTransito
        FROM transito LEFT JOIN veiculo ON transito.veiculo_id_fk = veiculo.veiculo_id
        INNER JOIN tipo_transito ON transito.tipo_transito_id_fk = tipo_transito.tipo_transito_id
        INNER JOIN condutor ON transito.condutor_id_fk = condutor.condutor_id
        WHERE transito.transito_id = ?', [$ValorTransito]);

        return ($consultaRegistro);
    }
    public function carregarTipoRegistro(Request $request)
    {
        $valorTipoTransito = $request->valorTipoTranstio;
        if ($valorTipoTransito == 1) {
            $consultaTipoTransito = DB::select('SELECT
            transito.transito_id, condutor.nome, condutor.tipo, condutor.identificacao, condutor.setor_curso as curos_setor,condutor.email,
            condutor.telefone, veiculo.veiculo_id, veiculo.marca, veiculo.modelo, veiculo.ano, veiculo.placa, tipo_transito.descricao_tipo_transito,
            transito.tipo_transito_id_fk as transitoTipo, transito.data_de_criacao as dataDoTransito
            FROM transito
            LEFT JOIN veiculo ON transito.veiculo_id_fk = veiculo.veiculo_id
            INNER JOIN tipo_transito ON transito.tipo_transito_id_fk = tipo_transito.tipo_transito_id
            INNER JOIN condutor ON transito.condutor_id_fk = condutor.condutor_id ORDER BY dataDoTransito DESC');

            return Datatables::of($consultaTipoTransito)
                ->addColumn('action', function ($consultaTipoTransito) {
                    return '<a onclick="dadosDoCondutor(' . $consultaTipoTransito->transito_id . ', ' . $consultaTipoTransito->veiculo_id . ')" class="ui icon  button" id="icon_vieww" target="_blank" ><i class="eye icon" id="icon_view"></i></a>';
                })
                ->make(true);

        } else {

            $consultaTipoTransito = DB::select('SELECT
            transito.transito_id, condutor.nome, condutor.tipo, condutor.identificacao, condutor.setor_curso as curos_setor,condutor.email,
            condutor.telefone, veiculo.veiculo_id, veiculo.marca, veiculo.modelo, veiculo.ano, veiculo.placa, tipo_transito.descricao_tipo_transito,
            transito.tipo_transito_id_fk as transitoTipo, transito.data_de_criacao as dataDoTransito
            FROM transito
            LEFT JOIN veiculo ON transito.veiculo_id_fk = veiculo.veiculo_id
            INNER JOIN tipo_transito ON transito.tipo_transito_id_fk = tipo_transito.tipo_transito_id
            INNER JOIN condutor ON transito.condutor_id_fk = condutor.condutor_id  WHERE transito.tipo_transito_id_fk = ?
            ', [$valorTipoTransito]);
        }

        return Datatables::of($consultaTipoTransito)
            ->addColumn('action', function ($consultaTipoTransito) {
                return '<a onclick="dadosDoCondutor(' . $consultaTipoTransito->transito_id . ', ' . $consultaTipoTransito->veiculo_id . ')" class="ui icon  button" id="icon_vieww" target="_blank" ><i class="eye icon" id="icon_view"></i></a>';
            })
            ->make(true);
    }
    // public function consultaPorData(Request $request)
    // {

    //     $dataDeEntrada = $request->dataDeEntrada;
    //     $dataDeSaida =  $request->dataDeSaida;
    //     $stringDataDeEntrada = $request->dataDeEntrada . '%';
    //     $stringDataDeSaida = $request->dataDeSaida . '%';
    //     if ($dataDeEntrada != null && $dataDeSaida == null) {
    //         $consultaDataEntrada = DB::select('SELECT
    //         tipo_transito.descricao_tipo_transito,
    //         condutor.setor_curso as curos_setor,
    //         transito.id_tipo_transito_fk as transitoTipo,
    //         transito.data_de_criacao as dataDoTransito, condutor.nome,
    //         condutor.tipo, condutor.identificacao, condutor.telefone,
    //         condutor.email, veiculo.marca,
    //         veiculo.modelo, veiculo.ano, veiculo.placa,
    //         transito.transito_id
    //         FROM transito
    //         INNER JOIN veiculo ON transito.veiculo_id = veiculo.veiculo_id
    //         INNER JOIN tipo_transito ON transito.id_tipo_transito_fk = tipo_transito.id_tipo_transito
    //         INNER JOIN condutor ON veiculo.condutor_id = condutor.condutor_id
    //         WHERE transito.data_de_criacao LIKE ?', [$stringDataDeEntrada]);

    //         return Datatables::of($consultaDataEntrada)
    //             ->addColumn('action', function ($consultaDataEntrada) {
    //                 return '<a onclick="" class="ui icon  button" id="icon_vieww" target="_blank" ><i class="eye icon" id="icon_view"></i></a>';
    //             })
    //             ->make(true);
    //     } else if ($dataDeSaida != null && $dataDeEntrada == null) {
    //         $consultaDataSaida = DB::select('SELECT tipo_transito.descricao_tipo_transito,
    //         condutor.setor_curso as curos_setor,
    //         transito.id_tipo_transito_fk as transitoTipo, transito.data_de_criacao as dataDoTransito,
    //         condutor.nome, condutor.tipo, condutor.identificacao, condutor.telefone,
    //         condutor.email, veiculo.marca, veiculo.modelo, veiculo.ano, veiculo.placa,
    //         transito.transito_id
    //         FROM transito
    //         INNER JOIN veiculo ON transito.veiculo_id = veiculo.veiculo_id
    //         INNER JOIN tipo_transito ON transito.id_tipo_transito_fk = tipo_transito.id_tipo_transito
    //         INNER JOIN condutor ON veiculo.condutor_id = condutor.condutor_id
    //         WHERE transito.data_de_criacao LIKE ?', [$stringDataDeSaida]);

    //         return Datatables::of($consultaDataSaida)
    //             ->addColumn('action', function ($consultaDataSaida) {
    //                 return '<a onclick="" class="ui icon  button" id="icon_vieww" target="_blank" ><i class="eye icon" id="icon_view"></i></a>';
    //             })
    //             ->make(true);
    //     } else if($stringDataDeEntrada != null && $stringDataDeSaida != null) {
    //         dd("deu bom");
    //     }else{
    //         dd("aqui deu erro");
    //     }
    // }
}
