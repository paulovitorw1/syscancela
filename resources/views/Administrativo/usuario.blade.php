@extends('Layout.administrativo')
@section('body')
<div class="ui container segment containerPrincipal" id="containerToInformations">
    <button onclick="adicionarUsuario()" class="ui blue right floated button" type="button" id="btn-adicionar-rasp">
        <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">Novo</font>
        </font>
    </button>
    <h1>Cadastro usuário</h1>

    <div class="ui divider"></div>
    <br />
    <table class="ui green celled table" name="tabelaUsuario" id="tabelaUsuario" style="text-align: center;">
        <thead>
            <tr>
                <th>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">ID</font>
                    </font>
                </th>
                <th>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Nome</font>
                    </font>
                </th>
                <th>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Identificação</font>
                    </font>
                </th>
                <th>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">E-mail</font>
                    </font>
                </th>
                <th id="acoes_rasp">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Ações</font>
                    </font>
                </th>
            </tr>
        </thead>
    </table>
</div>
@include('Modals.modal-cadastrar-usuario')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/usuario.css') }}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('libs/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libs/js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libs/js/dataTables.semanticui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/usuario.js') }}"></script>
@endsection