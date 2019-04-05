require(["jquery", "mage/url"], function ($, urlBuilder) {
    $(document).ready(function () {
        $('#sku-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: urlBuilder.build("checkout/cart/add"),
                type: 'POST',
                data: $('#sku-form').serialize(),
                success: function () {
                    $('#sku-form').trigger('reset');

                },
            });
        });
    });
});