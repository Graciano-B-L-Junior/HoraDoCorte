$(document).ready(function () {
    //ADICIONA NOVOS CAMPOS AO FORMULÁRIO
    let input_count=1
    $("#add-servico").on("click",function(){
        input_count+=1;
        $(this).before(
            `
            <label for="servico">Nome servico</label>
            <input id="servico" type="text" name="servico-${input_count}">
            <label for="valor">Preço R$</label>
            <input id="valor" type="number" name="valor-${input_count}">
            `
        )
    })

    //FAZ POST PARA CADASTRO DO SERVIÇO
    $("#submit").on("click",function(e){
        e.preventDefault()
        let formData = new FormData(document.querySelector('form'))
        $.ajax({
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            url:"/dashboard/servicos",
            success:function(data, textStatus, jqXHR){
                $(".servicos").append(`<p>${data}</p>`);
                console.log("hello")
                console.log(data)
            },
            error:function( jqXHR, textStatus, errorThrown){
                console.log("oi")
                console.log(textStatus);
                
            }
        })
    })
});