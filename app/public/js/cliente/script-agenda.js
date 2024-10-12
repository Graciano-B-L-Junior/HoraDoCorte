//Air calendar import
const AirDatepicker = window.AirDatepicker;
const localePTBR = {
    days: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
    daysShort: ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab'],
    daysMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    today: 'Hoje',
    clear: 'Limpar',
    dateFormat: 'dd/mm/yyyy',
    timeFormat: 'hh:ii aa',
    firstDay: 0
};
// const localeEn = window.air-datepicker.locale.en;

$(document).ready(function () {
    //variables for form construction;
    let dias_da_semana_que_trabalha = {}
    let servicos = {}
    let horario_inicio = ""
    let horairo_fim = ""
    let tempo_servico = ""


    //get full url
    const queryString = window.location.search;

    //create url obj to get url param
    const urlParams = new URLSearchParams(queryString);
    const barbershop_param = urlParams.get('barbershop')

    //Create calendar

    let calendar = new AirDatepicker('#calendar', {
        locale: localePTBR,
        isMobile: true
    })

    $.ajax({
        type: "GET",
        url: "/api/barbershop_data",
        data: {
            barbershop: barbershop_param
        },
        success: function (response) {
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
                    case "inicio":
                        horario_inicio = response[key]
                    break;
                    case "fim":
                        horairo_fim = response[key]
                    break;
                    case "tempo_servico":
                        tempo_servico = response[key]
                    break;
                    default:
                        servicos[response[key].nome] = response[key].valor
                    break;
                    
                }
            }
            console.log(servicos)
            
        },
        error:function( jqXHR, textStatus, errorThrown){
            console.log("request failed")
        }
    });
});