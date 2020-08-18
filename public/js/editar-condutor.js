// Variavel GLOBAL
var tabela;
var teste;
var idCondutor;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // setInterval(function() {
    // }, 1000);
    //Ativa o menu e sub menu correspondente na navbar. 
    $('#cadastros').addClass('active');
    $('.cadastros').addClass('active');
    $('#cadastrarCondutor').addClass('active');

    //cards especiais (imagem do usuario com preview).
    $('.special.cards .image').dimmer({
        on: 'hover'
    });

    //Bloqueando as inputs do condutor.
    $("#edicao_condutor  #data_de_criacao, #identificacao_pessoa, #numero_cartao, #nome_pessoa, #curso_pessoa, #telefone_pessoa, #tipo_pessoa, #cpf_pessoa, #email_pessoa ").each(function () {
        $(this).attr("readonly", true);
        $(this).attr("disabled", true);

    });
    //Chamando image.png caso o não econtrar a foto do BD.CENTRAL
    $("#imagem_pessoa").on("error", function () {
        $(this).attr('src', '/img/image.png');
    });
    mascaraFormulario();
    getDadosCondutor();
    //Limpando o console.
    console.clear();

});


function getDadosCondutor() {
    //Pegando o ID
    idCondutor = $("#idCondutorEdit").val();
    $.ajax({
        type: "GET",
        url: "/admin/cadastros/condutor" + '/' + idCondutor + "/Editar",
        data: "data",
        dataType: "JSON",
        success: function (data) {
            $("#condutor_idEdit").val(data[0].condutor_id);
            $("#imagem_pessoa").attr('src', 'http://bd.maracanau.ifce.edu.br/uploads/image/' + data[0]['identificacao'] + '.jpg');
            $("#identificacao_pessoa").val(data[0].identificacao);
            $("#nome_pessoa").val(data[0].nome);
            $("#curso_pessoa").val(data[0].setor_curso);
            $("#telefone_pessoa").val(data[0].telefone);
            $("#numero_cartao").val(data[0].numero_cartao);
            $("#tipo_pessoa").val(data[0].tipo);
            $("#cpf_pessoa").val(data[0].cpf);
            $("#email_pessoa").val(data[0].email);
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

//Marscara para as inputs 
function mascaraFormulario() {

    //validação de placa de carro modal de editar.
    $("#placa_edit").mask('AAA-9999');
    $("#placa_novo").mask('AAA-9999');
    //validação de cpf's.
    $('#cpf_pessoa').mask('000.000.000-00', {
        reverse: true
    });
    $('#cpf_visitante').mask('000.000.000-00', {
        reverse: true
    });
    //validação de telefones.
    $('#telefone_visitante').mask('(00) 00000-0000');
    $('#telefone_pessoa').mask('(00) 00000-0000');

}

//Mostrar preview da imagem do veiculo Modal Editar
$("#upload_imagem_veiculo_edit").change(function () {
    const file = $(this)[0].files[0]
    const fileReader = new FileReader()
    fileReader.onloadend = function () {
        $('#imagem_veiculoEdit').attr('src', fileReader.result)
    }
    fileReader.readAsDataURL(file)
});

//Mostrar preview da imagem do veiculo Modal novo veiculo
$("#upload_imagem_veiculo").change(function () {
    const file = $(this)[0].files[0]
    const fileReader = new FileReader()
    fileReader.onloadend = function () {
        $('#imagem_veiculo_novo').attr('src', fileReader.result)
    }
    fileReader.readAsDataURL(file)
});

//Evento abrir o modal de cadastro de veiculos.
$("#novo_cadastro_veiculo").click(function () {
    save_method = "adicionar";
    var qCards = $("#veiculos .classVeiculos").length;

    if (qCards < 6) {
        // $(".ui.form#formulario_veiculos").form('clear');
        $("#imagem_veiculo").attr('src', '/img/image.png');
        $("input[name=_token]").val($('meta[name=csrf-token]').attr('content'));
        $('#modalCadastroVeiculos').modal('show');
        $(".field#formulario_veiculos").each(function () {
            $(".field").addClass("inputsFormVeiculo");
            $(this).removeClass('error');
        });

    } else {
        $("#msg_erros").hide();
        $('#modalCadastroVeiculos')
            .modal('hide', function () {
                $("#msg_erros").hide();
                $('.ui.modal').modal('hide')
            });
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Excedido o limite de veiculos! (máximo 6 veiculos)'
        })
    }
});

function visualizarDadosVeiculo(id) {
    $('#modalVisualizarVeiculos form')[0].reset();
    $.ajax({
        url: "/admin/cadastros/condutor" + '/' + id + "/editarVeiculo",
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $("#condutor_idEdit").val(data[0].condutor_id_fk);
            $("#imagem_veiculo").attr('src', "/images/" + data[0].img_veiculo);
            $("#veiculo_visualizar").val(data[0].tipo_veiculo);
            $("#modelo_visualizar").val(data[0].modelo);
            $("#cor_visualizar").val(data[0].cor);
            $("#placa_visualizar").val(data[0].placa);
            $("#marca_visualizar").val(data[0].marca);
            $("#ano_visualizar").val(data[0].ano);
            $("#formulario_veiculosVisualizar  #veiculo_visualizar, #modelo_visualizar, #cor_visualizar, #placa_visualizar, #marca_visualizar, #ano_visualizar ").each(function () {
                $(this).attr("readonly", true);
                $(this).attr("disabled", true);

            });
            $('#modalVisualizarVeiculos').modal('show');

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

function editCardVeiculos(id) {
    save_method = "editar";
    $('#idVeiculoCondutor').val(id);

    $.ajax({
        url: "/admin/cadastros/condutor" + '/' + id + "/editarVeiculo",
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $("#nomeimg").val(data[0].img_veiculo);
            $("#imagem_veiculoEdit").attr('src', "/images/" + data[0].img_veiculo);
            $('.dropdown.tipo_veiculo').dropdown('set selected', data[0].tipo_veiculo);
            $("#modelo_edit").val(data[0].modelo);
            $('.dropdown.cor_edit').dropdown('set selected', data[0].cor);
            $("#placa_edit").val(data[0].placa);
            $('.dropdown.marca_edit').dropdown('set selected', data[0].marca);
            $("#ano_edit").val(data[0].ano);
            $('#modalEditarVeiculos').modal('show');


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
function deletaVeiculo(id_veiculo) {
    var qCards = $("#veiculos .classVeiculos").length;

    if (qCards > 1) {
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
                    url: "/admin/editar/condutor/" + id_veiculo + "/deletarVeiculo",
                    type: "POST",
                    data: { '_method': 'DELETE', 'csrf-token': csrf_token },
                    success: function (data) {
                        swal({
                            title: 'Success!',
                            type: 'success',
                            timer: '1500'
                        });
                        $("#cardVeiculosCadastrar[data-id=cardV_" + id_veiculo + "]").remove();
                    },
                    error: function (data) {

                        swal({
                            title: 'Oops...',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            }
        });
    } else {
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Você deve haver pelo menos um veiculo !'
        })
    }

}
//Cadastrando um novo veiculo pela tela de editar (TELA DE EDITAR OS DADOS)
$("#salvar_modalVeiculoNovo").click(function (e) {
    e.preventDefault();
    $.ajax({
        url: "/admin/cadastros/condutor/novo",
        type: "POST",
        data: new FormData($("#modalCadastroVeiculos form")[0]),
        contentType: false,
        processData: false,
        success: function (data) {
            $('#modalCadastroVeiculos').modal('hide');
            setTimeout(function () {
                location.reload();
            }, 1000);
            swal({
                title: 'Sucesso!',
                text: 'Veiculo cadastrado com sucesso !',
                type: 'success',
                timer: '1500'
            })

        },
        error: function (data) {
            swal({
                title: 'Oops...',
                text: 'AAA',
                type: 'error',
                timer: '1500'
            })
        }
    });

});

//Editando os dados do veiculo
$("#salvar_modalVeiculoEdit").click(function (e) {
    e.preventDefault();
    $.ajax({
        url: "/admin/cadastros/condutor/atualizar",
        type: "POST",
        data: new FormData($("#modalEditarVeiculos form")[0]),
        contentType: false,
        processData: false,
        success: function (data) {
            setTimeout(function () {
                location.reload();
            }, 1000);
            $('#modalEditarVeiculos').modal('hide');
            swal({
                title: 'Sucesso!',
                text: data.message,
                type: 'success',
                timer: '1500'
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

});

$("#salvarDadosEdit").click(function (e) {
    e.preventDefault();
    swal({
        title: 'Sucesso!',
        text: 'Dados enviado com sucesso !',
        type: 'success',
        timer: '1500'
    });
    setTimeout(function () {
        location.reload();
    }, 1000);
});

//Função para gerenciar o submit da pagina...
// $(function () {
//     $('#formulario_veiculos_edit form').on('submit', function (e) {
//       e.preventDefault();
//       console.log("dassdaadsads");
//     });
//   });
// //Função de enviar os dados para inserção no banco de dados
// $("#edicao_condutor").submit(function (e) {
//     e.preventDefault();
//     var formData = new FormData(this);

//     $.ajax({
//         url: '/admin/editar/ver',
//         type: 'POST',
//         data: formData,
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function (data) {
//             console.log(data);
//         }
//     });
// });