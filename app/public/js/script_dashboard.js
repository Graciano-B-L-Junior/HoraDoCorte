$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/dashboard/quantidade_clientes",
        success: function (response) {
            $("#quantity-clients").text(response.result);
        }
    });
});