$(document).ready(function () {
    $("#submit").on('click',function(e){
        e.preventDefault()
        let formData = new FormData(document.querySelector('form'))
        if(formData.get("name")=="")
        {
            $("ul#error").css('display',"block")
            return
        }
        else if(formData.get("password")=="")
        {
            $("ul#error").css('display',"block")
            return
        }
        else if(formData.get("password2")=="")
        {
            $("ul#error").css('display',"block")
            return
        }
        else if(formData.get("email")=="")
        {
            $("ul#error").css('display',"block")
            return
        }
        else if(formData.get("phone")=="")
        {
            $("ul#error").css('display',"block")
            return
        }
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