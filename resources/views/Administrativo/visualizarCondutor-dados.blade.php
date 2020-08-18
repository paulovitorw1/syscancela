@extends('Layout.administrativo')
@section('body')
<style>
    #campo_pesquisa {
        border-radius: .28571429rem !important;
    }

    #imagem_pessoa {
        max-width: 100%;
        width: 1000px;
        height: 284px;
        object-fit: cover;
    }

    #cardVeiculosCadastrar {
        width: 33.33333333% !important;
    }

    #cardVeiculos {
        width: 100% !important;
    }

    #btn-apagarCard {
        margin: 0 auto;
        text-align: center;
        display: block
    }

    #tabRegistro_paginate {
        float: right !important;
    }

    .img_veiculo {
        max-width: 100% !important;
        width: 1000px !important;
        height: 284px !important;
        object-fit: cover !important;
    }
</style>
<div class="ui container containerPrincipal segment" id="containerToInformations">
    <div class="ui tablet only mobile only three column doubling grid">
        <div class="column">
            <h1 class="textoTopoOuvidoria"><i class="plus square icon"></i>&nbsp;Visualizar dados do condutor</h1>
        </div>
        <div class="column">
            <a href="javascript:history.back()" class="ui blue right floated button">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">Voltar</font>
                </font>
            </a>
        </div>
    </div>
    <div class="ui computer only two column doubling grid">
        <div class="column">
            <h1 class="textoTopoOuvidoria"><i class="plus square icon"></i>&nbsp;Visualizar dados do condutor</h1>
        </div>
        <div class="column">
            <a href="javascript:history.back()" class="ui blue right floated button">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">Voltar</font>
                </font>
            </a>
        </div>
    </div>
    <div class="ui divider"></div>
    <div class="ui two column stackable grid">
        <div class="column">
            <h4 class="ui header">Possibilita a edição de condutores no sistema.</h4>
        </div>
    </div>

    <div class="ui computer only column doubling grid">
        <div class="column">
            <h2>Dados do condutor</h2>
        </div>
    </div>

    <form class="ui form" id="edicao_condutor" name="edicao_condutor" method="POST" enctype="multipart/form-data">
        <div class="ui divider"></div>
        <div class="ui three column doubling stackable grid">
            <div class="column">
                <div class="ui  cards">
                    <div class="card">
                        <div class="blurring  image">
                            <img src="http://bd.maracanau.ifce.edu.br/uploads/image/{{ $getCondutor[0]->imagem_condutor }}"
                                id="imagem_pessoa">
                        </div>
                    </div>
                </div>
                <div id="errorTr"></div>
            </div>
            <div class="column" id="coluna1">
                <div class="field" id="d_identificacao_pessoa">
                    <label>Identificação:</label>
                    <input type="text" name="identificacao_pessoa" value="{{ $getCondutor[0]->identificacao }}"
                        id="identificacao_pessoa">
                    <span id="msg_erros" class="identificacao_pessoa"></span>
                </div>
                <div class="field" id="d_nome_pessoa">
                    <label>Nome:</label>
                    <input type="text" name="nome_pessoa" id="nome_pessoa" value="{{ $getCondutor[0]->nome }}">
                    <span id="msg_erros" class="nome_pessoa"></span>

                </div>
                @if ($getCondutor[0]->tipo != "Visitante")
                <div class="field" id="d_curso_pessoa">
                    <label>Curso/Setor:</label>
                    <input type="text" name="curso_pessoa" id="curso_pessoa" value="{{ $getCondutor[0]->setor_curso }}">
                    <span id="msg_erros" class="curso_pessoa"></span>
                </div>
                @endif

                <div class="field" id="d_telefone_pessoa">
                    <label>Telefone:</label>
                    <input type="text" name="telefone_pessoa" id="telefone_pessoa"
                        value="{{ $getCondutor[0]->telefone }}">
                    <span id="msg_erros" class="telefone_pessoa"></span>
                </div>
                @if ($getCondutor[0]->tipo == "Visitante")
                <div class="field" id="d_motivo"> <label>Motivo:</label>
                    <input type="text" name="motivo_pessoa" id="motivo_pessoa" value="{{ $getVisitante[0]->motivo }}">
                    <span id="msg_erros" class="motivo_pessoa"></span>
                </div>
                @endif
            </div>
            <div class="column" id="coluna2">
                <div class="field" id="d_numero_cartao">
                    <label>Número do cartão:</label>
                    <input type="text" id="numero_cartao" name="numero_cartao"
                        value="{{ $getCondutor[0]->numero_cartao }}">
                    <span id="msg_erros" class="numero_cartao"></span>
                </div>
                <div class="field" id="d_tipo_pessoa">
                    <label>Tipo:</label>
                    <input type="text" name="tipo_pessoa" id="tipo_pessoa" value="{{ $getCondutor[0]->tipo }}">
                    <span id="msg_erros" class="tipo_pessoa"></span>
                </div>

                @if ($getCondutor[0]->tipo != "Visitante")
                <div class="field" id="d_cpf_pessoa">
                    <label>C.P.F:</label>
                    <input type="text" name="cpf_pessoa" id="cpf_pessoa" value="{{ $getCondutor[0]->cpf }}">
                    <span id="msg_erros" class="cpf_pessoa"></span>
                </div>
                @endif

                <div class="field" id="d_email_pessoa">
                    <label>E-mail:</label>
                    <input type="text" name="email_pessoa" id="email_pessoa" value="{{ $getCondutor[0]->email }}">
                    <span id="msg_erros" class="email_pessoa"></span>
                </div>

                @if ($getCondutor[0]->tipo == "Visitante")
                <div class="field" id="d_motivo"> <label>Motivo:</label>
                    <input type="text" name="motivo_pessoa" id="motivo_pessoa"
                        value="{{ $getVisitante[0]->prazo_final }}">
                    <span id="msg_erros" class="motivo_pessoa"></span>
                </div>
                @endif
            </div>
        </div>
        <div class="ui tablet only mobile only three column doubling grid">
            <div class="column">
                <h2 class="textoTopoOuvidoria">Veiculos cadastrados</h2>
            </div>
            <div class="column">
                <a href="javascript:history.back()" class="ui blue right floated button">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Novo</font>
                    </font>
                </a>
            </div>
        </div>
        <div class="ui computer only two column doubling grid">
            <div class="column">
                <h2 class="textoTopoOuvidoria">Veiculos cadastrados</h2>
            </div>
        </div>
        <div class="ui divider"></div>
        <div class="ui stackable blurring tree column grid" id="veiculos">
            @php $counter = 1 @endphp
            @foreach ($getVeiculoByCondutor as $veiculo)
            <div class="five wide column classVeiculos" id="cardVeiculosCadastrar">
                <div class="ui  card cardVeiculos" id="cardVeiculos" data-id="cardV_{{$counter  }}">
                    <div class="image">
                        <img class="ui small rounded image img_veiculo"
                            src="{{ asset('/images/'.$veiculo->img_veiculo.'') }}">
                    </div>
                    <div class="content ui attached button" style="text-align: center; background-color: gray;"><a
                            class="header"> {{ $veiculo->marca }} - {{ $veiculo->ano }} </a>
                        <div class="meta"><span style="color:black">{{ $veiculo->modelo }}</span></div>
                    </div>
                </div>
                <div id="btn-apagarCard">
                    <button class="ui gren  floated icon button" type="button"
                        onclick="visualizarDadosVeiculo({{ $veiculo->veiculo_id }})" id="btn_vi"><i
                            class="eye icon"></i></button>
                </div>
            </div>

            @php $counter ++; @endphp
            @endforeach
        </div>
    </form>
    <div class="ui large modal" id="modalVisualizarVeiculos">
        <i class="close icon"></i>
        <div class="header">
            <h2 class="textoTopoOuvidoria" style="color: #006944;"><i class="plus square icon"></i>&nbsp;Dados do
                veículo</h2>
        </div>
        <div class="content">
            <form class="ui form" id="formulario_veiculosVisualizar">
                {{ csrf_field()}}
                {{method_field('POST')}}
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="ui special cards">
                            <div class="card" style="border-radius: 0% !important;">
                                <div class="blurring  image">
                                    <img src="" id="imagem_veiculo"
                                        style="border-radius: 0% !important;">
                                </div>
                            </div>
                        </div>
                        <span id="msg_erros" class="upload_imagem_veiculo"></span>
                    </div>
                    <div class="column">
                        <div class="field inputsFormVeiculo" id="d_veiculo">
                            <label>Veiculo:</label>
                            <input type="text" name="veiculo_visualizar" id="veiculo_visualizar">
                            <span id="msg_erros" class="veiculo_visualizar"></span>
                        </div>
                        <div class="field inputsFormVeiculo" id="d_modelo">
                            <label>Modelo:</label>
                            <input type="text" name="modelo_visualizar" id="modelo_visualizar">
                            <span id="msg_erros" class="modelo_visualizar"></span>
                        </div>
                        <div class="field inputsFormVeiculo" id="d_placa">
                            <label>Cor:</label>
                            <input type="text" name="cor_visualizar" id="cor_visualizar">
                            <span id="msg_erros" class="cor_visualizar"></span>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field inputsFormVeiculo" id="d_placa">
                            <label>Placa:</label>
                            <input type="text" name="placa_visualizar" id="placa_visualizar">
                            <span id="msg_erros" class="placa_visualizar"></span>
                        </div>
                        <div class="field inputsFormVeiculo" id="d_marca">
                            <label>Cor:</label>
                            <input type="text" name="marca_visualizar" id="marca_visualizar">
                            <span id="msg_erros" class="marca_visualizar"></span>
                        </div>
                        <div class="field inputsFormVeiculo" id="d_ano">
                            <label>Ano:</label>
                            <input type="text" name="ano_visualizar" id="ano_visualizar">
                            <span id="msg_erros" class="ano_visualizar"></span>
                        </div>
                    </div>
                </div>
        </div>
        <div class="actions">
            <div class="ui black deny red button" id="limpar_modal_veiculo">
                Fechar
            </div>
        </div>
        </form>
    </div>
</div>

@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/cadastroCondutor.css') }}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/editar-condutor.js') }}"></script>
@endsection