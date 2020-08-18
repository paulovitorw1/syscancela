@extends('Layout.login')
@section('content')
<!-- <div class="ui centered grid">
    <div class="ui vertical stripe quote segment" id="logos">
        <div class="ui equal width stackable internally grid">
            <div class="center aligned row">
                <div class="column">
                    <img src="{{ asset('img/logo-ifce.png') }}" class="imageIfce">
                    <br>
                </div>
            </div>
            <div class="center aligned row">
                <div class="column">
                    <img src="{{ asset('img/banco_vermelha.png') }}" class="image">
                    <center>
                        <div class="column" style="width:50%;">
                            @forelse($errors->all() as $error)
                            <div class="ui error message">
                                <div class="header">
                                    Erro no login, motivo:
                                </div>
                                <ul class="list">
                                    @if ($error)
                                    <li>{{ $error }}</li>
                                    @endif
                                </ul>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="sixteen wide tablet sixteen wide computer sixteen wide mobile column" id="formCenter">
        <div class="login-triangle"></div>
        <div class="divForm">
            <form class="ui large form" method="POST" action="{{route('login')}}">
                {{ csrf_field() }}
                <div class="divForm">
                    <div class="ui equal width grid">
                        <div class="row">
                            <div class="column">
                                <label>Nome</label>
                                <input type="text" name="nomeUser" id="nomeUser">
                                <span id="msg_erros" class="nomeUser"></span>
                            </div>
                        </div>
                        <div class="row" id="columnPassword">
                            <div class="column ">
                                <label>Senha</label>
                                <input type="password" name="password" id="password">
                                <span id="msg_erros" class="password"></span>
                            </div>
                            <div class="column">
                                <label id="tipo_rasp">Confirmar senha</label>
                                <input type="password" name="password_confirmation" id="password_confirmation">

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="informacoes">
            <span class="">CTI - Coordenadoria de Tecnologia da Informação</span><br>
            <span class="">NDS - Núcleo de Desenvolvimento de Software 2020</span>
        </div>
    </div>
</div> -->
<div class="ui centered grid">
    <div class="ui vertical stripe quote segment" id="logos">
        <div class="ui equal width stackable internally grid">
            <div class="center aligned row">
                <div class="column">
                    <img src="{{ asset('img/logo-ifce.png') }}" class="imageIfce">
                    <br>
                </div>
            </div>
            <div class="center aligned row">
                <div class="column">
                    <img src="{{ asset('img/banco_vermelha.png') }}" class="image">
                    <center>
                        <div class="column" style="width:50%;">
                            @forelse($errors->all() as $error)
                            <div class="ui error message">
                                <div class="header">
                                    Erro no login, motivo:
                                </div>
                                <ul class="list">
                                    @if ($error)
                                    <li>{{ $error }}</li>
                                    @endif
                                </ul>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="sixteen wide tablet sixteen wide computer sixteen wide mobile column" id="formCenter">
        <div class="login-triangle"></div>
        <div class="divForm">
            <form class="ui large form" method="POST" action="{{route('login')}}">
                {{ csrf_field() }}
                <div class="divForm">
                    <div class="field" id="identificacao">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="identificacao" value="{{old('identificacao')}}"
                                placeholder="Identificação">
                        </div>
                    </div>
                    <div class="field" id="password">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="Senha">
                        </div>
                    </div>
                    <div class="ui form row">
                        <button type="submit" class="ui fluid button"
                            style="background-color: transparent; color:white;  border: 1px solid white; ">
                            <font style="vertical-align: inherit;">Login</font>
                        </button>
                    </div>
                </div>
                <div class="ui message">
                    <a class="item" href="password/reset" style="color: white;">Esqueceu sua senha?</a>
                    <br><br>
                    <a class="item" href="#" style="color: white;">Manual do Usuário</a>
                </div>
            </form>
        </div>
        <div class="informacoes">
            <span class="">CTI - Coordenadoria de Tecnologia da Informação</span><br>
            <span class="">NDS - Núcleo de Desenvolvimento de Software 2020</span>
        </div>
    </div>
</div>
@endsection