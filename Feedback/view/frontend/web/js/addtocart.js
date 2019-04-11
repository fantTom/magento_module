require(["jquery", "mage/url", 'Magento_Ui/js/modal/modal', 'Magento_Customer/js/customer-data'], function ($, urlBuilder, modal, customerData) {
    $(document).ready(function () {
        var options = {
            type: 'popup',
            // responsive: true,
            innerScroll: true,
            title: 'Select product free',
            // buttons: [{
            //     text: $.mage.__('Continue'),
            //     class: '',
            //     click: function () {
            //         this.closeModal();
            //     }
            // }]
        };

        var popup = modal(options, $('#popup-modal'));


        $('#sku-form').submit(function (e) {
            e.preventDefault();
            $("td.stock-item").remove();
            $.ajax({
                url: 'myrouter/prod/getstock',
                data: $('#sku').serialize(),
                success: function (response) {
                    $.ajax({
                        url: urlBuilder.build("checkout/cart/add"),
                        type: 'POST',
                        data: $('#sku-form').serialize(),
                        success: function () {
                            for (var sku in response) {
                                $('#product-stock').append('<td class = "stock-item" id ="' + sku + '" style=" margin: 20px 10px 20px 0;"><b>' + response[sku] + '</b><br>' + sku + '</td>');
                            }
                            ;
                            $('#sku-form').trigger('reset');

                            $('.stock-item').click(function (e) {
                                $.ajax({
                                    url:'myrouter/cart/addproducttocart',
                                    data:"sku="+ $(this).attr('id'),
                                    success: function () {
                                        console.log('ok');
                                        customerData.reload(['cart'], true);
                                        $("#popup-modal").modal("closeModal");
                                    }
                                });
                            });
                        }
                    });
                    if (response.length != 0) {
                        $("#popup-modal").modal("openModal");
                    }
                },
            });
        });

    });
});