$(document).ready(function () {
    let dias_da_semana_que_trabalha = {}
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
            for(let key in response)
            {
                switch(key)
                {
                    case "seg":
                    case "ter":
                    case "qua":
                    case "qui":
                    case "sex":
                    case "sab":
                    case "dom":
                        let dia = key
                        dias_da_semana_que_trabalha[`${dia}`] = response[key]
                    break;
                    
                }
            }
            
        },
        error:function( jqXHR, textStatus, errorThrown){
            console.log("request failed")
        }
    });
});