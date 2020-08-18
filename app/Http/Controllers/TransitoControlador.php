<?php

namespace App\Http\Controllers;

use App\Transito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransitoControlador extends Controller
{
    /**
     * Função de retorno da view ne limpa os arquivos.
     * Finalizado, pronto para testes.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::check()) {
            $user = Auth::user();
            //Limpando os arquivos de entrada e saída.
            $file_entrada = '../storage/app/public/entrada.txt';
            $file_saida = '../storage/app/public/saida.txt';

            //Limpa o arquivo de entrada
            if (unlink($file_entrada)) {
                //abre o arquivo, se não exisit ele cria um e abre
                $file_entrada_aberto = fopen($file_entrada, 'w+');
                //verificando se o arquivo existe
                if (file_exists($file_entrada)) {
                    //fechando o arquivo

                    fclose($file_entrada_aberto);
                }
            }

            //Limpa o arquivo de saida (exclui o arquivo)
            if (unlink($file_saida)) {
                //abre o arquivo, se não exisit ele cria um e abre
                $file_saida_aberto = fopen($file_saida, 'w+');
                //verificando se o arquivo existe
                if (file_exists($file_saida)) {
                    //fechando o arquivo
                    fclose($file_saida_aberto);
                }
            }

            //verificando o nivel de permissao da pessoa logada.
            if ($user->permissao_id_fk == 1 || $user->permissao_id_fk == '1' || $user->permissao_id_fk == 2 || $user->permissao_id_fk == '2') { 
                //pegando apenas o id do Usuario logado
                $idLogado = Auth::user()->id;
                //consultando permissao do usuario que ta logado
                $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);
                return view('Administrativo.transito', compact('user', 'consultaPopup'));
            } else {
                return redirect('/admin');
            }
        } else {
            return redirect('/login');

        }

    }

    /**
     * Função que cadastra o número do cartão.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function verificarCondutor(Request $request)
    {

        $numero_cartao = $request->numero_cartao;
        $cancela_tipo = $request->cancela;

        $respose = array();

        if ((!empty($numero_cartao)) && ($cancela_tipo == 0 || $cancela_tipo == 1)) {
            // ---------------------- Cancela de Entrada ---------------------- //
            if ($cancela_tipo == 0) {
                $file_entrada = '../storage/app/public/entrada.txt';
                //caso exista o arquivo.
                if (is_readable($file_entrada)) {
                    $arquivo_entrada = fopen($file_entrada, 'w+');
                    if ($arquivo_entrada != false) {
                        //verifica se o arquivo está limpo.
                        $conteudoArquivo = file($file_entrada);
                        if (empty($conteudoArquivo)) {
                            //escrever no arquivo txt
                            if (fwrite($arquivo_entrada, $numero_cartao)) {
                                $respose['data'] = "Foi possivel escrever no arquivo.";
                            } else {
                                $respose['data'] = "Não foi possível escrever no arquivo.";
                            }
                        }
                    }
                }

                fclose($arquivo_entrada);
            }

            // ---------------------- Cancela de Saída ---------------------- //
            elseif ($cancela_tipo == 1) {
                $file_saida = '../storage/app/public/saida.txt';

                //caso exista o arquivo.
                if (is_readable($file_saida)) {
                    $arquivo_saida = fopen($file_saida, 'w+');
                    if ($arquivo_saida != false) {
                        //verifica se o arquivo está limpo.
                        $conteudoArquivo = file($file_saida);
                        if (empty($conteudoArquivo)) {
                            //escrever no arquivo txt
                            if (fwrite($arquivo_saida, $numero_cartao)) {
                                $respose['data'] = "Não foi possível escrever no arquivo.";
                            } else {
                                $respose['data'] = "Foi possivel escrever no arquivo.";
                            }
                        }
                    }
                }
                //fechando arquivo.
                fclose($arquivo_saida);
            }
        }
        return response()->json($respose);
    }

    public function indexJson()
    {
        //Declaração de arrays
        $result_dados = array();

        //Caminho de arquivos de entrada/saída.
        $file_entrada_ler = '../storage/app/public/entrada.txt';
        $file_saida_ler = '../storage/app/public/saida.txt';

        //Verifica o tamanho dos dois arquivos.
        $size_file_entrada = filesize($file_entrada_ler);
        $size_file_saida = filesize($file_saida_ler);

        // -------------------- Cancela de Entrada --------------------------- //
        if ($size_file_entrada != 0 && $size_file_saida == 0) {
            //Ler o arquivo de entrada
            $arquivo_entrada = fopen($file_entrada_ler, 'r+');

            if ($arquivo_entrada) {
                $codigoCartao = fgets($arquivo_entrada);

                if (!empty($codigoCartao)) {
                    //Faz a consulta na tabela condutor
                    $verCondutor = DB::select('SELECT * FROM condutor WHERE numero_cartao = ? AND condutor.data_de_exclusao is null', [$codigoCartao]);

                    if (!empty($verCondutor)) {
                        $result_dados['dadosCondutor'] = $verCondutor;

                        foreach ($verCondutor as $condutorID) {
                            $condutor_id = $condutorID->condutor_id;
                        }

                        //Faz a consulta na tabela veiculo
                        $verVeiculo = DB::select('SELECT * FROM veiculo WHERE condutor_id_fk = ?', [$condutor_id]);
                        $result_dados['dadosVeiculos'] = $verVeiculo;
                        $result_dados['tipo_cancela'] = 2;

                        return response()->json($result_dados);
                    } else {
                        //Limpando os arquivos de entrada e saída.
                        $file_entrada = '../storage/app/public/entrada.txt';
                        $file_saida = '../storage/app/public/saida.txt';

                        //Limpa o arquivo de entrada
                        if (unlink($file_entrada)) {
                            $file_entrada_aberto = fopen($file_entrada, 'w+');
                            if (file_exists($file_entrada)) {
                                fclose($file_entrada_aberto);
                            }
                        }

                        //Limpa o arquivo de saida
                        if (unlink($file_saida)) {
                            $file_saida_aberto = fopen($file_saida, 'w+');
                            if (file_exists($file_saida)) {
                                fclose($file_saida_aberto);
                            }
                        }

                        if (file_exists($file_entrada) && file_exists($file_saida)) {
                            $file_entrada_condutor = '../storage/app/public/condutorNaoCadastradoEntrada.txt';
                            //Escreve a mensagem, no arquivo de mensagem
                            $arquivo_mensagem_condutor = fopen($file_entrada_condutor, 'w+');
                            if ($arquivo_mensagem_condutor != false) {
                                //escrever a mensagem de erro.
                                if (!fwrite($arquivo_mensagem_condutor, 1)) {
                                    fclose($arquivo_mensagem_condutor);
                                }
                            }
                            return response()->json(['condutor_n_cadastrado' => 1]);
                        } else {
                            return redirect('/admin');
                        }
                    }
                }
            }
        }

        // -------------------- Cancela de Saída --------------------------- //
        else if ($size_file_saida != 0 && $size_file_entrada == 0) {
            $arquivo_saida = fopen($file_saida_ler, 'r+');
            if ($arquivo_saida) {
                $codigoCartao = fgets($arquivo_saida);
                if (!empty($codigoCartao)) {
                    //Faz a consulta na tabela condutor
                    $verCondutor = DB::select('SELECT * FROM condutor WHERE numero_cartao = ? and condutor.data_de_exclusao is null', [$codigoCartao]);

                    if (!empty($verCondutor)) {
                        $result_dados['dadosCondutor'] = $verCondutor;

                        foreach ($verCondutor as $condutorID) {
                            $condutor_id = $condutorID->condutor_id;
                        }

                        //Faz a consulta na tabela veiculo
                        $verVeiculo = DB::select('SELECT * FROM veiculo WHERE condutor_id_fk = ?', [$condutor_id]);
                        $result_dados['dadosVeiculos'] = $verVeiculo;
                        $result_dados['tipo_cancela'] = 3;

                        return response()->json($result_dados);
                    } else {
                        //Limpando os arquivos de entrada e saída.
                        $file_entrada = '../storage/app/public/entrada.txt';
                        $file_saida = '../storage/app/public/saida.txt';

                        //Limpa o arquivo de entrada
                        if (unlink($file_entrada)) {
                            $file_entrada_aberto = fopen($file_entrada, 'w+');
                            if (file_exists($file_entrada)) {
                                fclose($file_entrada_aberto);
                            }
                        }

                        //Limpa o arquivo de saida
                        if (unlink($file_saida)) {
                            $file_saida_aberto = fopen($file_saida, 'w+');
                            if (file_exists($file_saida)) {
                                fclose($file_saida_aberto);
                            }
                        }

                        if (file_exists($file_entrada) && file_exists($file_saida)) {
                            $file_entrada_condutor = '../storage/app/public/condutorNaoCadastradoSaida.txt';
                            //Escreve a mensagem, no arquivo de mensagem
                            $arquivo_mensagem_condutor = fopen($file_entrada_condutor, 'w+');
                            if ($arquivo_mensagem_condutor != false) {
                                //escrever a mensagem de erro.
                                if (!fwrite($arquivo_mensagem_condutor, 1)) {
                                    fclose($arquivo_mensagem_condutor);
                                }
                            }
                            return response()->json(['condutor_n_cadastrado' => 1]);
                        } else {
                            return redirect('/admin');
                        }
                    }
                }
            }
        }

        // -------------------- Ultimo condutor --------------------------- //
        else {
            //criando um array
            $ultimo_condutor = array('arquivo_limpo' => '1');
            //Select para trazer o ultimo condutor que transitou
            $consulta_ultimo_cond = DB::select('SELECT condutor.condutor_id as condutor_id, condutor.nome as condutor_nome, condutor.imagem_condutor, identificacao, condutor.tipo as tipo_pessoa, condutor.setor_curso as curso_setor, condutor.telefone as contato, transito.veiculo_id_fk
            FROM transito
            INNER JOIN condutor ON condutor.condutor_id = transito.condutor_id_fk
            WHERE condutor.data_de_exclusao is null
            ORDER BY transito.data_de_criacao DESC LIMIT 1');

            $ultimo_condutor['consultaUltimoCondutor'] = $consulta_ultimo_cond;

            $condutor_id = $consulta_ultimo_cond[0]->condutor_id;
            $veiculo_id = $consulta_ultimo_cond[0]->veiculo_id_fk;
            //verificando se o condutor tem viculos
            if (empty($veiculo_id)) {
                $ultimo_condutor['dadosVeiculos'] = 0;
            } else {
                $ultimo_condutor['dadosVeiculos'] = DB::select('SELECT * FROM veiculo WHERE condutor_id_fk = ?', [$condutor_id]);
            }

            return $ultimo_condutor;
        }
    }

    //Cadastro de transito automatico/manual
    public function transito(Request $request)
    {
        //pegando a data atual.
        $dataAtual = date("Y-m-d H:i:s");
        //
        $transito = new Transito();
        //recebendo  o tipo do transito se é auto ou manual
        $tipo_transito = $request->tipo_transito;
        //recebendo o id condutor que esta transitando
        $id_condutor = $request->condutor_id;
        //recebendo o valor da cancela
        $tipo_cancela = $request->tipo_cancela;
        //Verificando se o transito foi execultado no automatico
        if (($tipo_transito == 'automatico' && !empty($id_condutor)) && (!empty($tipo_cancela))) {
            //Verificando qual o valor da cancela. cancela valor 2 = transito cancela entrada.
            if ($tipo_cancela == 2) {
                //gravando os dados da cancela e do condutor no BANCO
                $transito->condutor_id_fk = $id_condutor;
                $transito->tipo_transito_id_fk = 2;
                $transito->save();
                //cancela entrada
                if ($transito) {
                    $file_entrada = '../storage/app/public/entrada.txt';
                    $file_mensagem = '../storage/app/public/mensagemEntrada.txt';

                    //limpa o arquivo de entrada(excluindo o arquivo)
                    if (unlink($file_entrada)) {
                        //abrindo o arquivo, se o arquivo não existir ele cria um novo.
                        $file_entrada_aberto = fopen($file_entrada, 'w+');
                        //Verifica se um arquivo ou diretório existe
                        if (file_exists($file_entrada)) {
                            //Fecha um ponteiro de arquivo aberto
                            fclose($file_entrada_aberto);

                            //Abre um arquivo
                            $arquivo_mensagem = fopen($file_mensagem, 'w+');
                            //Verificando se o arquivo existe
                            if ($arquivo_mensagem != false) {
                                //escrever no arquivo
                                if (!fwrite($arquivo_mensagem, 1)) {
                                    //fecha o arquivo
                                    fclose($arquivo_mensagem);
                                }
                            }
                        }
                    } else {
                        echo "não deu bom";
                    }
                }
            }
            //transito de saida
            else if ($tipo_cancela == 3) {
                //Consultando o ultimo transito da pessoa que está passando na cancela e saída para preencher o campo DATA_DE_SAIDA
                $ultimoTransitoID = DB::select('SELECT * FROM transito WHERE transito.condutor_id_fk = ? AND transito.tipo_transito_id_fk = 2 ORDER BY transito.data_de_criacao DESC LIMIT 1', [$id_condutor]);
                //Atualizado o campo DATA_DE_SAIDA.
                $atualizardados = Transito::find($ultimoTransitoID[0]->transito_id);
                $atualizardados->data_de_saida = $dataAtual;
                $atualizardados->update();
                //Criando os dados para tipo saida
                $transito->condutor_id_fk = $id_condutor;
                $transito->tipo_transito_id_fk = 3;
                $transito->save();

                if ($transito) {
                    $file_saida = '../storage/app/public/saida.txt';
                    $file_mensagem = '../storage/app/public/mensagemSaida.txt';

                    //limpa o arquivo de entrada
                    if (unlink($file_saida)) {
                        $file_saida_aberto = fopen($file_saida, 'w+');
                        if (file_exists($file_saida)) {
                            fclose($file_saida_aberto);

                            //Escreve a mensagem, no arquivo de mensagem
                            $arquivo_mensagem = fopen($file_mensagem, 'w+');

                            if ($arquivo_mensagem != false) {
                                //escrever a mensagem de erro.
                                if (!fwrite($arquivo_mensagem, 1));
                                fclose($arquivo_mensagem);
                            }
                        }
                    }
                }
            }
        } else {
            //transitos manual
            $veiculo_id = $request->veiculo_id;
            if ($tipo_cancela == 2) {
                $transito->condutor_id_fk = $id_condutor;
                $transito->veiculo_id_fk = $veiculo_id;
                $transito->tipo_transito_id_fk = 2;
                $transito->save();

                if ($transito) {
                    $file_entrada = '../storage/app/public/entrada.txt';
                    $file_mensagem = '../storage/app/public/mensagemEntrada.txt';

                    //limpa o arquivo de entrada
                    if (unlink($file_entrada)) {
                        $file_entrada_aberto = fopen($file_entrada, 'w+');
                        if (file_exists($file_entrada)) {
                            fclose($file_entrada_aberto);

                            //Escreve a mensagem, no arquivo de mensagem
                            $arquivo_mensagem = fopen($file_mensagem, 'w+');

                            if ($arquivo_mensagem != false) {
                                //escrever a mensagem de erro.
                                if (!fwrite($arquivo_mensagem, 1)) {
                                    fclose($arquivo_mensagem);
                                }
                            }
                        }
                    } else {
                        echo "não deu bom";
                    }
                } else {
                    //retornar um erro no arquivo de mensagem
                }
            }
            //transito de saida
            else if ($tipo_cancela == 3) {
                //Consultando o ultimo transito da pessoa que está passando na cancela e saída para preencher o campo DATA_DE_SAIDA
                $ultimoTransitoIDmanual = DB::select('SELECT * FROM transito WHERE transito.condutor_id_fk = ? AND transito.tipo_transito_id_fk = 2 ORDER BY transito.data_de_criacao DESC LIMIT 1', [$id_condutor]);
                if ($ultimoTransitoIDmanual == null || $ultimoTransitoIDmanual == []) {
                    $transito->condutor_id_fk = $id_condutor;
                    $transito->veiculo_id_fk = $veiculo_id;
                    $transito->tipo_transito_id_fk = 3;
                    $transito->save();
                } else {
                    //Atualizado o campo DATA_DE_SAIDA.
                    $atualizardados = Transito::find($ultimoTransitoIDmanual[0]->transito_id);
                    $atualizardados->data_de_saida = $dataAtual;
                    $atualizardados->update();

                    $transito->condutor_id_fk = $id_condutor;
                    $transito->veiculo_id_fk = $veiculo_id;
                    $transito->tipo_transito_id_fk = 3;
                    $transito->save();
                }

                if ($transito) {
                    $file_saida = '../storage/app/public/saida.txt';
                    $file_mensagem = '../storage/app/public/mensagemSaida.txt';

                    //limpa o arquivo de entrada
                    if (unlink($file_saida)) {
                        $file_saida_aberto = fopen($file_saida, 'w+');
                        if (file_exists($file_saida)) {
                            fclose($file_saida_aberto);

                            //Escreve a mensagem, no arquivo de mensagem
                            $arquivo_mensagem = fopen($file_mensagem, 'w+');

                            if ($arquivo_mensagem != false) {
                                //escrever a mensagem de erro.
                                if (!fwrite($arquivo_mensagem, 1));
                                fclose($arquivo_mensagem);
                            }
                        }
                    }
                }
            }
        }
    }
    //função para buscar os veiculo para tela de registro de transito.
    public function buscaVeiculo(Request $request)
    {
        $veiculos = DB::select('SELECT veiculo.* FROM veiculo INNER JOIN condutor ON condutor.condutor_id = veiculo.condutor_id_fk WHERE condutor.condutor_id = :id', ['id' => $request->id]);
        return response()->json($veiculos);
    }
    //função para emitir som de erro na cancela entrada.
    public function emitirMensagemErroEntrada()
    {
        //armazenando o arquivo em  uma variavel
        $file_entrada_condutor = '../storage/app/public/condutorNaoCadastradoEntrada.txt';
        //Diz se o arquivo existe e se ele pode ser lido
        if (is_readable($file_entrada_condutor)) {
            //Abre um arquivo ou URL ('a+'    Abre para leitura e escrita; coloca o ponteiro do arquivo no final do arquivo. Se o arquivo não existir, tenta criá-lo.)
            $arquivo_mensagem = fopen($file_entrada_condutor, 'a+');
            //Lê uma linha de um ponteiro de arquivo
            $codigoMensagem = fgets($arquivo_mensagem);
            //verificando se o arquivo é diferente de vazio
            if (!empty($codigoMensagem)) {
                //Fecha um ponteiro de arquivo aberto
                fclose($arquivo_mensagem);
                //se o arquivo existir ele apaga
                if (unlink($file_entrada_condutor)) {
                    //abrindo o arquivo, se não exisitr ele cria um novo e abri
                    $file_entrada_condutor_aberto = fopen($file_entrada_condutor, 'w+');
                    //Fecha um ponteiro de arquivo aberto
                    fclose($file_entrada_condutor_aberto);
                    return $codigoMensagem;
                }
            }
        }
    }
    public function emitirMensagemErroSaida()
    {
        //explicações na função emitirMensagemErroEntrada
        $file_entrada_condutor = '../storage/app/public/condutorNaoCadastradoSaida.txt';
        if (is_readable($file_entrada_condutor)) {
            $arquivo_mensagem = fopen($file_entrada_condutor, 'a+');
            $codigoMensagem = fgets($arquivo_mensagem);
            if (!empty($codigoMensagem)) {
                fclose($arquivo_mensagem);
                if (unlink($file_entrada_condutor)) {
                    $file_entrada_condutor_aberto = fopen($file_entrada_condutor, 'w+');
                    fclose($file_entrada_condutor_aberto);
                    return $codigoMensagem;
                }
            }
        }
    }
    //emitir som e apagar arquivo de mensagem.
    public function emitirMensagemEntrada()
    {
        //Caminho de arquivos de entrada/saída.
        $file_entrada_veriricar = '../storage/app/public/entrada.txt';
        $file_saida_veriricar = '../storage/app/public/saida.txt';

        //Verifica o tamanho dos dois arquivos.
        $size_file_entrada_verificar = filesize($file_entrada_veriricar);
        $size_file_saida_verificar = filesize($file_saida_veriricar);

        // -------------------- Cancela de Entrada --------------------------- //
        //Verificando se os arquivos de entrada e saida estão preenc
        if ($size_file_entrada_verificar != 0 && $size_file_saida_verificar != 0) {
            //Limpa o arquivo de saida (exclui o arquivo)
            if (unlink($file_saida_veriricar)) {
                //abre o arquivo, se não exisit ele cria um e abre
                $file_saida_aberto = fopen($file_saida_veriricar, 'w+');
                //verificando se o arquivo existe
                if (file_exists($file_saida_veriricar)) {
                    //fechando o arquivo
                    fclose($file_saida_aberto);
                }
            }
        }
        //explicações na função emitirMensagemErroEntrada
        $file_mensagem = '../storage/app/public/mensagemEntrada.txt';
        if (is_readable($file_mensagem)) {
            $arquivo_mensagem = fopen($file_mensagem, 'a+');
            $codigoMensagem = fgets($arquivo_mensagem);
            if (!empty($codigoMensagem)) {
                fclose($arquivo_mensagem);
                if (unlink($file_mensagem)) {
                    $file_mensagem_aberto = fopen($file_mensagem, 'w+');
                    fclose($file_mensagem_aberto);
                    return $codigoMensagem;
                }
            }
        }
    }
    public function emitirMensagemSaida()
    {
        //explicações na função emitirMensagemErroEntrada
        $file_mensagem = '../storage/app/public/mensagemSaida.txt';
        if (is_readable($file_mensagem)) {
            $arquivo_mensagem = fopen($file_mensagem, 'a+');
            $codigoMensagem = fgets($arquivo_mensagem);
            if (!empty($codigoMensagem)) {
                fclose($arquivo_mensagem);
                if (unlink($file_mensagem)) {
                    $file_mensagem_aberto = fopen($file_mensagem, 'w+');
                    fclose($file_mensagem_aberto);
                    return $codigoMensagem;
                }
            }
        }
    }

    public function ultimosTransitos()
    {
        //Select para trazer os ultimos condutores.
        $ultimosTransitos = DB::select('SELECT condutor.nome as condutor_nome, tipo_transito.descricao_tipo_transito as tipo_transito
        FROM transito
        INNER JOIN condutor ON condutor.condutor_id = transito.condutor_id_fk
        INNER JOIN tipo_transito ON transito.tipo_transito_id_fk = tipo_transito.tipo_transito_id
        ORDER by transito.transito_id DESC LIMIT 11');
        return $ultimosTransitos;
    }
}
