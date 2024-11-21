'use strict';
$(document).ready(function() {
    var businessIncomes = $('#business-incomes');
    // Datatable
    businessIncomes.DataTable({
        pageLength: 10,
        dom: 'frtip',
        order: [[ 4, "desc" ]],
        colReorder: true,
        processing: true,
        serverSide: true,
        ajax: '/business/' + businessIncomes.attr('bid') + '/incomes/json',
        columns: [
            { data: 'type', name: 'type' },
            { data: 'amount', name: 'amount', class: 'autoCurrency' },
            { data: 'info', name: 'info' },
            { data: 'created_at', name: 'created_at' },
            { data: 'id', render: function ( data, type, row, meta ) {
                return '<a href="/business/'+businessIncomes.attr('bid')+'/incomes/'+row.id+'/delete" class="text-white label theme-bgo f-12 btn-shadow"><b>Delete</b></a>';
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
