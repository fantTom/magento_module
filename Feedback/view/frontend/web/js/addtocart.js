require(['jquery', 'Magento_Customer/js/customer-data'], function ($, customerData) {
    $('#sku-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'myrouter/cart/addproducttocart',
            data: $('#sku-form').serialize(),
            success: function () {
                customerData.reload(['cart'], true);
                customerData.invalidate(['cart']);
                $('#sku-form').trigger('reset');

            },
        });
    });
});