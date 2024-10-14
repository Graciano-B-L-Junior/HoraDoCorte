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
    let horario_fim = ""
    let tempo_servico = ""
    //get full url
    const queryString = window.location.search;

    //create url obj to get url param
    const urlParams = new URLSearchParams(queryString);
    const barbershop_param = urlParams.get('barbershop')

    //Create calendar
    let data_atual = new Date()
    var calendar
    
    $(".alerta").css('display','none')

    //CRIA TODOS OS ELEMENTOS DO FORMULÁRIO
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
                        horario_fim = response[key]
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

            //CRIA O SELECT COM AS OPÇÕES DE SERVIÇO
            let select_form = $("#service")
            Object.entries(servicos).forEach(([key,value])=>{
                select_form.append(`<option name="${key}">${key} --> ${value} reais</option>`);
            })

            //CRIA O SELECT COM AS OPÇÕES DE HORARIO DE SERVIÇO
            horario_inicio = horario_inicio.split(":")
            horario_fim = horario_fim.split(":")
            let date_aux = new Date(Date.now())
            horario_inicio = new Date(date_aux.getFullYear(),date_aux.getMonth(),date_aux.getDate(),horario_inicio[0],horario_inicio[1])
            horario_fim = new Date(date_aux.getFullYear(),date_aux.getMonth(),date_aux.getDate(),horario_fim[0],horario_fim[1])


            let horario = $("#horario")
            console.log(horario_inicio)
            while(horario_inicio <= horario_fim)
            {
                let horario_aux = String(horario_inicio.getHours()).padStart(2,'0')
                let minutos_aux = String(horario_inicio.getMinutes()).padStart(2,'0')
                horario.append(`<option value="${horario_aux}:${minutos_aux}:00">${horario_aux}:${minutos_aux}:00</option>`)
                horario_inicio.setMinutes(horario_inicio.getMinutes() + parseInt(tempo_servico))
            }
            console.log(horario_inicio)

            calendar = new AirDatepicker('#calendar', {
                locale: localePTBR,
                minDate: data_atual,
                disableNavWhenOutOfRange: false,
                onSelect({date}){
                    console.log(date)
                    $("#data-reservada").val(date.toISOString())
                },
                onRenderCell({date, cellType, datepicker}) {
                    
                    let result
                    Object.entries(dias_da_semana_que_trabalha).forEach(([key,value])=>{
                        
                        if(key == "dom" && value == "0" && date.getDay() == 0)
                        {
                            result = {                        
                                disabled: true,
                                classes: 'disabled-class',
                                attrs: {
                                    title: 'Não autorizado'
                                }, 
                            }
                            return
                        }
                        else if(key == "seg" && value == "0" && date.getDay() == 1)
                        {
                            result = {                        
                                disabled: true,
                                classes: 'disabled-class',
                                attrs: {
                                    title: 'Não autorizado'
                                }, 
                            }
                            return
                        }
                        else if(key == "ter" && value == "0" && date.getDay() == 2)
                        {
                            result = {                        
                                disabled: true,
                                classes: 'disabled-class',
                                attrs: {
                                    title: 'Não autorizado'
                                }, 
                            }
                            return
                        }
                        else if(key == "qua" && value == "0" && date.getDay() == 3)
                        {
                            result = {                        
                                disabled: true,
                                classes: 'disabled-class',
                                attrs: {
                                    title: 'Não autorizado'
                                }, 
                            }
                            return
                        }
                        else if(key == "qui" && value == "0" && date.getDay() == 4)
                        {
                            result = {                        
                                disabled: true,
                                classes: 'disabled-class',
                                attrs: {
                                    title: 'Não autorizado'
                                }, 
                            }
                            return
                        }
                        else if(key == "sex" && value == "0" && date.getDay() == 5)
                        {
                            result = {                        
                                disabled: true,
                                classes: 'disabled-class',
                                attrs: {
                                    title: 'Não autorizado'
                                }, 
                            }
                            return
                        }
                        else if(key == "sab" && value == "0" && date.getDay() == 6)
                        {
                            result = {                        
                                disabled: true,
                                classes: 'disabled-class',
                                attrs: {
                                    title: 'Não autorizado'
                                }, 
                            }
                            return
                        }
                    })
                    return result;
                }
                
            })
        },
        error:function( jqXHR, textStatus, errorThrown){
            console.log("request failed")
        }
    });
});