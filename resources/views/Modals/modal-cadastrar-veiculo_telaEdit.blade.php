<div class="ui large modal" id="modalCadastroVeiculos">
    <i class="close icon"></i>
    <div class="header">
        <h2 class="textoTopoOuvidoria" style="color: #006944;"><i class="plus square icon"></i>&nbsp;Cadastro de
            veículo</h2>
    </div>
    <div class="content">
        <form class="ui form" id="formulario_veiculos" enctype="multipart/form-data">
            {{ csrf_field()}}
            {{method_field('POST')}}
            <input type="hidden" value="" id="condutor_idEdit" name="condutor_idEdit">
            <div class="ui three column doubling stackable grid">
                <div class="column">
                    <div class="ui special cards">
                        <div class="card" style="border-radius: 0% !important;">
                            <div class="blurring dimmable image">
                                <div class="ui dimmer">
                                    <div class="content">
                                        <div class="center">
                                            <div class="ui inverted button btn-file_edit">
                                                <span id="text-btn-file">Adicionar foto</span>
                                                <input type="file" id="upload_imagem_veiculo" name="upload_file">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img src="{{ asset('img/image.png') }}" id="imagem_veiculo_novo"
                                    style="border-radius: 0% !important;">
                            </div>
                        </div>
                    </div>
                    <span id="msg_erros" class="upload_imagem_veiculo"></span>
                </div>
                <div class="column">
                    <div class="field inputsFormVeiculo" id="d_tipo_veiculo">
                        <label>Veiculo:</label>
                        <div class="ui fluid search selection dropdown tipo_veiculo_novo">
                            <input type="hidden" id="tipo_veiculo_novo" name="tipo_veiculo_novo" />
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
                            <span id="msg_erros" class="tipo_veiculo_novo"></span>
                        </div>
                        <span id="msg_erros" class="veiculo"></span>
                    </div>
                    <div class="field inputsFormVeiculo" id="d_modelo">
                        <label>Modelo:</label>
                        <input type="text" name="modelo_novo" id="modelo_novo">
                        <span id="msg_erros" class="modelo_novo"></span>
                    </div>
                    <div class="field inputsFormVeiculo" id="d_cor">
                        <label>Cor:</label>
                        <div class="ui fluid search selection dropdown cor_novo">
                            <input type="hidden" name="cor_novo" id="cor_novo" />
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
                        <input type="text" name="placa_novo" id="placa_novo">
                        <span id="msg_erros" class="placa_novo"></span>
                    </div>
                    <div class="field inputsFormVeiculo" id="d_marca">
                        <label>Marca:</label>
                        <div class="ui fluid search selection dropdown marca_novo">
                            <input type="hidden" name="marca_novo" id="marca_novo" />
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
                        <input type="text" name="ano_novo" id="ano_novo" min="4" max="5" placeholder="Ano">
                        <span id="msg_erros" class="ano_novo"></span>
                    </div>
                </div>
            </div>
    </div>
    <div class="actions">
        <div class="ui red button" id="limpar_modal_veiculo">
            Limpar
        </div>
        <button id="salvar_modalVeiculoNovo" type="button" class="ui right button"
            style="background-color: #006944 !important; color: white;">
            Salvar
        </button>
    </div>
    </form>
</div>