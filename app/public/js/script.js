$(document).ready(function () {
    $("#submit").on('click',function(e){
        e.preventDefault()
        let formData = new FormData(document.querySelector('form'))
        console.log(formData)
        $.ajax({
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            url:"cadastro",
            success:function(data, textStatus, jqXHR){
                window.location.href=data.redirect
            },
            error:function( jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                $("ul#error").css('display',"block")
            }
        })
    })    
});