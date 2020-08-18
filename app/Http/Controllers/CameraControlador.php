<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CameraControlador extends Controller
{
    public function indexSons()
    {
        if (Auth::check()) {
            $user = Auth::user();
            //pegando apenas o id do Usuario logado
            $idLogado = Auth::user()->id;
            //consultando permissao do usuario que ta logado
            $consultaPopup = DB::select('SELECT * FROM users INNER JOIN permissao ON users.permissao_id_fk = permissao.permissao_id  WHERE users.id = ?', [$idLogado]);
            //Limpando os arquivos de entrada e Entrada.
            $file_entrada = '../storage/app/public/sonsEntrada.txt';
            //Limpando os arquivos de entrada e Saída.
            $file_saida = '../storage/app/public/sonsSaida.txt';

            //Limpa o arquivo de entrada
            if (unlink($file_entrada)) {
                $file_entrada_aberto = fopen($file_entrada, 'w+');
                if (file_exists($file_entrada)) {
                    fclose($file_entrada_aberto);
                }
            }
            //Limpa o arquivo de Saida
            if (unlink($file_saida)) {
                $file_saida_aberto = fopen($file_saida, 'w+');
                if (file_exists($file_saida)) {
                    fclose($file_saida_aberto);
                }
            }
            //verificando o nivel de permissao da pessoa logada.
            if ($user->permissao_id_fk == 1 || $user->permissao_id_fk == '1' || $user->permissao_id_fk == 2 || $user->permissao_id_fk == '2') {
                return view('Administrativo.camera', compact('user', 'consultaPopup'));

            } else {
                return redirect('/admin');

            }
        } else {
            return redirect('/login');

        }

    }
    //Pigando para o inpt fornecido na tela do raspberry.
    public function pingRasp()
    {
        //select para trazer apenas 2 ip do raspberry
        $raspCadastrados = DB::select('SELECT tipo_raspberry.attr as tipo, raspberry.ip as ip FROM raspberry INNER JOIN tipo_raspberry ON raspberry.tipo_id_fk = tipo_raspberry.tipo_rasp_id LIMIT 2');

        //criando array
        $retorno = array();
        //percorrendo os ip fornecido
        foreach ($raspCadastrados as $ip) {
            //IP DO RASPBERRY
            $host = $ip->ip;
            //Executa um programa externo. no caso um "ping"
            // exec("ping -n 1 -w 1 " . $host, $output, $result);
            //Abre um socket de conexão Internet ou de domínio Unix.
            //ip: ip fornecido, 80:número da porta.
            // 03:Timeout de conexão, em segundos.
            $conectado = @fsockopen($host, 80, $numeroDoErro, $stringDoErro, 03);
            //verificando se o ip é o tipo entrada.
            if ($conectado) {
                if ($ip->tipo == 'entrada') {
                    $retorno['entrada'] = 1;
                } else {
                    $retorno['saida'] = 1;
                }

            } else {
                if ($ip->tipo == 'entrada') {
                    $retorno['entrada'] = 0;
                } else {
                    $retorno['saida'] = 0;
                }

            }
        }
        return response()->json($retorno);
    }

    public function verificarcancela(Request $request)
    {
        //Recebendo valores passado pelo o click
        $sonsCancelas = $request->valorSom;
        $cancelaTipo = $request->valorCancela;

        // Verifica se as variaveis não são vazias.
        if ($sonsCancelas != null && $cancelaTipo != null) {

            // -------------------- Cancela de Entrada --------------------------- //
            if ($cancelaTipo == 0) {
                $file_entrada = '../storage/app/public/sonsEntrada.txt';
                //caso exista o arquivo.
                if (is_readable($file_entrada)) {
                    $arquivo_entrada = fopen($file_entrada, 'w+');
                    if ($arquivo_entrada != false) {
                        //verifica se o arquivo está limpo, caso sim escreva no arquivo.
                        $conteudoArquivo = file($file_entrada);
                        if (empty($conteudoArquivo)) {
                            //escrever no arquivo txt
                            if (fwrite($arquivo_entrada, $sonsCancelas) === false) {
                                return response()->json("Não foi possível escrever no arquivo.");
                            } else {
                                return response()->json("foi possivel escrever no arquivo. ENTRADA");
                            }
                            fclose($arquivo_entrada);
                        } else {
                            return response()->json("foi possivel escrever no arquivo. Ele não pode ser alterado.");
                        }
                    }
                } else {
                    return response()->json("foi possivel abrir o arquivo. Ele não pode ser alterado.");
                }
            }

            // -------------------- Cancela de Saída --------------------------- //
            elseif ($cancelaTipo == 1) {
                $file_saida = '../storage/app/public/sonsSaida.txt';
                //caso exista o arquivo.
                if (is_readable($file_saida)) {
                    $arquivo_saida = fopen($file_saida, 'w+');
                    if ($arquivo_saida != false) {
                        //verifica se o arquivo está limpo, caso sim escreva no arquivo.
                        $conteudoArquivo = file($file_saida);
                        if (empty($conteudoArquivo)) {
                            //escrever no arquivo txt
                            if (fwrite($arquivo_saida, $sonsCancelas) === false) {
                                return response()->json("Não foi possível escrever no arquivo.");
                            } else {
                                return response()->json("foi possivel escrever no arquivo. SAIDA");
                            }

                            //fechando arquivo.
                            fclose($arquivo_saida);
                        } else {
                            return response()->json("foi possivel escrever no arquivo. Ele não pode ser alterado.");
                        }
                    }
                } else {
                    return response()->json("foi possivel abrir o arquivo. Ele não pode ser alterado.");
                }
            }
            //caso der erro.
            else {
                return response()->json("Deu erro.");
            }
        }
    }
    public function indexJson()
    {
        //Declaração de arrays
        $result_dados_entrada = array();

        //Abri o arquivo de entrada/saída para leitura.
        $file_entrada_ler = '../storage/app/public/sonsEntrada.txt';
        $file_saida_ler = '../storage/app/public/sonsSaida.txt';

        //Verifica o tamanho dos dois arquivos.
        $size_file_entrada = filesize($file_entrada_ler);
        $size_file_saida = filesize($file_saida_ler);

        // -------------------- Cancela de Entrada --------------------------- //
        if ($size_file_entrada != 0 && $size_file_saida == 0) {
            //Ler o arquivo de entrada
            $arquivo_entrada = fopen($file_entrada_ler, 'r+');
            if ($arquivo_entrada) {
                $valorDoArquivoEntrada = fgets($arquivo_entrada);
                echo "ate aqui ta tranquilo entrada";
            }
        }
        // -------------------- Cancela de Saída --------------------------- //
        else if ($size_file_saida != 0 && $size_file_entrada == 0) {
            $arquivo_saida = fopen($file_saida_ler, 'r+');
            if ($arquivo_saida) {
                $valorDoArquivoSaida = fgets($arquivo_saida);
                echo "tudo tranquilo saida";
            }
        } else {
            echo "erro";
        }
    }

    public function emitirSonsEntrada()
    {
        $file_mensagemSons_entrada = '../storage/app/public/sonsEntrada.txt';
        if (is_readable($file_mensagemSons_entrada)) {
            $arquivo_mensagem_entrada = fopen($file_mensagemSons_entrada, 'a+');
            $codigoMensagem_entrada = fgets($arquivo_mensagem_entrada);
            if (!empty($codigoMensagem_entrada)) {
                fclose($arquivo_mensagem_entrada);
                if (unlink($file_mensagemSons_entrada)) {
                    $file_mensagemSons_entrada_aberto = fopen($file_mensagemSons_entrada, 'w+');
                    fclose($file_mensagemSons_entrada_aberto);
                    return $codigoMensagem_entrada;
                }
            }
        }
    }
    //Funão para escrever no arquivo de saida, para emitir o som
    public function emitirSonsSaida()
    {
        $file_mensagemSons_sainda = '../storage/app/public/sonsSaida.txt';
        if (is_readable($file_mensagemSons_sainda)) {
            $arquivo_mensagem_saida = fopen($file_mensagemSons_sainda, 'a+');
            $codigoMensagem_saida = fgets($arquivo_mensagem_saida);
            if (!empty($codigoMensagem_saida)) {
                fclose($arquivo_mensagem_saida);
                if (unlink($file_mensagemSons_sainda)) {
                    $file_mensagemSons_sainda_aberto = fopen($file_mensagemSons_sainda, 'w+');
                    fclose($file_mensagemSons_sainda_aberto);
                    return $codigoMensagem_saida;
                }
            }
        }
    }
}
