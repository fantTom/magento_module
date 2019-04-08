require(['jquery'], function ($) {
    $(document).ready(function () {
        var xhr = null;
        $('#sku').keyup(function () {
            if (xhr) {
                xhr.abort();
            }
            xhr = $.ajax({
                url: 'myrouter/prod/autocomplete',
                data: $('#sku').serialize(),
                success: function (response) {
                    $("#sku-list").empty();
                    for (var sku in response) {
                        $('#sku-list').append($('<option>').attr('value', sku).text(response[sku]));
                    }
                },
                complete: function () {
                    xhr = null;
                },
            });

        });
    });
});