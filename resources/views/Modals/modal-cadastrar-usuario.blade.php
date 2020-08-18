<div class="ui modal modalCadastroUser" id="modalCadastroUser">
    <i class="close icon"></i>
    <div class="header" id="modal-title">
        Cadastro de usuários
    </div>
    <div class="content">
        <form method="POST" class="ui form" id="formulario_usuario">
            <input type="hidden" id="idUser" name="idUser" value="">
            <div class="ui two column doubling stackable grid">
                <div class="column">
                    <div class="field" id="d_nome">
                        <label>Nome</label>
                        <input type="text" name="nome" id="nomeUser">
                        <span id="msg_erros" class="nome"></span>
                    </div>
                    <div class="field" id="d_email">
                        <label>E-mail</label>
                        <input type="text" name="email" id="email">
                        <span id="msg_erros" class="email"></span>
                    </div>
                    <div class="field " id="d_password">
                        <label>Senha</label>
                        <input type="password" name="password" id="password">
                        <span id="msg_erros" class="password"></span>
                    </div>
                    <div class="field" id="data_atualizacaoField">
                        <label>Data de ultima atualização</label>
                        <input type="text" name="data_atualizacao" id="data_atualizacao">
                        <span id="msg_erros" class="data_atualizacao"></span>
                    </div>
                </div>
                <div class="column">
                    <div class="field" id="d_identificacao">
                        <label>Identificação</label>
                        <input type="text" name="identificacao" id="identificacao">
                        <span id="msg_erros" class="identificacao"></span>
                    </div>
                    <div class="field" id="column_permissao_view">
                        <label>Permissão</label>
                        <input type="text" name="permissao_view" id="permissao_view">
                        <span id="msg_erros" class="permissao_view"></span>
                    </div>
                    <div class="field" id="d_permissao">
                        <label id="tipo_permissao">Permissão</label>
                        <select class="ui selection dropdown" id="permissao" name="permissao">
                            @foreach ($consultaPermissao as $permissao)
                            <option value="">Selecionar tipo</option>
                            <option value="{{ $permissao->permissao_id }}">{{ $permissao->permissao_descricao }}
                            </option>
                            @endforeach
                        </select>
                        <span id="msg_erros" class="permissao"></span>
                    </div>
                    <div class="field" id="d_password_confirmation">
                        <label id="tipo_rasp">Confirmar senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation">
                        {{-- <span id="msg_erros" class="password_confirmation"></span> --}}
                    </div>
                    <div class="field" id="data_de_criacaoField">
                        <label>Data de criação</label>
                        <input type="text" name="data_de_criacao" id="data_de_criacao">
                        <span id="msg_erros" class="data_de_criacao"></span>
                    </div>
                </div>
                <div class="column" id="colunmBtns">
                    <div class="actions" id="btn_cancelar">
                        <input id="btn_cancelarr" type="button" class="ui actions red deny button" value="Limpar">
                    </div>

                    <!-- <div class="actions" id="btn_cancelar">
                        <button id="btn_cancelarr" type="button" class="ui actions red deny button">Cancelar</button>
                    </div> -->
                    <input id="btn_limpar" type="reset" class="ui red button btn-acoes" value="Limpar">
                    <input id="adicionarUser" type="submit" class="ui right button btn-acoes" value="Salvar">
                </div>
            </div>
        </form>
    </div>
</div>