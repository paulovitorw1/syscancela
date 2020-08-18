$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    //Ativa o menu e sub menu correspondente na navbar. 
    $('#cadastros').addClass('active');
    $('.cadastros').addClass('active');
    $('#cadastrarUsuario').addClass('active');
    //Limpando todo o formulario
    $("#btn_limpar").click(function () {
        $('.dropdown').dropdown('restore defaults');

    });

    listarUsuarios();

});


//Função para listar dados para a Tabela
function listarUsuarios() {
    //moment biblioteca para converter DATAS
    moment.locale('pt-br');
    //Criando tabela via DataTables
    var table = $('#tabelaUsuario').DataTable({
        processing: true,
        serverSide: true,
        bLengthChange: false,
        bInfo: false,
        //Rota para onde os dados será mandado.   
        ajax: "/admin/cadastros/usuario/ver",
        //Informando quais dados vão ser listado 
        columns: [
            { data: 'usuario_id', name: 'usuario_id' },
            { data: 'nome', name: 'nome' },
            { data: 'identificacao', name: 'identificacao' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        //Traduzindo a Tabela para o PORTUGUÊS
        "bJQueryUI": true,
        "oLanguage": {
            "lengthChange": false,
            "pageLength": 10,
            "sProcessing": "Processando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "Não foram encontrados resultados",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
            "sInfoFiltered": "",
            "sInfoPostFix": "",
            "sSearch": "Pesquisar: ",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Primeiro",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        }
    });
    return table;
}
//Função para chamar modal onde será Registrado um novo RaspBerry
function adicionarUsuario() {
    save_method = "adicionar";
    $('#modalCadastroUser form')[0].reset();
    $('.dropdown').dropdown('restore defaults');
    $('#adicionarUser').show();
    $('#btn_limpar').show();
    $('#d_permissao').show();
    $('#d_password_confirmation').show();
    $('#d_password').show();
    $('#data_de_criacaoField').hide();
    $('#data_atualizacaoField').hide();
    $('#btn_cancelar').hide();
    $('#column_permissao_view').hide();
    $('#adicionarUser').val('Salvar');
    $('input[name=_method').val('POST');
    $('#modalCadastroUser').modal('show')
    $('#modal-title').text('Adicionar Usuário');
    $("#formulario_usuario  #nomeUser, #identificacao, #email ").each(function () {
        $(this).attr("readonly", false);
        $(this).attr("disabled", false);

    });
}

//Função para chamar o modal de editar RaspBerry pegando o ID do dado
function editarUsuario(id) {
    save_method = "editar";
    $('#idUser').val(id);
    $('#modalCadastroUser form')[0].reset();
    $('#btn_limpar').show();
    $('#adicionarUser').show();
    $('#d_password_confirmation').show();
    $('#d_password').show();
    $('#d_permissao').show();
    $('#data_de_criacaoField').show();
    $('#data_atualizacaoField').show();
    $('#btn_cancelar').hide();
    $('#column_permissao_view').hide();
    $('input[name=_method]').val('PATCH');
    $('#modal-title').text('Editar usuário');
    $('#adicionarUser').val('Editar');
    $("#formulario_usuario  #nomeUser, #identificacao, #email ").each(function () {
        $(this).attr("readonly", false);
        $(this).attr("disabled", false);

    });

    $.ajax({
        url: "/admin/cadastros/usuario/" + id + "/editar",
        type: "GET",
        dataType: "JSON",
        success: function (data) {

            $('#modalCadastroUser').modal('show')
            $('#nomeUser').val(data.nome);
            $('#identificacao').val(data.identificacao);
            $('#email').val(data.email);
            $('select#permissao').dropdown('set selected', data.permissao_descricao);
            $('#data_de_criacao').val(moment(data.data_de_criacao).format('LL'));
            $('#data_atualizacao').val(moment(data.ultima_atualizacao).format('LL'));
            $("#formulario_usuario  #data_de_criacao, #data_atualizacao").each(function () {
                $(this).attr("readonly", true);
                $(this).attr("disabled", true);

            });

        },
        error: function (data) {
            swal({
                title: 'Oops...',
                text: data.message,
                type: 'error',
                timer: '1500'
            })
        }
    });
}
//Função para chamar o modal de editar RaspBerry pegando o ID do dado
function vizualizarUsuario(id) {
    $('#idUser').val(id);
    $('#modalCadastroUser form')[0].reset();
    console.log(id);
    save_method = "listar";
    $('#btn_cancelar').show();
    $('#column_permissao_view').show();
    $('#data_de_criacaoField').show();
    $('#data_atualizacaoField').show();
    $('#fieldDataDcriacao').hide();
    $('#adicionarUser').hide();
    $('#d_permissao').hide();
    $('#btn_limpar').hide();
    $('#d_password_confirmation').hide();
    $('#d_password').hide();
    $('#modal-title').text('Dados do usuário');
    $('input[name=_method]').val('PATCH');

    $.ajax({
        url: "/admin/cadastros/usuario/" + id + "/listar",
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('#modalCadastroUser').modal('show')
            $('#nomeUser').val(data.nome);
            $('#identificacao').val(data.identificacao);
            $('#email').val(data.email);
            $('#permissao_view').val(data.permissao_descricao);
            $('#data_de_criacao').val(moment(data.data_de_criacao).format('LL'));
            $('#data_atualizacao').val(moment(data.ultima_atualizacao).format('LL'));
            $("#formulario_usuario  #data_de_criacao, #data_atualizacao, #nomeUser, #email, #identificacao, #permissao_view").each(function () {
                $(this).attr("readonly", true);
                $(this).attr("disabled", true);

            });

        },
        error: function (data) {
            swal({
                title: 'Oops...',
                text: data.message,
                type: 'error',
                timer: '1500'
            })
        }
    });
}
//Deletando USUARIO
function deletaUsuario(id) {
    $('#idUser').val();
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    swal({
        title: 'Você tem certeza?',
        text: "Você não poderá reverter isso!",
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Sim, exclua!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "/admin/cadastros/usuario/" + id + "/delete",
                type: "POST",
                data: { '_method': 'DELETE', 'csrf-token': csrf_token },
                dataType: 'json',
                success: function (data) {
                    if (Object.keys(data) == 'sucesso') {
                        $('#tabelaUsuario').DataTable().ajax.reload();
                        swal({
                            title: 'Sucesso!',
                            type: 'success',
                            timer: '1500',
                            text: data.sucesso,
                        });
                    } else {
                        swal({
                            title: 'Oops...',
                            type: 'error',
                            text: data.errorUser,
                            // timer: '1500'
                        });
                    }

                },
                error: function (data) {
                    swal({
                        title: 'Oops...',
                        type: 'error',
                        text: data.error,
                        // timer: '1500'
                    })
                }
            });
        }
    });
}
//Função para gerenciar o submit da pagina...
$(function () {
    $('#modalCadastroUser form').on('submit', function (e) {
        e.preventDefault();
        var id = $('#idUser').val();
        var url = '';
        //Condição para fazer a verificação para qual função acima o submit vai responder
        if (save_method == 'adicionar') {
            //URL para as ações, caso o submit seja para "novo dados"
            url = "/admin/cadastros/usuario/cadastrar";
        }
        else {
            //URL para informar que o submit vai para a função de EditarUsuarios
            url = "/admin/cadastros/usuario/atualizar";
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($("#modalCadastroUser form")[0]),
            contentType: false,
            processData: false,
            success: function (data) {
                $('#modalCadastroUser').modal('hide');
                $('#tabelaUsuario').DataTable().ajax.reload();
                swal({
                    title: 'Sucesso!',
                    text: data.message,
                    type: 'success',
                    timer: '1500'
                })
            },
            error: function (errors) {
                $('.errors').empty();
                var erros = $.parseJSON(errors.responseText);
                $.each(erros.errors, function (key, value) {
                    $("#d_" + key).addClass('error');
                    $("." + key).html(value);
                    $("#d_" + key).click(function () {
                        $(this).removeClass('error');
                        $('.' + key).text('');
                    });

                });

            }
        });

    });
});
