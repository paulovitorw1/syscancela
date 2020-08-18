@extends('Layout.login')
@section('content')
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
    <div class="sixteen wide tablet sixteen wide computer sixteen wide mobile column" id="formCenterReset">
        <div class="login-triangle"></div>
        <div class="divForm">
            <form class="ui large form" method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="divForm">
                    <div class="ui equal width grid">
                        {{-- <div class="row">
                            <div class="column">
                                <label>E-mail</label>
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ $email or old('email') }}"  autofocus placeholder="E-mail" style="margin-top: 1%;">
                                <span id="msg_erros" class="nomeUser"></span>
                            </div>
                        </div> --}}
                        <div class="row" id="columnPassword">
                            <div class="column ">
                                <label style="float: left;">Senha</label>
                                <input id="password" type="password" class="form-control" name="password" required
                                    placeholder="Senha" style="margin-top: 1%;">
                                <span id="msg_erros" class="password"></span>
                            </div>
                            <div class="column">
                                <label style="float: left;">Confirmar senha</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required placeholder="Confirmar senha" style="margin-top: 1%;">

                            </div>
                        </div>
                    </div>
                    <div class="ui form row">
                        <button type="submit" class="ui fluid button"
                            style="background-color: transparent;color:white;border: 1px solid white;margin-top: 2%;">
                            <font style="vertical-align: inherit;">Enviar</font>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="informacoes">
            <span class="">CTI - Coordenadoria de Tecnologia da Informação</span><br>
            <span class="">NDS - Núcleo de Desenvolvimento de Software 2020</span>
        </div>
    </div>
</div>
<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection

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
    <div class="sixteen wide tablet sixteen wide computer sixteen wide mobile column" id="formCenterReset">
        <div class="login-triangle"></div>
        <div class="divForm">
            <form class="ui large form" method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="divForm">
                    <div class="ui equal width grid">
                        <div class="row">
                            <div class="column">
                                <label>E-mail</label>
                                <input id="email" type="email" class="" name="email"
                                    value="{{ $email or old('email') }}" required autofocus>
                                <span id="msg_erros" class="nomeUser"></span>
                            </div>
                        </div>
                        <div class="row" id="columnPassword">
                            <div class="column ">
                                <label>Senha</label>
                                <input id="password" type="password" class="" name="password" required>
                                <span id="msg_erros" class="password"></span>
                            </div>
                            <div class="column">
                                <label id="tipo_rasp">Confirmar senha</label>
                                <input id="password-confirm" type="password" class="" name="password_confirmation"
                                    required>

                            </div>
                        </div>
                    </div>
                    <div class="ui form row">
                        <button type="submit" class="ui fluid button"
                            style="background-color: transparent; color:white;  border: 1px solid white; ">
                            <font style="vertical-align: inherit;">Login</font>
                        </button>
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