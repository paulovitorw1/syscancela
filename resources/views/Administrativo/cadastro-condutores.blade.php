@extends('Layout.administrativo')

@section('body')
<div class="ui container containerPrincipal segment" id="containerToInformations">
    <div class="ui tablet only mobile only three column doubling grid">
        <div class="column">
            <h1 class="textoTopoOuvidoria"><i class="plus square icon"></i>&nbsp;Cadastro de condutores</h1>
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
            <h1 class="textoTopoOuvidoria"><i class="plus square icon"></i>&nbsp;Cadastro de condutores</h1>
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
            <h4 class="ui header">Possibilita a adição, edição e exclusão de condutores no sistema.</h4>
        </div>
        <div class="column">
            <div class="ui search" style="float: right; border-radius: 0% !important;">
                <div class="ui icon input">
                    <input class="prompt" type="text" id="campo_pesquisa" name="campo_pesquisa"
                    placeholder="Pesquisa..." style="width: 300px;" autofocus>
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        </div>
    </div>
    
    <div class="ui computer only column doubling grid">
        <div class="column">
            <h2>Dados do condutor</h2>
        </div>
    </div>
    
    <form class="ui form" id="cadastro_condutor" name="cadastro_condutor" method="POST" enctype="multipart/form-data">
        <div class="ui divider"></div>
        <div class="ui three column doubling stackable grid">
            <div class="column">
                <div class="ui cards">
                    <div class="card" style="border-radius: 0% !important;">
                        <div class="blurring dimmable image">
                            <div class="ui dimmer">
                                <div class="content">
                                    <div class="center">
                                        <div class="ui inverted button">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img src="{{ asset('img/image.png') }}" id="imagem_pessoa" style="border-radius: 0% !important;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="column" id="coluna1">
                <div class="field" id="d_identificacao_pessoa">
                    <input type="hidden" name="curso_id" id="curso_id" value="">
                    <input type="hidden" name="pessoa_tipo_id" id="pessoa_tipo_id" value="">

                    <label>Identificação:</label>
                    <input type="text" name="identificacao_pessoa" id="identificacao_pessoa" autocomplete="off">
                    <span id="msg_erros" class="identificacao_pessoa"></span>
                </div>
                <div class="field" id="d_nome_pessoa">
                    <label>Nome:</label>
                    <input type="text" name="nome_pessoa" id="nome_pessoa" autocomplete="off">
                    <span id="msg_erros" class="nome_pessoa"></span>
                    
                </div>
                <div class="field" id="d_curso_pessoa">
                    <label>Curso/Setor:</label>
                    <input type="text" name="curso_pessoa" id="curso_pessoa" autocomplete="off">
                    <span id="msg_erros" class="curso_pessoa"></span>
                    
                </div>
                <div class="field" id="d_telefone_pessoa">
                    <label>Telefone:</label>
                    <input type="text" name="telefone_pessoa" id="telefone_pessoa" autocomplete="off">
                    <span id="msg_erros" class="telefone_pessoa"></span>
                </div>
                <div id="motivo_visitante_append">
                    
                </div>
            </div>
            <div class="column" id="coluna2">
                <div class="field" id="d_numero_cartao">
                    <label>Número do cartão:</label>
                    <input type="text" id="numero_cartao" name="numero_cartao" autocomplete="off">
                    <span id="msg_erros" class="numero_cartao"></span>
                </div>
                <div class="field" id="d_tipo_pessoa">
                    <label>Tipo:</label>
                    <input type="text" name="tipo_pessoa" id="tipo_pessoa">
                    <span id="msg_erros" class="tipo_pessoa"></span>
                </div>
                <div class="field" id="d_cpf_pessoa">
                    <label>CPF:</label>
                    <input type="text" name="cpf_pessoa" id="cpf_pessoa">
                    <span id="msg_erros" class="cpf_pessoa"></span>
                    
                </div>
                <div class="field" id="d_email_pessoa">
                    <label>E-mail:</label>
                    <input type="text" name="email_pessoa" id="email_pessoa">
                    <span id="msg_erros" class="email_pessoa"></span>
                </div>
                <div id="prazo_final_visitante_append">
                    
                </div>
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
            <div class="column">
                <button type="button" class="ui blue right floated button" id="novo_cadastro_veiculo">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">Novo</font>
                    </font>
                </button>
            </div>
        </div>
        <div class="ui divider"></div>
        <div class="ui  floating red message" id="message_veiculos">
            <p>Você tem que cadastrar pelo menos um veiculo!</p>
        </div>
        <div class="ui stackable blurring tree column grid" id="veiculos">
            
        </div>
        
        <div id="butons" class="butonsCadastro">
            <button class="ui red button" id="limpar_tela" type="reset" name="limpar_tela">Limpar</button>
            <button class="ui button" type="submit" style="background-color: #006944 !important; color: white;"
            id="buttonSalvarForm">Salvar</button>
        </div>
    </form>
