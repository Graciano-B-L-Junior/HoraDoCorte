$(document).ready(function () {
    let alerta_horario = $("#alerta-horario")
    let alerta_semana = $("#alerta-semana")
    console.log(alerta_semana)
    console.log(alerta_horario)
    $("#register").on("click",function(e){
        e.preventDefault()
        let all_semana_unchecked = true
        let formData = new FormData()
        
        $(".dia_semana input[type='checkbox']").each(function(){
            if($(this).is(":checked"))
            {
                all_semana_unchecked = false
            }
            formData.append(this.name, $(this).is(':checked') ? '1' : '0')
        })
        $("select").each(function(){
            formData.append(this.name,$(this).val())
        })
        if(all_semana_unchecked)
        {
            alerta_semana.css('display','block')
        }
        else
        {
            alerta_semana.css('display','none')
        }

        if(all_semana_unchecked == false)
        {   
            
            console.log(formData)
            $.ajax({
                type: "POST",
                url: "/dashboard/dias_de_trabalho",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) 
                {
                    
                },
                error: function( jqXHR, textStatus, errorThrown)
                {

                }
            });
        }
    })
});