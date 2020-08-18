@extends('Layout.administrativo')
@section('body')
<div class="ui container containerPrincipal" id="containerToInformations" style="">
    <h1 class="textoTopoOuvidoria"><i class="users icon"></i>&nbsp;&nbsp;Trânsito</h1>
    <div class="ui divider"></div>
    <div class="">
        <div class=" ui containerPrincipal segment" id="containerPrincipal">
            <form class="ui form" name="form_transito" id="form_transito" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="file" name="fotoPessoa">
                <h4 class=" ui header" style="margin-top:0%;">
                    Informa ao operador do sistema sobre as trânsitos efetivados tanto na cancela de entrada como a de
                    saída.
                    Possibilitando a seleção de veículo específico no qual o condutor está transitando no campus.
                </h4>
                <div class="dadosPessoais">
                    <div class="ui two column stackable grid">
                        <div class="column">
                            <h2 class="ui header">Dados da Condutor</h2>
                        </div>
                        <div class="column">
                            <button id="btnSaida" class="ui button"
                                style="float: right; background-color: #34483E; color: white; display:none;">
                                SAÍDA
                            </button>
                            <button id="btnEntrada" class="ui button"
                                style="float: right; background-color: #34483E; color: white; display:none;">
                                ENTRADA
                            </button>

                        </div>
                    </div>
                    <div class="ui divider"></div>

                    <div class="three fields">
                        <div class="field">
                            <div class="ui card" id="card_foto_condutor">
                                <div class="image">
                                    <img id="img_transito_condutor" src="{{asset('img/user.png')}}" />
                                </div>
                            </div>
                        </div>
                        <div class=" field">
                            <input type="hidden" id="condutor_id" name="condutor_id" value="">
                            <input type="hidden" id="veiculo_id" name="veiculo_id" value="">
                            <input type="hidden" id="tipo_cancela" name="tipo_cancela" value="">
                            <label>Nome</label>
                            <input class="margins-transito" type="text" name="nome_transito" id="nome_transito"
                                disabled="disabled">
                            <label>Matrícula</label>
                            <input class="margins-transito" type="text" name="matricula_transito"
                                id="matricula_transito" disabled="disabled">
                            <label class="espaco">Tipo</label>
                            <input class="margins-transito" type="text" name="tipo_pessoa_transito"
                                id="tipo_pessoa_transito" maxlength="14" disabled="disabled">
                            <label class="espaco">Curso/Setor</label>
                            <input class="margins-transito" type="text" name="curso_setor_transito"
                                id="curso_setor_transito" placeholder="Email" disabled="disabled">
                            <label class="espaco">Telefone</label>
                            <input class="margins-transito" type="text" name="telefone_transito" id="telefone_transito"
                                placeholder="identidade" disabled="disabled">
                        </div>
                        <div class="field">
                            <table id="tab_ultimos_condu" class="ui compact small table">
                                <thead>
                                    <tr>
                                        <th>
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">Ultimos acessos</font>
                                            </font>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table_condutor_nome">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="othersInformations" style="display:none;">
                </div>
                <div class="ui equal width grid">
                    <div class="column">
                        <label id="label_veiculo">Selecionar veículo</label>
                        <h2 class="ui dividing header" id="h2_veiculos">Veículos cadastrados</h2>
                        <div class="ui toggle checkbox" id="div_checkbox_veiculos">
                            <input type="checkbox" name="public" id="checkbox_veiculos">
                            <label></label>
                        </div>
                    </div>
                </div>
                <div class="ui stackable blurring three column grid" id="veiculos">
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/transito.css') }}">
@endsection

@section('js')

<script type="text/javascript" src="{{ asset('libs/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libs/js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libs/js/dataTables.semanticui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/transito.js') }}"></script>
@endsection