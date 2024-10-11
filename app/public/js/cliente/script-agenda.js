$(document).ready(function () {
    let dias_da_semana_que_trabalha = []
    let horario_inicio = ""
    let horairo_fim = ""

    // Obter a query string da URL
    const queryString = window.location.search;

    // Criar um objeto URLSearchParams a partir da query string
    const urlParams = new URLSearchParams(queryString);
    const barbershop_param = urlParams.get('barbershop')

    $.ajax({
        type: "GET",
        url: "/api/barbershop_data",
        data: {
            barbershop: barbershop_param
        },
        success: function (response) {
            console.log(response)
        },
        error:function( jqXHR, textStatus, errorThrown){
            
        }
    });
});