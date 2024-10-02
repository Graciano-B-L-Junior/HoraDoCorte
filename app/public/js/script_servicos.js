// $(document).ready(function () {
//     $("#submit").on("click",function(e){
//         e.preventDefault()
//         let formData = new FormData(document.querySelector('form'))
//         $.ajax({
//             type: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             url:"servicos",
//             success:function(data, textStatus, jqXHR){
//                 $(".servicos").append(`<p>${data}</p>`);
//                 console.log("hello")
//                 console.log(data)
//             },
//             error:function( jqXHR, textStatus, errorThrown){
//                 console.log("oi")
//                 console.log(textStatus);
                
//             }
//         })
//     })
// });