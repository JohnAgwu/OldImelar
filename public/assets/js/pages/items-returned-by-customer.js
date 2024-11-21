'use strict';
$(document).ready(function() {
    var itemsReturned = $('#items-returned-table');
    // Datatable
    itemsReturned.DataTable({
        pageLength: 10,
        dom: 'frtip',
        colReorder: true,
        processing: true,
        serverSide: true,
        ajax: '/business/' + itemsReturned.attr('bid') + '/items-returned-by-customer-json',
        columns: [
            { data: 'product.name', name: 'product.name', render: function ( data, type, row, meta ) {
                    return '<span class="ml-3">' + data +'</span>';
                }
            },
            { data: 'invoice_id', name: 'invoice_id' },
            { data: 'quantity', name: 'quantity', class: 'autonumber' },
            { data: 'amount', name: 'amount', class: 'autoCurrency' },
            { data: 'created_at', name: 'created_at' },
        ],
        initComplete: function () {
            $('th').removeClass('autonumber').removeClass('autoCurrency');
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
        }
    });

});