</div>
</div>

<div class="ui large modal" id="modalCadastroVeiculos">
    <i class="close icon"></i>
    <div class="header">
        <h2 class="textoTopoOuvidoria" style="color: #006944;"><i class="plus square icon"></i>&nbsp;Cadastro de
            veículo</h2>
        </div>
        <div class="content">
            <form class="ui form" id="formulario_veiculos">
                {{ csrf_field()}}
                {{method_field('POST')}}
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="ui special cards">
                            <div class="card" style="border-radius: 0% !important;">
                                <div class="blurring dimmable image">
                                    <div class="ui dimmer">
                                        <div class="content">
                                            <div class="center">
                                                <div class="ui inverted button btn-file">
                                                    <span id="text-btn-file">Adicionar foto</span>
                                                    <input type="file" id="upload_imagem_veiculo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{ asset('img/image.png') }}" id="imagem_veiculo" style="border-radius: 0% !important;">
                                </div>
                            </div>
                        </div>
                        <span id="msg_erros" class="upload_imagem_veiculo"></span>
                    </div>
                    <div class="column">
                        <div class="field inputsFormVeiculo" id="d_tipo_veiculo">
                            <label>Veiculo:</label>
                            <div class="ui fluid search selection dropdown tipo_veiculo">
                                <input type="hidden" id="tipo_veiculo" name="tipo_veiculo" />
                                <i class="dropdown icon"></i>
                                <div class="default text">Selecione a cor:</div>
                                <div class="menu">
                                    <div class="item" data-value="carro">
                                        <i class="car icon"></i>Carro
                                    </div>
                                    <div class="item" data-value="moto">
                                        <i class="motorcycle icon"></i>Moto
                                    </div>
                                </div>
                                <span id="msg_erros" class="tipo_veiculo"></span>
                            </div>
                            <span id="msg_erros" class="veiculo"></span>
                        </div>
                        <div class="field inputsFormVeiculo" id="d_modelo">
                            <label>Modelo:</label>
                            <input type="text" name="modelo" id="modelo">
                            <span id="msg_erros" class="modelo"></span>
                        </div>
                        <div class="field inputsFormVeiculo" id="d_cor">
                            <label>Cor:</label>
                            <div class="ui fluid search selection dropdown cor">
                                <input type="hidden" name="cor" id="cor" />
                                <i class="dropdown icon"></i>
                                <div class="default text">Selecione a cor:</div>
                                <div class="menu">
                                    <div class="item" data-value="branco">
                                        <i class="stop icon" style="color:white"></i>Branco
                                    </div>
                                    <div class="item" data-value="preto">
                                        <i class="stop icon" style="color:black"></i>Preto
                                    </div>
                                    <div class="item" data-value="prata">
                                        <i class="stop icon" style="color:silver"></i>Prata
                                    </div>
                                    <div class="item" data-value="azul veneza">
                                        <i class="stop icon" style="color:#94C1C7"></i>Azul Veneza
                                    </div>
                                    <div class="item" data-value="amarelo">
                                        <i class="stop icon" style="color:yellow"></i>Amarelo
                                    </div>
                                    <div class="item" data-value="laranja">
                                        <i class="stop icon" style="color:orange"></i>Laranja
                                    </div>
                                    <div class="item" data-value="roxo ipe">
                                        <i class="stop icon" style="color:#766C93"></i>Roxo ipê
                                    </div>
                                    <div class="item" data-value="roxo ipe">
                                        <i class="stop icon" style="color:#766C93"></i>Roxo ipê
                                    </div>
                                    <div class="item" data-value="azul caribe">
                                        <i class="stop icon" style="color:#1C254A"></i>Azul caribe
                                    </div>
                                    <div class="item" data-value="vermelho asti">
                                        <i class="stop icon" style="color:#6B2138"></i>Vermelho asti
                                    </div>
                                    <div class="item" data-value="vermelho">
                                        <i class="stop icon" style="color:red"></i>Vermelho
                                    </div>
                                    <div class="item" data-value="marron">
                                        <i class="stop icon" style="color:brown"></i>Marron
                                    </div>
                                    <div class="item" data-value="azul">
                                        <i class="stop icon" style="color:blue"></i>Azul
                                    </div>
                                    <div class="item" data-value="cinza">
                                        <i class="stop icon" style="color:grey"></i>Cinza
                                    </div>
                                    <div class="item" data-value="bege">
                                        <i class="stop icon" style="color:beige"></i>Bege
                                    </div>
                                    <div class="item" data-value="Ouro">
                                        <i class="stop icon" style="color:gold"></i>Ouro
                                    </div>
                                    <div class="item" data-value="rosa">
                                        <i class="stop icon" style="color:pink"></i>Rosa
                                    </div>
                                    <div class="item" data-value="roxo">
                                        <i class="stop icon" style="color:purple"></i>Roxo
                                    </div>
                                    <div class="item" data-value="fantasia">
                                        <i class="stop icon" style=""></i>Fantasia
                                    </div>
                                </div>
                            </div>
                            <span id="msg_erros" class="cor"></span>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field inputsFormVeiculo" id="d_placa">
                            <label>Placa:</label>
                            <input type="text" name="placa" id="placa">
                            <span id="msg_erros" class="placa"></span>
                        </div>
                        <div class="field inputsFormVeiculo" id="d_marca">
                            <label>Marca:</label>
                            <div class="ui fluid search selection dropdown marca">
                                <input type="hidden" name="marca" id="marca" />
                                <i class="dropdown icon"></i>
                                <div class="default text">Selecione uma marca:</div>
                                <div class="menu">
                                    <div class="item" data-value="Abarth">Abarth</div>
                                    <div class="item" data-value="Alfa Romeo">Alfa Romeo</div>
                                    <div class="item" data-value="Austin">Austin</div>
                                    <div class="item" data-value="Bentley">Bentley</div>
                                    <div class="item" data-value="Cadillac">Cadillac</div>
                                    <div class="item" data-value="Chrysler">Chrysler</div>
                                    <div class="item" data-value="Dacia">Dacia</div>
                                    <div class="item" data-value="Datsun">Datsun</div>
                                    <div class="item" data-value="Ferrari">Ferrari</div>
                                    <div class="item" data-value="Hobby">Hobby</div>
                                    <div class="item" data-value="Infiniti">Infiniti</div>
                                    <div class="item" data-value="JDM">JDM</div>
                                    <div class="item" data-value="Lamborghini">Lamborghini</div>
                                    <div class="item" data-value="Lexus">Lexus</div>
                                    <div class="item" data-value="Lotus">Lotus</div>
                                    <div class="item" data-value="Ma">Mazda</div>
                                    <div class="item" data-value="Microcar">Microcar</div>
                                    <div class="item" data-value="Morris">Morris</div>
                                    <div class="item" data-value="Peugeot">Peugeot</div>
                                    <div class="item" data-value="Rolls Royce">Rolls Royce</div>
                                    <div class="item" data-value="Seat">Seat</div>
                                    <div class="item" data-value="SsangYong">SsangYong</div>
                                    <div class="item" data-value="Tesla">Tesla</div>
                                    <div class="item" data-value="UMM">UMM</div>
                                    <div class="item" data-value="Adria">Adria</div>
                                    <div class="item" data-value="Aston Martin">Aston Martin</div>
                                    <div class="item" data-value="Bertone">Bertone</div>
                                    <div class="item" data-value="Challenger">Challenger</div>
                                    <div class="item" data-value="Citroen">Citroen</div>
                                    <div class="item" data-value="Daewoo">Daewoo</div>
                                    <div class="item" data-value="Dodge">Dodge</div>
                                    <div class="item" data-value="Fiat">Fiat</div>
                                    <div class="item" data-value="Honda">Honda</div>
                                    <div class="item" data-value="Isuzu">Isuzu</div>
                                    <div class="item" data-value="Jeep">Jeep</div>
                                    <div class="item" data-value="Lancia">Lancia</div>
                                    <div class="item" data-value="Ligier">Ligier</div>
                                    <div class="item" data-value="Maserati">Maserati</div>
                                    <div class="item" data-value="Mercedes-Bens">Mercedes-Bens</div>
                                    <div class="item" data-value="MINI">MINI</div>
                                    <div class="item" data-value="Nissan">Nissan</div>
                                    <div class="item" data-value="Porsche">Porsche</div>
                                    <div class="item" data-value="Rover">Rover</div>
                                    <div class="item" data-value="Skoda">Skoda</div>
                                    <div class="item" data-value="Subaru">Subaru</div>
                                    <div class="item" data-value="Toyota">Toyota</div>
                                    <div class="item" data-value="Vauxhall">Vauxhall</div>
                                    <div class="item" data-value="Aixam">Aixam</div>
                                    <div class="item" data-value="Audi">Audi</div>
                                    <div class="item" data-value="Benimar">Benimar</div>
                                    <div class="item" data-value="BMW">BMW</div>
                                    <div class="item" data-value="Chevrolet">Chevrolet</div>
                                    <div class="item" data-value="Corvette">Corvette</div>
                                    <div class="item" data-value="Daihatsu">Daihatsu</div>
                                    <div class="item" data-value="DS">DS</div>
                                    <div class="item" data-value="Ford">Ford</div>
                                    <div class="item" data-value="Hyundai">Hyundai</div>
                                    <div class="item" data-value="Jaguar">Jaguar</div>
                                    <div class="item" data-value="Kia">Kia</div>
                                    <div class="item" data-value="Land Rover">Land Rover</div>
                                    <div class="item" data-value="Lincoln">Lincoln</div>
                                    <div class="item" data-value="Maybach">Maybach</div>
                                    <div class="item" data-value="MG">MG</div>
                                    <div class="item" data-value="Mitsubishi">Mitsubishi</div>
                                    <div class="item" data-value="Opel">Opel</div>
                                    <div class="item" data-value="Renault">Renault</div>
                                    <div class="item" data-value="Saab">Saab</div>
                                    <div class="item" data-value="Smart">Smart</div>
                                    <div class="item" data-value="Suzuki">Suzuki</div>
                                    <div class="item" data-value="Triumph">Triumph</div>
                                    <div class="item" data-value="Volkswagen">Volkswagen</div>
                                    <div class="item" data-value="Daimler">Daimler</div>
                                    <div class="item" data-value="General Motors">General Motors</div>
                                    <div class="item" data-value="GMC">GMC</div>
                                    <div class="item" data-value="Harley-Davidson">Harley-Davidson</div>
                                    <div class="item" data-value="Dongfeng Motors">Dongfeng Motors</div>
                                    <div class="item" data-value="Volvo">Volvo</div>
                                    <div class="item" data-value="AJP">AJP</div>
                                    <div class="item" data-value="Benelli">Benelli</div>
                                </div>
                            </div>
                            <span id="msg_erros" class="marca"></span>
                        </div>
                        <div class="field inputsFormVeiculo" id="d_ano">
                            <label>Ano:</label>
                            <input type="text" name="ano" id="ano" min="4" max="5" placeholder="Ano">
                            <span id="msg_erros" class="ano"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions">
                <div class="ui red button" id="limpar_modal_veiculo">
                    Limpar
                </div>
                <button id="salvar_modal" type="submit" class="ui right button"
                style="background-color: #006944 !important; color: white;">
                Salvar
            </button>
        </div>
    </form>
</div>  
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/cadastroCondutor.css') }}">
@endsection

@section('js')
<script src="{{ asset('libs/js/jquery.mask.js') }}"></script>
<script src="{{ asset('libs/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('libs/js/jquery.autocomplete.js') }}"></script>
<script src="{{ asset('libs/js/calendar.min.js') }}"></script>
<script src="{{ asset('js/cadastro-condutores.js') }}"></script>
@endsection