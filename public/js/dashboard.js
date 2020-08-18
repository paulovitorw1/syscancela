var series_Bloco = []; 

$(document).ready(function () {
    $('#paginaInicial').addClass('active');
    visualizar();
    graficoEstatistica();
    graficoPorCurso();
    graficoPorBloco();

    //
    $.ajax({
        type: "GET",
        url: "/admin/dashboard/ver/mes",
        success: function (data) {
            var series = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var aux = 0;
            var tamanho_data = data['consultaTransitoPorPeriodo'].length;
            data['consultaTransitoPorPeriodo'].forEach(mes => {
                for (var index = 0; index < tamanho_data; index++) {
                    aux = (mes.mes) - 1;
                    series[aux] = mes.total;
                }
            });
            graficoEstatistica(series);
        }
    });
    //
    $.ajax({
        type: "GET",
        url: "/admin/dashboard/ver/curso",
        success: function (quantCurso) {
            var series_curso = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var aux_curso = 0;
            var tamanho_curso = quantCurso['consultaTransitoPorCurso'].length;
            quantCurso['consultaTransitoPorCurso'].forEach(curso => {
                for (var qcurso = 0; qcurso < tamanho_curso; qcurso++) {
                    aux_curso = (curso.curso) - 1;
                    series_curso[aux_curso] = curso.quantidade;
                }
            });

            graficoPorCurso(series_curso);

        }
    });
    //
    $.ajax({
        type: "GET",
        url: "/admin/dashboard/ver/bloco",
        async:false,
        success: function (quantBloco) {
             series_Bloco = [0, 0, 0, 0];
            var aux_Bloco = 0;
            var tamanho_Bloco = quantBloco['consultaTransitoPorBloco'].length;
            quantBloco['consultaTransitoPorBloco'].forEach(bloco => {
                for (var qBloco = 0; qBloco < tamanho_Bloco; qBloco++) {
                    aux_Bloco = (bloco.pessoa_tipo) - 1;
                    series_Bloco[aux_Bloco] = bloco.quantidade;
                }
            });
            graficoPorBloco(series_Bloco);

        }
    });
});


function visualizar() {
    $.getJSON('/admin/ver', function (data) {
        data.tipo_usuario.forEach(element => {
            if (element.tipo == "Aluno") {
                $("#alunos").html(element.total);
            } else
                if (element.tipo == "Visitante") {
                    $("#visitantes").html(element.total);
                } else
                    if (element.tipo == "Servidor") {
                        $("#administrativo").html(element.total);
                    } else if (element.tipo == "Terceirizado") {
                        $("#tercerizados").html(element.total);
                    }
        });
        $("#carros").html(data.quantidade_carro);
        $("#motos").html(data.quantidade_moto);
        if (data.media != null) {
            $("#tempo_medio").html(data.media);
        }
    });
}



//-------------------------------------- GRÁFICOS --------------------------------//
function graficoEstatistica(series) {
    //grafico de estatísticas
    Highcharts.chart('grafico-vertical', {
        chart: {
            type: 'column',
            backgroundColor: '#F2F2F2'
        },
        exporting: { enabled: false },
        title: {
            text: 'Estatísticas',
        },
        subtitle: {
            text: 'DO ÚLTIMO ANO.'
        },
        colors: ['#CE4436'],
        credits: {
            enabled: false
        },
        xAxis: {
            categories: [
                'Jan',
                'Fev',
                'Mar',
                'Abr',
                'Mai',
                'Jun',
                'Jul',
                'Ago',
                'Set',
                'Out',
                'Nov',
                'Dez'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Quantidade de veiculos.'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Veiculos',
            data: series,
            showInLegend: false,
        }]
    });
}

function graficoPorCurso(series_curso) {
    //grafico de trânsito por cursos
    Highcharts.chart('grafico-horizontal', {
        chart: {
            type: 'bar',
            backgroundColor: '#F2F2F2'
        },
        title: {
            text: 'Trânsito por cursos'
        },
        exporting: { enabled: false },
        colors: ['#21A4D2'],
        xAxis: {
            categories: ['Bacharelado em Ciência da Computação', 'Bacharelado em Engenharia Mecânica', 'Técnico em Informática', 'Tecnólogo em Manutenção Industrial', 'Licenciatura em Química', 'Bacharelado em Engenharia Ambiental e Sanitária', 'Bacharelado em Engenharia de Controle e Automação', 'Técnico em Automação Industrial', 'Técnico em Meio Ambiente', 'Técnico em Redes de Computadores', 'Básico de Teoria Musical e Solfejo', 'Mestrado em Energias Renováveis', 'Técnica Vocal: Canto Popular Solo e Coletivo', 'Licenciatura em Matemática'],
            title: {
                text: null
            }
        },

        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Quantidade de transitos',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: '.'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Transitos',
            data: series_curso,
            showInLegend: false,
        }]
    });
}


//grafico de Maiores fluxos
function graficoPorBloco() {
    Highcharts.chart('donut', {
        chart: {
            renderTo: 'chart',
            type: 'pie',
            backgroundColor: '#F2F2F2',
        },
        credits: {
            enabled: false
        },
        title: {
            text: 'Maiores Fluxos',

        },
        exporting: { enabled: false },
        plotOptions: {
            pie: {
                shadow: false,
                borderWidth: 0
            }
        },
        colors: ['#F19911', '#29B766', '#22B8E7', '#E74A3C'],
        tooltip: {
            enabled: false
        },
        legend: {
            enabled: true,
            align: 'left',
            layout: 'vertical',
            verticalAlign: 'top',
            x: 70,
            y: 10,
            itemMarginTop: 7,
            itemMarginBottom: 5,
            symbolRadius: 0
        },
        series: [{
            data: [
                {
                    name: "Aluno",
                    y: series_Bloco[0],
                },
                {
                    name: "Administrativo",
                    y: series_Bloco[2],
                },
                {
                    name: "Visitante",
                    y: series_Bloco[4],
                },
                {
                    name: "Terceirizado",
                    y: series_Bloco[3],
                }
            ]
            ,
            size: '170%',
            innerSize: '67%',
            showInLegend: true,
            dataLabels: {
                enabled: false
            }
        }]
    });
}

