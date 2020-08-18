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
            <!-- @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif -->
            <!-- <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">

                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div> -->
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
                            {{-- @if (session()->get('error'))
                            <div class="ui error message">

                                <ul class="list">
                                    <li>{{ session()->get('error') }}</li>
                            </ul>
                        </div>
                        @endif --}}
                        @endforelse
                </div>
                </center>
                <center>
                    @if (session('status'))
                    <div class="ui success message" style="width: 50% !important;box-shadow: 0 0 0 1px #a3c293 inset, 0 0 0 0 transparent !important;">
                        <div class="header">
                            {{ session('status') }} 
                        </div>
                    </div>
                    @endif

                </center>
            </div>
        </div>
    </div>
</div>
<div class="sixteen wide tablet sixteen wide computer sixteen wide mobile column" id="formCenterEmail">
    <div class="login-triangle"></div>
    <div class="divForm">
        <form class="ui large form" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="divForm">
                <div class="field" id="identificacao">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                            required placeholder="E-mail">

                    </div>
                </div>
                <div class="ui form row">
                    <button type="submit" class="ui fluid button"
                        style="background-color: transparent; color:white;  border: 1px solid white; ">
                        <font style="vertical-align: inherit;">Enviar</font>
                    </button>
                </div>
            </div>
        </form>
        <div class="ui message">
            <a class="item" href="/" style="color: white;">Voltar</a>
        </div>
    </div>
    <div class="informacoes">
        <span class="">CTI - Coordenadoria de Tecnologia da Informação</span><br>
        <span class="">NDS - Núcleo de Desenvolvimento de Software 2020</span>
    </div>
</div>
</div>
@endsection