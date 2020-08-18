<!DOCTYPE html>
<html>

<head>
    <title>SysCancelas</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="{{ asset('libs/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/css/semantic.min.css') }} " />
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/css/icon.min.css') }} " />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }} " />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }} " />
    <link rel="icon" type="imagem/png" href="{{ asset('img/favicon.ico') }} " />



    @yield('css')
</head>

<body>
    <div class="ui sidebar vertical left menu overlay visible"
        style="-webkit-transition-duration: 0.1s; overflow: visible !important; background-color: #006D44 !important;">
        <div class="item logo">
            <img src="{{ asset('img/SysCancelas.png') }}" id="imgBig" />
            <img src="{{ asset('img/intra_bola_branca.png') }}" style="display: none" id="imgSmall" />
        </div>
        <div class="ui accordion">
            <a class="item " id="intranet" href="https://intranet.maracanau.ifce.edu.br/" target="_blank">
                <p class="pTitle">
                    <img src="{{ asset('img/intra_bola_branca.png') }}" id="intranetIcon">
                    <span id="textDrop">Intranet</span>
                </p>
            </a>
            <a href="javascript:history.back()" class="item notContent" id="voltar">
                <p class="pTitle"><i class="arrow alternate circle left outline icon" id="iconSidebar"></i> <span
                        id="textDrop">Voltar</span></p>
            </a>
            <a href="/admin" class="item notContent" id="paginaInicial">
                <p class="pTitle"><i class="home layout icon" id="iconSidebar"></i> <span id="textDrop">Página
                        Inicial</span></p>
            </a>
            @if(($user->permissao_id_fk) == 1 || ($user->permissao_id_fk) == 2 )
            <a href="/admin/transitos" class="item notContent" id="transito">
                <p class="pTitle"><i class="address card outline icon" id="iconSidebar"></i> <span
                        id="textDrop">Trânsito</span></p>
            </a>
            @endif
            <a href="/admin/registros" class="item notContent" id="registro">
                <p class="pTitle"><i class="file alternate icon" id="iconSidebar"></i> <span
                        id="textDrop">Registro</span></p>
            </a>
            @if(($user->permissao_id_fk) == 1 || ($user->permissao_id_fk) == 2 )
            <a href="/admin/camera" class="item notContent" id="camera">
                <p class="pTitle"><img src="{{ asset('img/camera-icon.png') }}" alt=""> <span
                        id="textDrop">Câmeras</span></p>
            </a>
            @endif
            @if(($user->permissao_id_fk) == 1 || ($user->permissao_id_fk) == 3 )
            <a class="title item" id="cadastros">
                <p class="pTitle"><i class="user icon" id="iconSidebar"></i> <span id="textDrop">Cadastros</span> <i
                        class="dropdown icon" id="dropdownIconSidebar"></i></p>
            </a>
            <div class="content cadastros" id="cadastros">
                <a class="item itemNotInSubMenu notContent" id="cadastrarCondutor"
                    href="/admin/cadastros/condutor"><span>Condutor</span>
                </a>
                @if(($user->permissao_id_fk) == 1)
                <a class="item itemNotInSubMenu notContent" id="cadastrarUsuario"
                    href="/admin/cadastros/usuario"><span>Usuário</span>
                </a>
                @endif
            </div>
            @endif
            @if(($user->permissao_id_fk) == 1 || ($user->permissao_id_fk) == 5)
            <a class="title item" id="barreira">
                <p class="pTitle"><img src="{{ asset('img/access.png') }}" alt=""> <span id="textDrop">Cancelas</span>
                    <i class="dropdown icon" id="dropdownIconSidebar"></i></p>
            </a>
            <div class="content barreiras" id="barreira">
                <a href="/cancela/entrada" class="item itemNotInSubMenu notContent" id="entrada"
                    href="#!"><span>Entrada</span>
                </a>
                <a href="/cancela/saida" class="item itemNotInSubMenu notContent" id="saida"
                    href="#!"><span>Saída</span>
                </a>
            </div>
            @endif
            @if(($user->permissao_id_fk) == 1)
            <a href="/admin/configuracoes" class="item notContent" id="configuracoes">
                <p class="pTitle"><i class="wrench icon" id="iconSidebar"></i> <span id="textDrop">Configurações</span>
                </p>
            </a>
            @endif
            <a href="/admin/ajuda" class="item notContent" id="ajuda" style="display: none;">
                <p class="pTitle"><i class="question icon" id="iconSidebar"></i> <span id="textDrop">Ajuda</span></p>
            </a>
        </div>
        <div class="" id="iconesSidebarMenor">
            <a href="https://intranet.maracanau.ifce.edu.br/" target="_blank" class="ui dropdown item displaynone"
                id="dropdownToOneIcon">
                <z>Intranet</z>
                <img src="{{ asset('img/intra_bola_branca.png') }}" style="width: 21.5px !important" id="intranet">
            </a>
            <a href="/admin" class="ui dropdown item displaynone" id="dropdownToOneIcon">
                <z>Página Inicial</z>
                <i class="home layout icon" id="paginaInicial"></i>
            </a>
            <a href="javascript:history.back()" class="ui dropdown item displaynone" id="dropdownToOneIcon">
                <z>Voltar</z>
                <i class="arrow alternate circle left outline icon" id="voltar"></i>
            </a>
            <a href="/admin/transitos" class="ui dropdown item displaynone" id="dropdownToOneIcon">
                <z>Trânsito</z>
                <i class="address card outline icon" id="transito"></i>
            </a>
            <a href="/admin/registros" class="ui dropdown item displaynone" id="dropdownToOneIcon">
                <z>Registro</z>
                <i class="file alternate icon" id="registro"></i>
            </a>
            <div class="ui dropdown link item displaynone" id="dropdownToOneIcon">
                <z>Cadastro</z>
                <i class="user icon" id="pessoa"></i>
                <div class="menu pessoa" id="dropwdownIcones">
                    <div class="header">
                        Cadastros
                    </div>
                    <div class="ui divider"></div>
                    <a class="item" href="/admin/cadastros/condutor">Condutor</a>
                    <a class="item" href="#!">Usuário</a>
                </div>
            </div>
            <div class="ui dropdown link item displaynone" id="dropdownToOneIcon">
                <z>Cancelas</z>
                <img src="{{ asset('img/access.png') }}" style="width: 25px;" id="barreira" alt="">
                <div class="menu barreira" id="dropwdownIcones">
                    <div class="header">
                        Cancelas
                    </div>
                    <div class="ui divider"></div>
                    <a class="item" href="/cancela/entrada">Entrada</a>
                    <a class="item" href="/cancela/saida">Saída</a>
                </div>
            </div>
            <a href="/admin/configuracoes" class="ui dropdown item displaynone" id="dropdownToOneIcon">
                <z>Configurações</z>
                <i class="wrench icon" id="configuracoes"></i>
            </a>
            <a href="/admin/ajuda" class="ui dropdown item displaynone" id="dropdownToOneIcon">
                <z>Ajuda</z>
                <i class="question icon" id="iconSidebar"></i>
            </a>
        </div>
    </div>
    <div class="pusher">
        <div class="ui menu asd borderless" style="" id="navbarSistema">
            <a class="item openbtn">
                <i class="icon content"></i>
            </a>
            <div class="right menu" id="iconesNavbar">
                <a class="item">
                    <i class="th icon big" id="system"></i>
                </a>

                &nbsp;&nbsp;&nbsp;
                <div class="ui popup bottom left transition hidden" id="popUpSystem">
                    <div class="ui one column relaxed equal height divided grid">
                        <div class="column">
                            <ul class="ulGeral" id="system">
                                <li class="liGeral" id="system">
                                    <a class="aGeral" id="system" href="http://frequencia.maracanau.ifce.edu.br/login" _blank>
                                        <img src="{{ asset('img/SysFrequencia.png') }}" class="imgSys">
                                        <span>SysFrequencia</span>
                                    </a>
                                </li>
                                <li class="liGeral" id="system">
                                    <a class="aGeral" id="system" href="https://bd.maracanau.ifce.edu.br/login">
                                        <img src="{{ asset('img/banco_vermelha.png') }}" class="imgSys">
                                        <span>BD Central</span>
                                    </a>
                                </li>
                                <li class="liGeral" id="system">
                                    <a class="aGeral" id="system" href="http://ouvidoria.maracanau.ifce.edu.br/">
                                        <img src="{{ asset('img/ouvidoria_verde.png') }}" class="imgSys">
                                        <span>Ouvidoria</span>
                                    </a>
                                </li>
                                <li class="liGeral" id="system">
                                    <a class="aGeral" id="system" href="https://intranet.maracanau.ifce.edu.br/sysra/restaurante">
                                        <img src="{{ asset('img/logo_sysreserva.png') }}" class="imgSys">
                                        <span>SysRA</span>
                                    </a>
                                </li>
                                <li class="liGeral" id="system">
                                    <a class="aGeral" id="system">
                                        <img src="{{ asset('img/logo_sysreserva.png') }}" class="imgSys">
                                        <span>SysReserva</span>
                                    </a>
                                </li>
                                <li class="liGeral" id="system">
                                    <a class="aGeral" id="system">
                                        <img src="{{ asset('img/logo_sysreserva.png') }}" class="imgSys">
                                        <span>SysReserva</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <a class="item">
                    <i class="bell icon big" id="notifications"></i>
                </a>
                &nbsp;&nbsp;&nbsp;
                <!--Pop Up para sistemas -->
                <div class="ui popup bottom left transition hidden" id="popUpNotifications">
                    <div class="ui one column relaxed equal height divided grid">
                        <div class="column">
                            <div class="ui comments" id="commentsNotifications">
                                <h3 class="ui dividing header">Notificações</h3>
                                <div class="comment">
                                    <a class="avatar">
                                        <img src="{{ asset('img/matt.jpg') }}">
                                    </a>
                                    <div class="content">
                                        <a class="author">Emerson Henrique</a>
                                        <div class="metadata">
                                            <span class="date">Hoje as 09:40AM</span>
                                        </div>
                                        <div class="text">
                                            Termo de compromisso de estágio disponível para download
                                        </div>
                                    </div>
                                </div>
                                <div class="comment">
                                    <a class="avatar">
                                        <img src="{{ asset('img/matt.jpg') }}">
                                    </a>
                                    <div class="content">
                                        <a class="author">Emerson Henrique</a>
                                        <div class="metadata">
                                            <span class="date">Hoje as 09:40AM</span>
                                        </div>
                                        <div class="text">
                                            Termo de compromisso de estágio disponível para download
                                        </div>
                                    </div>
                                </div>
                                <div class="comment">
                                    <a class="avatar">
                                        <img src="{{ asset('img/matt.jpg') }}">
                                    </a>
                                    <div class="content">
                                        <a class="author">Emerson Henrique</a>
                                        <div class="metadata">
                                            <span class="date">Hoje as 09:40AM</span>
                                        </div>
                                        <div class="text">
                                            Termo de compromisso de estágio disponível para download
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="idUserLogado" name="idUserLogado" value="{{$user->id}}">
                <a class="item">
                    <img class="ui avatar image openDivNone imgUser" id="informationsUser"
                        src="http://bd.maracanau.ifce.edu.br/uploads/image/{{$user->identificacao}}.jpg"
                        style="cursor: pointer;">
                </a>
                &nbsp;&nbsp;&nbsp;
                <!--Pop Up para sistemas -->
                <div class="ui popup bottom left transition hidden" id="popUpInformationUser">
                    <div class="ui one column relaxed equal height divided grid">
                        <div class="column">
                            <div class="ui cards">
                                <div class="card" id="cardUser">
                                    <div class="content">
                                        <img class="right floated medium ui image imgUser" id="informationsUser2"
                                            src="http://bd.maracanau.ifce.edu.br/uploads/image/{{$user->identificacao}}.jpg">
                                        <div class="header">
                                            {{$user->nome}}
                                        </div>
                                        <div class="meta">
                                            {{$consultaPopup[0]->permissao_descricao}}
                                        </div>
                                        <div class="description">
                                            Último acesso:<br> {{$user->ultima_atualizacao}}
                                        </div>
                                    </div>
                                    <div class="extra content">
                                        <div class="ui one buttons"
                                            style="margin: 0 auto; text-align: center; display: block">
                                            <a href="{{ route('logout') }}">
                                                <div class="ui basic red button" style="width: 100%;" onclick="event.preventDefault();
                                                 document.getElementById('formlogout').submit();">Sair</div>

                                            </a>

                                            <form id="formlogout" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                {{ csrf_field() }}
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @yield('body')
    </div>
    <script type="text/javascript" src="{{ asset('libs/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/js/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/js/semantic.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/js/jquery.mask.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>

</html>