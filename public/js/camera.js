
var identifique_se = new Audio('/audio/syscancela-por-favor-identifique-se.mp3');
var seu_cartao_nao_esta_funcionando = new Audio('/audio/syscancela-seu-cartao-nao-esta-funcionando.mp3');
var sistema_nao_esta_funcionando = new Audio('/audio/syscancela-sistema-nao-esta-funcionando.mp3');
$(document).ready(function () {
    $('#camera').addClass('active');
    pingRasp();
    setInterval(pingRasp, 10000);
    verificandoAudio();
    teste();
    setTimeout(function () {
        chamarCam();
    }, 2000);

});

function teste() {
    // if (localStorage.getItem("carregarCamera") == null || localStorage.getItem("carregarCamera") == false) {
    //     localStorage.setItem("carregarCamera", true);
    //     var segundos = 0
    //     var newWindow = window.open('http://admin:KFesH0I3@10.50.0.110/video/mjpg.cgi?profileid=3', "janela1", "width=1, height=1, directories=no, location=no,menubar=no, scrollbars=no, status=no, toolbar=no, resizable=no");
    //     function esperar() {
    //         segundos++
    //         if (segundos == 5) {
    //             newWindow.close()
    //         } else {
    //             newWindow.close()

    //         }
    //     }
    //     setInterval(esperar, 500);
    //         location.reload();
    // } else {
    //     $("#camera01").attr('src', 'http://admin:KFesH0I3@10.50.0.110/video/mjpg.cgi?profileid=3');


    // }
    var segundos = 0
    var newWindow = window.open('http://admin:KFesH0I3@10.50.0.110/video/mjpg.cgi?profileid=3', "camera01", "width=1, height=1, directories=no, location=no,menubar=no, scrollbars=no, status=no, toolbar=no, resizable=no");
    focus("http://10.50.12.104:8080/admin/camera");
    newWindow.blur();
    function esperar() {
        segundos++
        if (segundos == 5) {
            newWindow.close()
        } else {
            newWindow.close()

        }
    }
    setInterval(esperar, 500);

    // setTimeout(function () {
    //     location.reload();
    // }, 1000);
    // location.reload();

    // newWindow.close();



}
function chamarCam() {
    $("#camera01").attr('src', 'http://10.50.0.110/video/mjpg.cgi?profileid=3');
    $("#camera02").attr('src', 'http://10.50.0.110/video/mjpg.cgi?profileid=3');

}
// function sendMessage(data) {
//     return new Promise((resolve, reject) => {
//         $.ajax({
//             method: 'POST',
//             url: 'http://admin:KFesH0I3@10.50.0.110:554/video/mjpg.cgi?profileid=3',
//             success: resolve,
//             error: reject,
//             data
//         });
//     });
// }
// function botoes() {
//     $.ajax({
//         dataType: 'json',
//         type: 'POST',
//         url: form_action,
//         data: { title: title, details: details }
//     }).done(function (data) {
//         console.log("deu bom!");
//     });
// }
// function sendMessages(data) {
//     return new Promise((resolve, reject) => {
//         $.ajax({
//             method: 'POST',
//             url: 'http://admin:gI6TBRMT@10.50.0.110:554/video/mjpg.cgi?profileid=3',
//             success: resolve,
//             error: reject,
//             data
//         });
//     });
// }
function pingRasp() {
    $.ajax({
        type: 'GET',
        url: "/admin/camera/ver",
        success: function (data) {
            var status_cancela_entrada = $("#btn_entrada").attr('name');
            var status_cancela_saida = $("#btn_saida").attr('name');

            if (data.entrada == 1) {
                if (status_cancela_entrada != 'online') {
                    $('.status_entrada').html('Status:<button class="positive ui button" id="btn_entrada" name="online" style="margin-left: 5px; padding-left: 120px; padding-right: 120px;">ESTÁ FUNCIONANDO</button>');
                }
            } else {
                if (status_cancela_entrada != 'offline') {
                    $('.status_entrada').html('Status:<button class="negative ui button" id="btn_entrada" name="offline" style="margin-left: 5px; padding-left: 115px; padding-right: 115px;">NÃO ESTÁ FUNCIONANDO</button>');
                }
            }

            if (data.saida == 1) {
                if (status_cancela_saida != 'online') {
                    $('.status_saida').html('Status:<button class="positive ui button" id="btn_saida" name="online" style="margin-left: 5px; padding-left: 120px; padding-right: 120px;">ESTÁ FUNCIONANDO</button>');
                }
            } else {
                if (status_cancela_saida != 'offline') {
                    $('.status_saida').html('Status:<button class="negative ui button" id="btn_saida" name="offline" style="margin-left: 5px; padding-left: 115px; padding-right: 115px;">NÃO ESTÁ FUNCIONANDO</button>');
                }
            }
        }
    });
}
function verificandoAudio() {
    $(".btn_entrada").click(function (e) {
        e.preventDefault();
        var valorID = $(this).val();
        var valorCancelaTipo = $(this).attr('data-cancela_tipo');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "/admin/camera/cancelas",
            data: {
                'valorSom': valorID,
                'valorCancela': valorCancelaTipo
            },
            success: function (valorID) {
            },
            error: function (valorID) {
            }
        });
    });
}


