<style>
    #modal_visualizar {
        width: 97%;
        margin: 1% 0% 3% 0%;
    }

    #dadosDoVeiculo {
        margin-top: 3%;

    }

    #cardFotoVeiculoModal {
        width: 100% !important;
    }

    #imgTransitoVeiculoModal {
        max-width: 100%;
        width: 100%;
        height: 325px;
        object-fit: cover;
    }

    #imgTransitoModal {
        max-width: 100%;
        width: 100%;
        height: 325px;
        object-fit: cover;
    }

    #cardFotoCondutorModal {
        width: 100% !important;
    }
</style>
<div class="ui modal"> <i class="close icon"></i>
    <div class="header">
        Dados do Registro
    </div>
    <div class="ui container containerPrincipal" id="modal_visualizar">
        <form class="ui form" name="formModalvisualizar" id="formModalvisualizar" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" id="file" name="fotoPessoa">
            <div class="dadosPessoais">
                <div class="two fields">
                    <div class="field">
                        <div class="ui card" id="cardFotoCondutorModal">
                            <div class="image">
                                <img id="imgTransitoModal" src="{{asset('img/user.png')}}" />
                            </div>
                        </div>
                    </div>
                    <div class=" field">
                        <input type="hidden" id="condutor_id" name="condutor_id" value="">
                        <input type="hidden" id="veiculo_id" name="veiculo_id" value="">
                        <input type="hidden" id="tipo_cancela" name="tipo_cancela" value="">
                        <label>Nome</label>
                        <input class="margins-transito" type="text" name="nomeTransitoModal" id="nomeTransitoModal"
                            disabled="disabled">
                        <label>Matrícula</label>
                        <input class="margins-transito" type="text" name="matriculaTransitoModal"
                            id="matriculaTransitoModal" disabled="disabled">
                        <label class="espaco">Tipo</label>
                        <input class="margins-transito" type="text" name="TipoTransitoModal" id="TipoTransitoModal"
                            maxlength="14" disabled="disabled">
                        <label class="espaco">Curso/Setor</label>
                        <input class="margins-transito" type="text" name="cursoSetorTransitoModal"
                            id="cursoSetorTransitoModal" placeholder="Email" disabled="disabled">
                        <label class="espaco">Telefone</label>
                        <input class="margins-transito" type="text" name="telefoneTransitoModal"
                            id="telefoneTransitoModal" placeholder="identidade" disabled="disabled">
                    </div>
                    {{--  <div class=" field">
                        <label>Tipo de trânsito E/S</label>
                        <input class="margins-transito" type="text" name="TipoTransitoESModal" id="TipoTransitoESModal"
                            disabled="disabled">
                        <label>E-mail</label>
                        <input class="margins-transito" type="text" name="emailTransitoModal" id="emailTransitoModal"
                            disabled="disabled">
                        <label class="espaco">Cartão RFID</label>
                        <input class="margins-transito" type="text" name="cartaoTransitoModal" id="cartaoTransitoModal"
                            maxlength="14" disabled="disabled">
                        <label class="espaco">Data do trânsito</label>
                        <input class="margins-transito" type="text" name="dataTransitoModal" id="dataTransitoModal"
                            placeholder="Email" disabled="disabled">
                        <label class="espaco">Telefone</label>
                        <input class="margins-transito" type="text" name="telefone_transito" id="telefone_transito"
                            placeholder="identidade" disabled="disabled">
                    </div>  --}}
                </div>
            </div>
            <div class="ui equal width grid">
                <div class="column">
                    <h2 class="ui dividing header" id="h2_veiculos">Veículos transitado</h2>
                </div>

            </div>
            <div class="dadosPessoais" id="dadosDoVeiculo">
                <div class="two fields" id="">
                    <div class="field" id="veiculoTransitoModal">
                    </div>
                    <div class="field" id="">
                        <label>Tipo de trânsito E/S</label>
                        <input class="margins-transito" type="text" name="TipoTransitoESModal" id="TipoTransitoESModal"
                            disabled="disabled">
                        <label class="espaco">Data do trânsito</label>
                        <input class="margins-transito" type="text" name="dataTransitoModal" id="dataTransitoModal"
                            placeholder="Email" disabled="disabled">
                        <label class="espaco">Placa</label>
                        <input class="margins-transito" type="text" name="placaTransitoModal" id="placaTransitoModal"
                            maxlength="14" disabled="disabled">
                        <label class="espaco">Marca</label>
                        <input class="margins-transito" type="text" name="marcaTransitoModal" id="marcaTransitoModal"
                            placeholder="identidade" disabled="disabled">
                        <label>Modelo</label>
                        <input class="margins-transito" type="text" name="modeloTransitoModal" id="modeloTransitoModal"
                            disabled="disabled">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui red deny button">
            Fechar
        </div>
    </div>
</div>
</div>
<link rel="stylesheet" href="{{ asset('css/transito.css') }}">