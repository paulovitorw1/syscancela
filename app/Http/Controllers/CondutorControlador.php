<?php

namespace App\Http\Controllers;

use App\Condutor;
use App\Veiculo;
use App\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;
use Yajra\DataTables\Facades\DataTables;

class CondutorControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexCadastro()
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);

            return view("Administrativo.cadastro-condutores", compact('user', 'consultaPopup'));
        } else {
            return redirect('/login');

        }

    }

    public function indexListagem()
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);

            return view('Administrativo.cadastro-condutor-listagem', compact('user', 'consultaPopup'));
        } else {
            return redirect('/login');

        }
    }

    public function indexJsonListagem()
    {
        $condutor = Condutor::select('condutor_id', 'nome', 'identificacao as matricula', 'setor_curso')->get();

        //Criando dos botões via DataTables, e referenciando aos ID dos RaspBerry
        return DataTables::of($condutor)
            ->addColumn('action', function ($condutor) {
                return

                '<a  onclick="statuscondutor(' . $condutor->condutor_id . ')"  class="ui gren right floated icon button acoes"><i class="eye icon" ></i></a>' .
                '<a  onclick="editarcondutor(' . $condutor->condutor_id . ')"  class="ui yellow right floated icon button acoes"><i class="edit icon" ></i></a>' .
                '<a  onclick="deletacondutor(' . $condutor->condutor_id . ')"  class="ui red right floated icon button acoes"><i class="trash icon" ></i></a>';
            })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $response = array();

        //verifica se é um condutor que está inativo ou não
        $condutor_cadastrado = DB::select('SELECT COUNT(*) as qtd_condutor FROM condutor WHERE identificacao = :identificacao and data_de_exclusao is NOT NULL', ['identificacao' => $request->identificacao_pessoa]);

        //caso não existir um registro correspondente.
        if (($condutor_cadastrado[0]->qtd_condutor == 0 || $condutor_cadastrado[0]->qtd_condutor == null)) {
            $this->validacaoForm($request);

            if ($request->tipo_pessoa == 'Visitante') {
                //cadastro de visitante
                $createCondutor = Condutor::create([
                    'nome' => $request->nome_pessoa,
                    'tipo' => $request->tipo_pessoa,
                    'setor_curso' => $request->curso_pessoa,
                    'identificacao' => $request->identificacao_pessoa,
                    'cpf' => CondutorControlador::mask($request->identificacao_pessoa, '###.###.###-##'),
                    'numero_cartao' => $request->numero_cartao,
                    'imagem_condutor' => $request->identificacao_pessoa . ".jpg",
                    'telefone' => $request->telefone_pessoa,
                    'email' => $request->email_pessoa,
                ])->condutor_id;

                //manipulação da data do prazo_final para cadastro
                $ano = substr($request->prazo_final, 6, 4);
                $mes = substr($request->prazo_final, 3, 2);
                $dia = substr($request->prazo_final, 0, 2);
                $hora = substr($request->prazo_final, 11, 5);
                $dataFormatada = $ano . '-' . $mes . '-' . $dia . ' ' . $hora;

                //populando os dados para o visitante
                $createVisitante = Visitante::create([
                    'motivo' => $request->motivo,
                    'condutor_id_fk' => $createCondutor,
                    'prazo_final' => $dataFormatada,
                ]);
            } else {
                //cadastro de pessoa
                $createCondutor = Condutor::create([
                    'nome' => $request->nome_pessoa,
                    'tipo' => $request->tipo_pessoa,
                    'setor_curso' => $request->curso_pessoa,
                    'curso_id' => $request->curso_id,
                    'pessoa_tipo_id_bd' => $request->pessoa_tipo_id,
                    'identificacao' => $request->identificacao_pessoa,
                    'cpf' => $request->cpf_pessoa,
                    'numero_cartao' => $request->numero_cartao,
                    'imagem_condutor' => $request->identificacao_pessoa . ".jpg",
                    'telefone' => $request->telefone_pessoa,
                    'email' => $request->email_pessoa,
                ])->condutor_id;
            }

            $detalhesFile = json_decode($request->detalhesFile);
            $count = 0;

            //upload das imagens dos veiculos na pasta
            if ($request->hasFile('uploadFile')) {
                foreach ($request->file('uploadFile') as $arquivo) {
                    $image = $arquivo;
                    $name = $request->identificacao_pessoa . "_" . $count . "_" . date("dmY") . "." . $image->getClientOriginalExtension();
                    $destinationPath = public_path('images');

                    if ($image->move($destinationPath, $name)) {
                        $imageUpDB = Veiculo::create([
                            "condutor_id_fk" => $createCondutor,
                            "tipo_veiculo" => $detalhesFile[$count]->veiculo,
                            "placa" => $detalhesFile[$count]->placa,
                            "cor" => $detalhesFile[$count]->cor,
                            "marca" => $detalhesFile[$count]->marca,
                            "modelo" => $detalhesFile[$count]->modelo,
                            "ano" => $detalhesFile[$count]->ano,
                            "img_veiculo" => $name,
                        ]);
                        $count++;
                    }
                }

                $response = ['sucesso' => 'Condutor cadastrado com sucesso!'];
            }
        } else {
            //validação do formulário
            $this->validacaoFormEdit($request);

            //se o condutor tiver "oculto" pelo softDelete, restauro o resgitro
            $restore = Condutor::withTrashed()->where('identificacao', $request->identificacao_pessoa)->restore();

            //atualizar dados do visitante
            if ($request->tipo_pessoa == 'Visitante') {
                //atualizar os dados do condutor
                $update = Condutor::where('identificacao', $request->identificacao_pessoa)->update([
                    'nome' => $request->nome_pessoa,
                    'tipo' => $request->tipo_pessoa,
                    'setor_curso' => $request->curso_pessoa,
                    'identificacao' => $request->identificacao_pessoa,
                    'cpf' => CondutorControlador::mask($request->identificacao_pessoa, '###.###.###-##'),
                    'numero_cartao' => $request->numero_cartao,
                    'imagem_condutor' => $request->identificacao_pessoa . ".jpg",
                    'telefone' => $request->telefone_pessoa,
                    'email' => $request->email_pessoa,
                ]);

                //buscando os id do condutor
                $condutor_id = Condutor::select('condutor_id')->where('identificacao', $request->identificacao_pessoa)->get();

                //manipulação da data do prazo_final para cadastro
                $ano = substr($request->prazo_final, 6, 4);
                $mes = substr($request->prazo_final, 3, 2);
                $dia = substr($request->prazo_final, 0, 2);
                $hora = substr($request->prazo_final, 11, 5);
                $dataFormatada = $ano . '-' . $mes . '-' . $dia . ' ' . $hora;

                //populando os dados para o visitante
                $updateVisitante = Visitante::where('condutor_id_fk', $condutor_id[0]->condutor_id)->update([
                    'motivo' => $request->motivo_pessoa,
                    'condutor_id_fk' => $condutor_id[0]->condutor_id,
                    'prazo_final' => $dataFormatada,
                ]);
            } else {
                $update = Condutor::where('identificacao', $request->identificacao_pessoa)->update([
                    'nome' => $request->nome_pessoa,
                    'tipo' => $request->tipo_pessoa,
                    'setor_curso' => $request->curso_pessoa,
                    'curso_id' => $request->curso_id,
                    'pessoa_tipo_id_bd' => $request->pessoa_tipo_id,
                    'identificacao' => $request->identificacao_pessoa,
                    'cpf' => $request->cpf_pessoa,
                    'numero_cartao' => $request->numero_cartao,
                    'imagem_condutor' => $request->identificacao_pessoa . ".jpg",
                    'telefone' => $request->telefone_pessoa,
                    'email' => $request->email_pessoa,
                ]);
            }
            //buscando os id do condutor
            $condutor_veiculo = Condutor::select('condutor_id')->where('identificacao', $request->identificacao_pessoa)->get();

            //buscando os veiculos antigos do condutor
            $veiculos = DB::select('SELECT * FROM veiculo where condutor_id_fk = ?', [$condutor_veiculo[0]->condutor_id]);

            //deletando os arquivos antigos
            foreach ($veiculos as $imagem_antigas_veiculo) {
                unlink(public_path('images') . '/' . $imagem_antigas_veiculo->img_veiculo);
                Veiculo::destroy($imagem_antigas_veiculo->veiculo_id);
            }

            //atualizar os dados dos veiculos
            $detalhesFile = json_decode($request->detalhesFile);
            $count = 0;

            if ($request->hasFile('uploadFile')) {
                foreach ($request->file('uploadFile') as $arquivo) {
                    $image = $arquivo;
                    $name = $request->identificacao_pessoa . "_" . $count . "_" . date("dmY") . "." . $image->getClientOriginalExtension();
                    $destinationPath = public_path('images');

                    if ($image->move($destinationPath, $name)) {
                        $imageUpDB = Veiculo::create([
                            "condutor_id_fk" => $condutor_veiculo[0]->condutor_id,
                            "tipo_veiculo" => $detalhesFile[$count]->veiculo,
                            "placa" => $detalhesFile[$count]->placa,
                            "cor" => $detalhesFile[$count]->cor,
                            "marca" => $detalhesFile[$count]->marca,
                            "modelo" => $detalhesFile[$count]->modelo,
                            "ano" => $detalhesFile[$count]->ano,
                            "img_veiculo" => $name,
                        ]);
                        $count++;
                    }
                }
                $response = ['sucesso' => 'Condutor cadastrado com sucesso!'];
            }
        }
        return response()->json($response);
    }

    public function validacaoForm(Request $request)
    {
        if ($request->tipo_pessoa == 'Visitante') {
            return $this->validate($request, [
                'identificacao_pessoa' => 'required|numeric',
                'nome_pessoa' => 'required|string|max:50',
                'telefone_pessoa' => 'required|string',
                'numero_cartao' => ['required', 'numeric', Rule::unique('condutor', 'numero_cartao')->where('numero_cartao', $request->numero_cartao)->whereNull("data_de_exclusao")],
                'tipo_pessoa' => 'required|string',
                'email_pessoa' => 'required|email',
                'imagem_pessoa' => 'required',
                'motivo' => 'required|string',
                'prazo_final' => 'required',
            ]);
        } else {
            return $this->validate($request, [
                'identificacao_pessoa' => 'required|numeric',
                'nome_pessoa' => 'required|string|max:50',
                'curso_pessoa' => 'required|min:3|string|max:50',
                'telefone_pessoa' => 'required|string',
                'numero_cartao' => ['required', 'numeric', Rule::unique('condutor', 'numero_cartao')->where('numero_cartao', $request->numero_cartao)->whereNull("data_de_exclusao")],
                'tipo_pessoa' => 'required|string',
                'cpf_pessoa' => 'required|string',
                'email_pessoa' => 'required|email',
                'imagem_pessoa' => 'required',
            ]);
        }
    }

    public function validacaoFormEdit(Request $request)
    {
        if ($request->tipo_pessoa == 'Visitante') {
            return $this->validate($request, [
                'identificacao_pessoa' => 'required|numeric',
                'nome_pessoa' => 'required|string|max:50',
                'telefone_pessoa' => 'required|string',
                'numero_cartao' => ['required', 'numeric', Rule::unique('condutor', 'numero_cartao')->ignore($request->identificacao_pessoa, 'identificacao')->where('numero_cartao', $request->numero_cartao)->whereNotNull("data_de_exclusao")],
                'tipo_pessoa' => 'required|string',
                'email_pessoa' => 'required|email',
                'imagem_pessoa' => 'required',
                'motivo' => 'required|string',
                'prazo_final' => 'required',
            ]);
        } else {
            return $this->validate($request, [
                'identificacao_pessoa' => 'required|numeric',
                'nome_pessoa' => 'required|string|max:50',
                'curso_pessoa' => 'required|min:3|string|max:50',
                'telefone_pessoa' => 'required|string',
                'numero_cartao' => ['required', 'numeric', Rule::unique('condutor', 'numero_cartao')->ignore($request->identificacao_pessoa, 'identificacao')->where('numero_cartao', $request->numero_cartao)->whereNotNull("data_de_exclusao")],
                'tipo_pessoa' => 'required|string',
                'cpf_pessoa' => 'required|string',
                'email_pessoa' => 'required|email',
                'imagem_pessoa' => 'required',
            ]);
        }
    }

    public function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }

            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }

            }
        }
        return $maskared;
    }

    public function buscar_registro()
    {
        # code...
    }

    public function buscaButton(Request $request)
    {
        $pesquisa = array();
        $pesquisa['suggestions'] = DB::connection('bancoCentral')->table('pessoa')
            ->select('pessoa.nome', 'pessoa.pessoa_id')
            ->join('pessoa_identificacao', 'pessoa_identificacao.pessoa_id_fk', 'pessoa.pessoa_id')
            ->selectRaw("GROUP_CONCAT(DISTINCT(pessoa_identificacao.identificacao) SEPARATOR ' / ') as identificacao")
            ->where('nome', 'like', '%' . $request->data . '%')
            ->orwhere('identificacao', 'like', '%' . $request->data . '%')
            ->orwhere('numero_cartao', 'like', '%' . ltrim($request->data, "0") . '%')
            ->orwhere('email', 'like', '%' . $request->data . '%')
            ->orwhere('cpf', 'like', '%' . $request->data . '%')
            ->groupBy('pessoa.nome', 'pessoa.pessoa_id')
            ->get();
        $pesquisa = CondutorControlador::conversaoUTF8($pesquisa);
        return $pesquisa;
    }

    //
    public static function conversaoUTF8($data)
    {
        if (is_string($data)) {
            return utf8_encode($data);
        } elseif (is_array($data)) {
            $ret = [];
            foreach ($data as $i => $d) {
                $ret[$i] = self::conversaoUTF8($d);
            }
            return $ret;
        } elseif (is_object($data)) {
            foreach ($data as $i => $d) {
                $data->$i = self::conversaoUTF8($d);
            }
            return $data;
        } else {
            return $data;
        }
    }

    /**
     * Busca no Banco Central os dados da pessoa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function buscarDadosCondutor(Request $request)
    {
        $idenficacao = $request->identificacao;

        $pessoa = DB::connection('bancoCentral')->select('SELECT
        pessoa_identificacao.identificacao as pessoa_identificacao,curso.curso_id,pessoa_tipo.pessoa_tipo_id,
        pessoa.numero_cartao,
        pessoa.nome,
        pessoa.email,
        pessoa.celular,
        pessoa.cpf,
        pessoa.identidade,
        pessoa.status,
        visitante.prazo_final,
        visitante.motivo,
        pessoa_tipo.attr as pessoa_tipo,
        setor.nome as nome_setor,
        curso.nome as nome_curso
        FROM pessoa
        LEFT JOIN pessoa_identificacao ON pessoa_identificacao.pessoa_id_fk = pessoa.pessoa_id
        LEFT JOIN pessoa_tipo_categoria as pessoaTipoCat ON pessoaTipoCat.pessoa_identificacao_id_fk = pessoa_identificacao.pessoa_identificacao_id
        LEFT JOIN pessoa_identificacao_categoria ON pessoa_identificacao_categoria.pessoa_identificacao_id_fk = pessoa_identificacao.pessoa_identificacao_id
        LEFT JOIN aluno ON aluno.pessoa_identificacao_id_fk = pessoa_identificacao.pessoa_identificacao_id
        LEFT JOIN mestrado ON mestrado.pessoa_identificacao_id_fk = pessoa_identificacao.pessoa_identificacao_id
        LEFT JOIN estagiario estagiario ON estagiario.pessoa_identificacao_id_fk = pessoa_identificacao.pessoa_identificacao_id
        LEFT JOIN servidor servidor ON servidor.pessoa_identificacao_id_fk = pessoa_identificacao.pessoa_identificacao_id
        LEFT JOIN terceirizado ON terceirizado.pessoa_identificacao_id_fk = pessoa_identificacao.pessoa_identificacao_id
        LEFT JOIN visitante visitante ON visitante.pessoa_identificacao_id_fk = pessoa_identificacao.pessoa_identificacao_id
        LEFT JOIN pessoa_tipo ON pessoa_tipo.pessoa_tipo_id = pessoa_identificacao.tipo_pessoa_id_fk
        LEFT JOIN setor ON setor.setor_id = pessoa_identificacao_categoria.setor_id_fk
        LEFT JOIN curso ON curso.curso_id = aluno.curso_id
        WHERE pessoa_identificacao.identificacao = :identificacao
        ORDER BY tipo_pessoa_id_fk ASC', ['identificacao' => $idenficacao]);

        $pessoa = CondutorControlador::conversaoUTF8($pessoa);

        return response()->json($pessoa);
    }

    /**
     * Validação do formulário veiculos com validate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function validacaoFormVeiculos(Request $request)
    {
        //regras do validator.
        $validator = \Validator::make($request->all(), [
            'marca' => 'required|max:30|min:3',
            'placa' => 'required|max:20|min:6|alpha_dash',
            'modelo' => 'required|max:30|min:3',
            'tipo_veiculo' => 'required',
            'cor' => 'required|string',
            'ano' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        //caso houver falha na validações.
        if ($validator->fails()) {
            //retorna uma requisição com o erros daquele name.
            return response()->json(["erros" => $validator->errors()]);
        }
    }

    //função para mudar o status do condutor. caso ele tenha "data_de_exclusao" ele esta inativo.
    public function destroyListagem(Request $request)
    {
        //fazendo update da coluna data_de_exclusao.
        $data = Condutor::where('condutor_id', $request->id)->update(['data_de_exclusao' => now()]);
        if ($data) {
            return response()->json(['deletado' => 'Deletado com sucesso']);
        }
    }

    //Função para retorna a view de editar condutor
    public function getViewEdit($idCondutor)
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);
            //consulta para pegar os dados do condutor
            $getCondutor = Condutor::where("condutor_id", $idCondutor)->get();
            //consulta para pegar os dados dos veiculos
            $getVeiculoByCondutor = Veiculo::where("condutor_id_fk", $idCondutor)->get();
            //Retornando a view e compactando as variaveis das consulta pra ser usadas na view;
            return response()->view('Administrativo.editar-condutor', compact('getCondutor', 'getVeiculoByCondutor', 'getVisitante', 'user', 'consultaPopup'));
        } else {
            return redirect('/login');

        }

    }

    //Função para trazer os dados do condutor pelo ID
    public function getCondutor($idCondutor)
    {
        //conulsta
        $getCondutor = Condutor::where("condutor_id", $idCondutor)->get();
        return response()->json($getCondutor);
    }

    //Trazendo os dados do condutor para a tala de visualizar
    public function getCondutorVisualizar($idCondutor)
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);

            $getCondutor = Condutor::where("condutor_id", $idCondutor)->get();
            $getVeiculoByCondutor = Veiculo::where("condutor_id_fk", $idCondutor)->get();

            if ($getCondutor[0]->tipo == 'Visitante') {
                $getVisitante = Visitante::where("condutor_id_fk", $idCondutor)->get();
            }

            return view('Administrativo.visualizarCondutor-dados', compact('getCondutor', 'getVeiculoByCondutor', 'getVisitante', 'user', 'consultaPopup'));
        } else {
            return redirect('/login');

        }

    }

    //Cadastrando um novo veiculo pela tela de Edição
    public function novoVeiculoTelaDeEditar(Request $request)
    {
        //pegando o id do condutor
        $idCondutor = $request->condutor_idEdit;
        //Imagem
        $uploadnameNovo = "";
        //verificando se tem alguma coisa na input do upload
        if ($request->hasFile('upload_file')) {
            //pegando o falor que tem na input
            $image = $request->file('upload_file');
            //recuperando a extensao do arquivo e nomeando com a data
            $uploadnameNovo = time() . '.' . $image->getClientOriginalExtension();
            //salvando na pasta /images
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $uploadnameNovo);

        }
        //
        $cadastrarVeiculo = Veiculo::create([
            'condutor_id_fk' => $idCondutor,
            'tipo_veiculo' => $request->tipo_veiculo_novo,
            'modelo' => $request->modelo_novo,
            'cor' => $request->cor_novo,
            'placa' => $request->placa_novo,
            'marca' => $request->marca_novo,
            'ano' => $request->ano_novo,
            'img_veiculo' => $uploadnameNovo,

        ]);

        return response()->json($cadastrarVeiculo);

    }
    //Função para pegar os valores dos veiculos do condutor, referente ao id passado pela rota
    public function getEditarVeiculoCondutor($idCondutor)
    {
        //Consulta
        $getVeiculoByCondutor = DB::select('SELECT * FROM veiculo WHERE veiculo.veiculo_id = ?', [$idCondutor]);
        return response()->json($getVeiculoByCondutor);

    }

    //Função para atualizar os dados do veiculo
    public function atualizarVeiculoCondutor(Request $request)
    {

        //Imagem
        //pegando o valor da input onde a imagem ta.
        $uploadname = $request->nomeimg;
        if ($request->hasFile('uploaded_file')) {
            $image = $request->file('uploaded_file');
            $uploadname = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $uploadname);
        }

        //Dados do Veiculo do Condutor
        $atualizardados = Veiculo::find($request->idVeiculoCondutor);
        $atualizardados->tipo_veiculo = $request->tipo_veiculo_edit;
        $atualizardados->placa = $request->placa_edit;
        $atualizardados->cor = $request->cor_edit;
        $atualizardados->modelo = $request->modelo_edit;
        $atualizardados->ano = $request->ano_edit;
        $atualizardados->marca = $request->marca_edit;
        $atualizardados->img_veiculo = $uploadname;

        $atualizardados->update();

        return $atualizardados;
    }
    //Função para apagar um veiculo pelo ID passado por rota
    public function deletaVeiculoCondutor($id)
    {
        Veiculo::destroy($id);

    }
}
