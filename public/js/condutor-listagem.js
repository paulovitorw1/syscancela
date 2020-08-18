var tabela;
$(document).ready(function () {
        $("#imagem_pessoa").on("error", function () {
        $(this).attr("src", "/img/image.png");
    });
    $('#cadastros').addClass('active');
    $('.cadastros').addClass('active');
    $('#cadastrarCondutor').addClass('active');

    //-------------------------Tabela-----------------------------------//
    //Populando dados para a tabela de condutores
    tabela = $('#tabela-condutores').DataTable({
        "bJQueryUI": true,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "lengthChange": false,
        processing: true,
        serverSide: true,
        ajax: "/admin/cadatros/condutores/listagem",
        columns: [
            { data: 'nome' },
            { data: 'matricula' },
            { data: 'setor_curso' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
    return tabela;
    statuscondutor();
});

//Função para visualizar o condutor atraves do ID passado pelo CondutorControlador.php
function statuscondutor(id_status) {
    save_method = "statuscondutor"
    window.location.href = "/admin/cadastros/condutor" + '/' + id_status + "/listar";

}

//Função para editar o condutor atraves do ID passado pelo CondutorControlador.php
function editarcondutor(id_editar) {
    save_method = "editarcondutor"
    window.location.href = "/admin/cadastros/condutor" + '/' + id_editar + "/RedirecionarEditar";

}
//Função para apagar o condutor atraves do ID passado pelo CondutorControlador.php
function deletacondutor(id_delete) {
    Swal.fire({
        title: 'Você tem certeza?',
        text: "Essa ação pode ser não reversivel!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, delete!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "/admin/cadastros/condutor/excluir",
                data: {
                    id: id_delete
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                success: function (data) {
                    if (Object.keys(data) == 'deletado') {
                        Swal.fire('Deletado!', data['deletado'], 'success');
                        $('#tabela-condutores').DataTable().ajax.reload();
                    }
                }
            });

        }
    });

}

