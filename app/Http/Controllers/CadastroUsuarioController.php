<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;
use Yajra\DataTables\Facades\DataTables;

class CadastroUsuarioController extends Controller
{
    //Retornando a view e fazendo a verificação de login
    public function indexUser()
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);
            //consultando todas as permissao para cadastro
            $consultaPermissao = DB::select('SELECT * FROM permissao');
            //verificando o nivel de permissao da pessoa logada
            if ($user->permissao_id_fk == 1 || $user->permissao_id_fk == '1') {
                return view('Administrativo.usuario', compact('user', 'consultaPermissao', 'consultaPopup'));

            } else {
                return redirect('/admin');

            }

        } else {
            return redirect('/');
        }
    }
    public function listarUsuarios()
    {
        $consultaUsuarios = DB::select('SELECT id as usuario_id, nome, email, identificacao, permissao_id_fk, data_de_criacao, ultima_atualizacao FROM users');

        //Criando dos botões via DataTables, e referenciando aos ID dos usuarios
        return DataTables::of($consultaUsuarios)
            ->addColumn('action', function ($consultaUsuarios) {
                return
                '<a  onclick="vizualizarUsuario(' . $consultaUsuarios->usuario_id . ')"  class="ui gren right floated icon button acoes"><i class="eye icon" ></i></a>' .
                '<a  onclick="editarUsuario(' . $consultaUsuarios->usuario_id . ')"  class="ui yellow right floated icon button acoes"><i class="edit icon" ></i></a>' .
                '<a  onclick="deletaUsuario(' . $consultaUsuarios->usuario_id . ')"  class="ui red right floated icon button acoes"><i class="trash icon" ></i></a>';
            })->make(true);
    }

    public function cadastrarUsuario(Request $request)
    {
        //validação
        $this->validate($request, [
            'identificacao' => 'required|min:5|max:20|unique:users',
            'nome' => 'required',
            'email' => 'required|email|unique:users',
            'permissao' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',

        ]);
        //Criando dados para a Table Users
        $cadastrarUsuario = User::create([
            'nome' => $request->nome,
            'identificacao' => $request->identificacao,
            'permissao_id_fk' => $request->permissao,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json($cadastrarUsuario);
    }
    //consulta no banco, trazendo o nome da permissao.
    public function editarUsuario($id)
    {
        //Editando dados pelo ID selecionado(Consulta)
        $editardados = User::join('permissao', 'permissao.permissao_id', 'permissao_id_fk')->find($id);
        return $editardados;
    }
    //Atualizando os dados do condutor.
    public function atualizarDadosUser(Request $request)
    {

        $idUss = $request->idUser;
        $senha = $request->password;
        //validandos os dados inseridos
        $this->validate($request, [
            'identificacao' => 'required|min:5',
            'nome' => 'required',
            'email' => 'required|email',
            'permissao' => 'required',
            'password' => isset($senha) ? 'required|confirmed|min:6' : 'nullable',
        ]);
        //Atualizando pelo ID passado
        $atualizardados = User::find($request->idUser);
        $atualizardados->nome = $request->nome;
        $atualizardados->identificacao = $request->identificacao;
        $atualizardados->permissao_id_fk = $request->permissao;
        $atualizardados->email = $request->email;
        if (isset($senha)) {
            $atualizardados->password = bcrypt($request->password);
        }

        $atualizardados->update();
        return $atualizardados;
    }
    public function deleteUsers($id)
    {
        $idUserLogado = Auth::user()->id;
        $idUserDelete = $id;
        $respose = array();
        //verficando se o ID que o User está logado é igual ao clicado para deletar.
        if ($idUserLogado != $idUserDelete) {
            User::destroy($id);
            $respose['sucesso'] = "Usuário excluído com sucesso !";

        } else {
            $respose['errorUser'] = "Você não pode apagar o seu proprío usuário !";

        }

        return response()->json($respose);

    }

}
