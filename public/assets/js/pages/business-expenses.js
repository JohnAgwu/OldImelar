'use strict';
$(document).ready(function() {
    var businessExpenses = $('#business-expenses');
    // Datatable
    businessExpenses.DataTable({
        pageLength: 10,
        dom: 'frtip',
        colReorder: true,
        processing: true,
        serverSide: true,
        ajax: '/business/' + businessExpenses.attr('bid') + '/expenses/json',
        columns: [
            { data: 'type', name: 'type', },
            { data: 'amount', name: 'amount', class: 'autoCurrency' },
            { data: 'info', name: 'info', class: 'text-wrap'},
            { data: 'created_at', name: 'created_at' },
            { data: 'id', render: function ( data, type, row, meta ) {
                return '<a href="/business/'+businessExpenses.attr('bid')+'/expenses/'+row.id+'/delete" class="text-white label theme-bgo f-12 btn-shadow"><b>Delete</b></a>';
                }
            },
        ],
        initComplete: function () {
            $('th').removeClass('autonumber').removeClass('autoCurrency');
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
        }
    });

});