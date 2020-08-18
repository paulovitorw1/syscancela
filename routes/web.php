<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/****************** Rotas do LOGIN *******************/

Route::get('/', function () {
    return redirect('/login');
});

/****************** Rotas das CANCELAS *******************/
Route::group(['prefix' => 'cancela'], function () {
    //Rota para a cencela ENTRADA
    Route::get('/entrada', 'CancelasController@cancelaEntrada');
    //Rota para a cencela saida
    Route::get('/saida', 'CancelasController@cancelaSaida');

});

/****************** Rotas do ADMINISTRATIVO *******************/
Route::group(['prefix' => 'admin'], function () {
    // Rota para retonar a identificação do user e fazer a consulta pela foto no BD central
    Route::get('/imagem', 'DashboardControlador@imagemUser')->name('view.inicial');
    //Visulizar view página inicial
    Route::get('/', 'DashboardControlador@index')->name('view.inicial');

    //Dados do Dashboard
    Route::get('/ver', 'DashboardControlador@indexJsonTipoDeUsuario');
    //rota para consulta os dados com where MES
    Route::get('/dashboard/ver/mes', 'DashboardControlador@indexJsonTransitoPorPeriodo');
    //rota para consulta os dados com where curso
    Route::get('/dashboard/ver/curso', 'DashboardControlador@indexJsonTransitoPorCurso');
    //rota para consulta os dados com where bloco
    Route::get('/dashboard/ver/bloco', 'DashboardControlador@indexJsonTransitoPorBloco');

    //Visualizar cadastro Listagem
    Route::get('/cadastros/condutor', 'CondutorControlador@indexListagem')->name('view.cadastros.condutores');
    Route::post('/cadastros/condutor/excluir', 'CondutorControlador@destroyListagem')->name('view.cadastros.excluir');

    //Rota GET para popular dados para a tabela da view cadastro-condutor-listagem
    Route::any('/cadatros/condutores/listagem', 'CondutorControlador@indexJsonListagem')->name('condutores.listagem');
    //Visualizar cadastro Condutores
    Route::get('/cadastro/condutor', 'CondutorControlador@indexCadastro')->name('view.cadastro.condutor');
    //Rota para adicionar um novo condutor
    Route::any('/cadastro/condutor/create', 'CondutorControlador@create')->name('view.cadastro.condutor.create');
    Route::any('/cadastro/condutor/ver', 'CondutorControlador@buscarDadosCondutor')->name('cadastro.condutor.ver');
    Route::any('/cadastro/autocomplete/{data}', 'CondutorControlador@buscaButton')->name('cadastro.condutor.button');
    //Redirecionando para view com o ID do condutor
    Route::get('/cadastros/condutor/{data}/RedirecionarEditar', 'CondutorControlador@getViewEdit')->name('condutor.editar.mostrar_dados');
    //puxando os dados do condutor
    Route::get('/cadastros/condutor/{data}/Editar', 'CondutorControlador@getCondutor')->name('condutor.editar.mostrar_dados');
    Route::get('/cadastros/condutor/{data}/listar', 'CondutorControlador@getCondutorVisualizar')->name('condutor.editar.mostrar_dados');
    Route::get('/cadastros/condutor/{data}/editarVeiculo', 'CondutorControlador@getEditarVeiculoCondutor')->name('condutor.editar.mostrar_dados');
    Route::post('/editar/ver', 'CondutorControlador@editarCondutor')->name('condutor.editar');
    Route::post('/buscar_condutor/id', 'CondutorControlador@buscar_registro')->name('condutor.editar');
    //Rota para cadastrar um novo veiculo pela tela de editar
    Route::post('/cadastros/condutor/novo', 'CondutorControlador@novoVeiculoTelaDeEditar')->name('novoVeiculoTelaDeEditar');
    //Rota para editar um veiculo (tela de editar)
    Route::post('/cadastros/condutor/atualizar', 'CondutorControlador@atualizarVeiculoCondutor')->name('tes');
    //Rota para Deletar um veiculo (Tela de editar)
    Route::delete('/editar/condutor/{id_veiculo}/deletarVeiculo', 'CondutorControlador@deletaVeiculoCondutor')->name('aaaaa.id');
    //
    Route::any('/cadastro/condutor/cadastrar/validacao/form', 'CondutorControlador@create');
    //validação do form veiculos
    Route::any('/cadastro/condutor/validacao', 'CondutorControlador@validacaoFormVeiculos')->name('cadastro.condutor.validacao');

    //**************  ROTAS PARA CADASTRAR, EDITAR E EXCLUIR USUARIO DO SISTEMA *****************//
    //Rota para fazer a verificação se o user esta logado.
    Route::get('/cadastros/usuario', 'CadastroUsuarioController@indexUser')->name('view.CadastroUser');
    //LIstando os dados do condutor
    Route::get('/cadastros/usuario/ver', 'CadastroUsuarioController@listarUsuarios');
    //Rota para função de visualizar USER
    Route::get('/cadastros/usuario/{data}/listar', 'CadastroUsuarioController@editarUsuario');
    //Consultando o dados do usuario pelo ID e fazendo um INNE para pegar o nome da permissao.
    Route::get('/cadastros/usuario/{data}/editar', 'CadastroUsuarioController@editarUsuario');
    //Rota para cadastarar novo USUARIO fazendo também a validação dos campos obrigatorios.
    Route::post('/cadastros/usuario/cadastrar', 'CadastroUsuarioController@cadastrarUsuario');
    //Rota para atualizar os dados do usuarios
    Route::post('/cadastros/usuario/atualizar', 'CadastroUsuarioController@atualizarDadosUser');
    //Rota para deletar um usuário
    Route::delete('/cadastros/usuario/{data}/delete', 'CadastroUsuarioController@deleteUsers');


    //*********************************************************************************************//

    //*****************ROTAS PARA EMITIR SONS PARA AS CANCELAS****************************//
    Route::get('/camera', 'CameraControlador@indexSons');
    Route::get('/camera/ver', 'CameraControlador@pingRasp');
    Route::get('/camera/ver/cancela', 'CameraControlador@indexJson');
    Route::any('/camera/cancelas', 'CameraControlador@verificarcancela');
    Route::get('/camera/emitir-som-entrada', 'CameraControlador@emitirSonsEntrada')->name('emitirsom');
    Route::get('/camera/emitir-som-saida', 'CameraControlador@emitirSonsSaida')->name('emitirsom');

    //*****************************************************************************//

    //Visualizar transitos
    Route::get('/transitos', 'TransitoControlador@index')->name('view.transitos');
    Route::get('/transitos/ver', 'TransitoControlador@indexJson');
    // Route::get('/transitos/ver', 'TransitoControlador@indexJson');
    Route::get('/transitos/ver/ultimos-transitos', 'TransitoControlador@ultimosTransitos');
    Route::any('/transitos/ver/cadastro-transito', 'TransitoControlador@transito')->name('Cadastro.Transito');
    Route::get('/transitos/ver/emitir-som-mEntrada', 'TransitoControlador@emitirMensagemEntrada')->name('emitirsom');
    Route::get('/transitos/ver/emitir-som-mSaida', 'TransitoControlador@emitirMensagemSaida')->name('emitirsom');
    Route::get('/transitos/ver/emitir-som-errEntrada', 'TransitoControlador@emitirMensagemErroEntrada')->name('emitirsomErro');
    Route::get('/transitos/ver/emitir-som-errSaida', 'TransitoControlador@emitirMensagemErroSaida')->name('emitirsomErro');

    Route::any('/transitos/cancelas', 'TransitoControlador@verificarCondutor')->name('transito');
    //trazer informações do veiculo do condutor
    Route::post('/condutores/veiculos/busca-veiculo', 'TransitoControlador@buscaVeiculo');

    //Visualizar registros
    Route::get('/registros', 'RegistroControlador@index')->name('view.registros');
    //Trazendo dados do select -  Registro
    Route::get('/registros/ver', 'RegistroControlador@indexJson')->name('buscandoDados');
    //Trazendo todos os dados referente ao valor selecionado
    Route::any('/registros/tipo-registro', 'RegistroControlador@carregarTipoRegistro')->name('consultaTipoDeTranstio');
    Route::any('/registros/listar', 'RegistroControlador@indexJsonModal')->name('');

    //View de Ajuda
    Route::get('/ajuda', function () {
        return view('Administrativo.ajuda');
    });

    //****************Grupos de rota para configurara os ip do raspberry******************//
    Route::get('configuracoes', 'RaspController@index')->name('raspberry.ip');
    //Raspberry dados
    Route::get('configuracoes/ver', 'RaspController@raspBerry')->name('raspberry.ip');
    //Passando ID do RaspBerry para chamar os dados referente ao ID selecionado
    Route::get('configuracoes/{id_raspberry}/editar', 'RaspController@editarRaspBerry')->name('editRaspberry.ip');
    //Passando ID do RaspBerry para chamar os dados referente ao ID selecionado
    Route::get('configuracoes/{id_raspberry}/listar', 'RaspController@editarRaspBerry')->name('listarRaspberry.ip');
    //Cadastrar RaspBerry
    Route::post('configuracoes/cadastrar', 'RaspController@adicionarRaspBerry')->name('cadastrarRaspberry');
    //Atualizar dados do RaspBerry
    Route::post('configuracoes/atualizar', 'RaspController@atualizarRaspBerry')->name('a5tualizarRaspberry');
    //Apagar RaspBerry
    Route::delete('configuracoes/{id_raspberry}/apagar', 'RaspController@deletarRaspBerry')->name('deletarRaspberry.ip');

});
//Rotas para login, registro de usuario, e recuperar(function do laravel)
Auth::routes();

