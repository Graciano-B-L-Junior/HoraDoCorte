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
    let data_atual = new Date()
    var calendar
    

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
            
            // let keys_dias_da_semana = Object.keys(dias_da_semana_que_trabalha)
            // let values_dias_da_semana = Object.values(dias_da_semana_que_trabalha)

            calendar = new AirDatepicker('#calendar', {
                locale: localePTBR,
                minDate: data_atual,
                disableNavWhenOutOfRange: false,

                onRenderCell({date, cellType, datepicker}) {
                    // return {                        
                    //     disabled: true,
                    //     classes: 'disabled-class',
                    //     attrs: {
                    //         title: 'Não autorizado'
                    //     }, 
                    // }
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