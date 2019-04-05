require(["jquery", "mage/url", "Magento_Customer/js/customer-data"], function ($, urlBuilder, customerData) {
    $(document).ready(function () {
        $('#sku-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: urlBuilder.build("checkout/cart/add"),
                type: 'POST',
                data: $('#sku-form').serialize(),
                success: function () {
                    //success-сообщения выводятся
                    //error-сообщения не выводятся

                    //customerData.reload(['messages'], true); - если применить это, то будет выводить error-сообщения, а success-сообщения выводятся и пропадают

                    $('#sku-form').trigger('reset');

                },
            });
        });
    });
});