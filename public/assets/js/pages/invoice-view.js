'use strict';
$(document).ready(function() {
    AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
    AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});


    $(document).on('click', '#make-payment', function () {
        var invoice = JSON.parse($(this).closest('#invoice-base').attr('invoice'));
        var amount = invoice.products_sum - invoice.amount_paid;

        var handler = PaystackPop.setup({
            key: 'pk_live_5e3de3844611745edf450bdad598b7470ca6948e',
            email: invoice.customer.user.email,
            amount: amount * 100,
            currency: "NGN",
            // ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
                custom_fields: [
                    {display_name: "Business Id", variable_name: "business_id", value: invoice.business_id},
                    {display_name: "Product Id", variable_name: "product_id", value: invoice.product_id},
                    {display_name: "Project Id", variable_name: "project_id", value: invoice.project_id},
                    {display_name: "Invoice Id", variable_name: "invoice_id", value: invoice.id},
                    {display_name: "Customer Id", variable_name: "customer_id", value: invoice.customer.id},
                ]
            },
            callback: function(response){
                window.location.href = '/business/' + invoice.business_id + '/invoice/' + invoice.id + '/payment/' + response.reference
            },
            onClose: function(){
                // alert('window closed');
            }
        });
        handler.openIframe();
    });


    $(document).on('click', '#link-card', function () {
        var invoice = JSON.parse($(this).closest('#invoice-base').attr('invoice'));
        var amount = 50;

        var handler = PaystackPop.setup({
            key: 'pk_live_5e3de3844611745edf450bdad598b7470ca6948e',
            email: invoice.customer.user.email,
            amount: amount * 100,
            currency: "NGN",
            metadata: {
                custom_fields: [
                    {display_name: "Business Id", variable_name: "business_id", value: invoice.business_id},
                    {display_name: "Product Id", variable_name: "product_id", value: invoice.product_id},
                    {display_name: "Invoice Id", variable_name: "invoice_id", value: invoice.id},
                    {display_name: "Customer Id", variable_name: "customer_id", value: invoice.customer.id},
                ]
            },
            callback: function(response){
                // add payment
                $.ajax({
                    url: window.location.href = '/business/' + invoice.business_id + '/invoice/' + invoice.id + '/payment/' + response.reference,
                    success: function () {
                        // save debit card
                        window.location.href = '/debit-card/' + response.reference + '/add';
                    }
                });
            },
            onClose: function(){
                // alert('window closed');
            }
        });
        handler.openIframe();
    });
});
