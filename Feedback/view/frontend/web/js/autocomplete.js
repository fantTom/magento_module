require(['jquery'], function ($) {
    $(document).ready(function () {
        $('#sku').keyup(function () {
            $.ajax({
                url: 'myrouter/prod/autocomplete',
                data: $('#sku').serialize(),
                beforeSend: function () {
                    $("#sku-list").empty();
                },
                success: function (response) {

                    for (var sku in response) {
                        $('#sku-list').append($('<option>').attr('value', sku).text(response[sku]));
                    }
                }
            });
        })
    });
});