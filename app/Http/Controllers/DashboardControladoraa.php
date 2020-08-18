<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imagemUser()
    {
        $user = Auth::user();
        return $user;

    }
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);
            return view('Administrativo.dashboard', compact('user', 'consultaPopup'));
        } else {
            return redirect('/login');

        }

    }
    public function indexJsonTipoDeUsuario()
    {
        $result = array();
        //Pegando a quantidade de pessoa de cada tipo
        $tipo_usuario = DB::select('SELECT tipo, COUNT(*) as total FROM condutor GROUP BY tipo');
        $result['tipo_usuario'] = $tipo_usuario;
        //pegando a quantidade de carros cadastrados
        $carros = DB::select("SELECT COUNT(veiculo.tipo_veiculo) as quantidade_carro FROM veiculo WHERE veiculo.tipo_veiculo = ?", ['carro']);
        foreach ($carros as $carro) {
            $result['quantidade_carro'] = $carro->quantidade_carro;
        }

        //pegando a quantidade de moto cadastrados
        $motos = DB::select("SELECT COUNT(veiculo.tipo_veiculo) as quantidade_moto FROM veiculo WHERE veiculo.tipo_veiculo = ?", ['moto']);
        foreach ($motos as $moto) {
            $result['quantidade_moto'] = $moto->quantidade_moto;
        }

        //Tempo medio que um veiculo passou
        $tempo_medio = DB::select("SELECT (SELECT AVG(data_de_criacao) FROM transito WHERE tipo_transito_id_fk = 2) AS a, (SELECT AVG(data_de_criacao) FROM transito WHERE tipo_transito_id_fk = 3) AS b, (SELECT SEC_TO_TIME(b - a)) AS media");
        foreach ($tempo_medio as $media) {
            $result['media'] = $media->media;
        }

        return $result;
    }
    //Função para quantidade de transito por periodo (por mẽs)
    public function indexJsonTransitoPorPeriodo()
    {
        //Select para mostar no grafico de estatistica o transito por MEs
        $resultadoTransitoPorPeriodo = array();
        //pegando o Ano atual
        $dadosAno = date("Y");
        $consultaTransitoPorPeriodo = DB::select('SELECT month(transito.data_de_criacao) as mes, count(transito_id) as total
        FROM transito
        WHERE transito.tipo_transito_id_fk = 2 AND YEAR(transito.data_de_criacao) = ?
        GROUP BY month(transito.data_de_criacao)
        ', [$dadosAno]);
        $resultadoTransitoPorPeriodo['consultaTransitoPorPeriodo'] = $consultaTransitoPorPeriodo;

        return response()->json($resultadoTransitoPorPeriodo);
    }

    public function indexJsonTransitoPorCurso()
    {
        //Select por curso
        $resultadoTransitoPorcurso = array();
        $dadosCursoMes = date("m");

        $consultaTransitoPorCurso = DB::select('SELECT (select condutor.curso_id
        from condutor
        where condutor_id = condutor_id_fk) as curso,
        COUNT(*) as quantidade from transito
        WHERE transito.tipo_transito_id_fk = 2 AND MONTH(transito.data_de_criacao) = ?
        GROUP BY  curso ASC
        ', [$dadosCursoMes]);
        $resultadoTransitoPorcurso['consultaTransitoPorCurso'] = $consultaTransitoPorCurso;

        return response()->json($resultadoTransitoPorcurso);
    }

    public function indexJsonTransitoPorBloco()
    {
        $resultadoTransitoPorBloco = array();
        $dadosBlocoMes = date("m");

        $consultaTransitoPorBloco = DB::select('SELECT (select condutor.pessoa_tipo_id_bd
        from condutor
        where condutor_id = condutor_id_fk) as pessoa_tipo,
        COUNT(*) as quantidade from transito
        WHERE transito.tipo_transito_id_fk = 2 AND MONTH(transito.data_de_criacao) = ?
        GROUP BY  pessoa_tipo ASC', [$dadosBlocoMes]);

        $resultadoTransitoPorBloco['consultaTransitoPorBloco'] = $consultaTransitoPorBloco;

        return response()->json($resultadoTransitoPorBloco);
    }
}
