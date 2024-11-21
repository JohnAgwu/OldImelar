'use strict';
$(document).ready(function() {
    var receivables = $('#receivables-table');
    // Datatable
    receivables.DataTable({
        pageLength: 10,
        dom: 'frtip',
        colReorder: true,
        processing: true,
        serverSide: true,
        ajax: '/business/' + receivables.attr('bid') + '/receivables-json',
        columns: [
        { data: 'id', name: 'id', render: function ( data, type, row, meta )
            {
                var title = row.project === null ? '' : row.project.title;
                return '<span class="ml-3">' + title +'</span>';
            }
        },
        { data: 'amount', name: 'amount', class: 'autoCurrency' },
        { data: 'invoice.payment_status', name: 'invoice.payment_status'},
        { data: 'invoice.payment_due_date', name: 'invoice.payment_due_date'},
        { data: 'invoice.days_overdue', name: 'invoice.days_overdue'},
        ],
        initComplete: function () {
            $('th').removeClass('autonumber').removeClass('autoCurrency');
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
        }
    });

    var payables = $('#payables-table');
    // Datatable
    payables.DataTable({
        pageLength: 10,
        dom: 'frtip',
        colReorder: true,
        processing: true,
        serverSide: true,
        ajax: '/business/' + payables.attr('bid') + '/payables-json',
        columns: [
            { data: 'id', name: 'id', render: function ( data, type, row, meta )
                {
                    var title = row.project === null ? '' : row.project.title;
                    return '<span class="ml-3">' + title +'</span>';
                }
            },
            { data: 'amount', name: 'amount', class: 'autoCurrency' },
        ],
        initComplete: function () {
            $('#receivables-table').find('tr').css('cursor', 'pointer')
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            // AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
            // $('th').removeClass('autonumber')
        }
    });


    // AutoNumeric
    AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
    AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0})



    /// Table row click event
    var table = $('#receivables-table').DataTable();

    $('#receivables-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        window.open('/business/'+data['business_id']+'/invoice/'+data['invoice_id']+'/view', '_blank')
    } );
});
