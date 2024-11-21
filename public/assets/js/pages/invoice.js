'use strict';
$(document).ready(function() {
    var table = $('#invoice-table');
    // Datatable
    var freelance = table.attr('bmode');
    if ( freelance ) {
        table.DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            order: [[ 13, "desc" ]],
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            colReorder: true,
            processing: true,
            serverSide: true,
            ajax: '/business/' + table.attr('bid') + '/invoice-json',
            columns: [
                { data: 'id', name: 'id', render: function ( data, type, row, meta ) {
                        var name = '';
                        $.each(row.projects, function (i, p) {
                            name += '<span class="ml-3">' + p.project.title +'</span> <br>';
                        });

                        return name;
                    }
                },
                { data: 'id', name: 'id', class: 'autoCurrency', render: function ( data, type, row, meta ) {
                        var amount = 0;
                        $.each(row.projects, function (i, p) {
                            amount += parseFloat(p.price);
                        });

                        return amount;
                    }
                },
                { data: 'amount_paid', name: 'amount_paid', class: 'autoCurrency' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'payment_method', name: 'payment_method' },
                { data: 'customer.user.name', name: 'customer.user.name' },
                { data: 'customer.user.phone', name: 'customer.user.phone' },
                { data: 'customer.user.email', name: 'customer.user.email' },
                { data: 'payment_date', name: 'payment_date' },
                { data: 'payment_due_date', name: 'payment_due_date' },
                { data: 'expenses_incurred', name: 'expenses_incurred', class: 'autoCurrency' },
                { data: 'dispatched_at', name: 'dispatched_at' },
                { data: 'created_at', name: 'created_at' },
                { data: 'id', render: function ( data, type, row, meta ) {

                        var isWA = false;
                        if (row.sending_channel === 'WHATSAPP') {
                            isWA = true;
                        }
                        var target =  + isWA ? 'target="_blank"' : '';

                        var resend = '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/resend?device=desktop" class="text-white label theme-bg f-12 btn-shadow d-none d-lg-inline"' + target + '><b>Resend</b></a>' +
                            '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/resend" class="d-lg-none text-white label theme-bg f-12 btn-shadow"><b>Resend</b></a>';

                        return resend +

                            '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/view" class="text-white label theme-bg2 f-12 btn-shadow" target="_blank"><b>View</b></a>' +

                            '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/edit" class="text-white label bg-info f-12 btn-shadow"><b>Edit</b></a>' +

                            '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/delete" class="text-white label theme-bgo f-12 btn-shadow" id="delete-invoice"><b>Delete</b></a>'
                    }
                },
            ],
            initComplete: function () {
                $('th').removeClass('autonumber').removeClass('autoCurrency');
                AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
                AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
            }
        });
    }
    else {
        table.DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            order: [[ 13, "desc" ]],
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            colReorder: true,
            processing: true,
            serverSide: true,
            ajax: '/business/' + table.attr('bid') + '/invoice-json',
            columns: [
                { data: 'id', name: 'id', render: function ( data, type, row, meta ) {
                        var name = '';
                        $.each(row.products, function (i, p) {
                            name += '<span class="ml-3">' + p.product.name +'</span> <br>';
                        });

                        return name;
                    }
                },
                { data: 'id', name: 'id', class: 'autonumber', render: function ( data, type, row, meta ) {
                        var quantity = 0;
                        $.each(row.products, function (i, p) {
                            quantity += parseInt(p.quantity);
                        });

                        return quantity;
                    }
                },
                { data: 'id', name: 'id', class: 'autoCurrency', render: function ( data, type, row, meta ) {
                        var amount = 0;
                        $.each(row.products, function (i, p) {
                            amount += parseFloat(p.amount);
                        });

                        return amount;
                    }
                },
                { data: 'amount_paid', name: 'amount_paid', class: 'autoCurrency' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'payment_method', name: 'payment_method' },
                { data: 'customer.user.name', name: 'customer.user.name' },
                { data: 'customer.user.phone', name: 'customer.user.phone' },
                { data: 'customer.user.email', name: 'customer.user.email' },
                { data: 'payment_date', name: 'payment_date' },
                { data: 'payment_due_date', name: 'payment_due_date' },
                { data: 'expenses_incurred', name: 'expenses_incurred', class: 'autoCurrency' },
                { data: 'dispatched_at', name: 'dispatched_at' },
                { data: 'created_at', name: 'created_at' },
                { data: 'id', render: function ( data, type, row, meta ) {

                        var isWA = false;
                        if (row.sending_channel === 'WHATSAPP') {
                            isWA = true;
                        }
                        var target =  + isWA ? 'target="_blank"' : '';

                        var resend = '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/resend?device=desktop" class="text-white label theme-bg f-12 btn-shadow d-none d-lg-inline"' + target + '><b>Resend</b></a>' +
                            '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/resend" class="d-lg-none text-white label theme-bg f-12 btn-shadow"><b>Resend</b></a>';

                        return resend +

                            '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/view" class="text-white label theme-bg2 f-12 btn-shadow" target="_blank"><b>View</b></a>' +

                            '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/edit" class="text-white label bg-info f-12 btn-shadow"><b>Edit</b></a>' +

                            '<a href="/business/'+table.attr('bid')+'/invoice/'+data+'/delete" class="text-white label theme-bgo f-12 btn-shadow" id="delete-invoice"><b>Delete</b></a>'
                    }
                },
            ],
            initComplete: function () {
                $('th').removeClass('autonumber').removeClass('autoCurrency');
                AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
                AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
            }
        });
    }

    $(document).on('click', '#delete-invoice', function (e) {
        e.preventDefault()
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to revert this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if ( willDelete ) {
                    window.location.href = $(this).attr('href');
                }

                return false;
            });
    })


    var invoiceReceived = $('#invoice-received-table');
    // Datatable
    invoiceReceived.DataTable({
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        colReorder: true,
        processing: true,
        serverSide: true,
        ajax: '/invoices-received-json',
        columns: [
            { data: 'business.name', name: 'business.name', render: function ( data, type, row, meta ) {
                    return '<span class="ml-3">' + data +'</span>';
                }
            },
            { data: 'product.name', name: 'product.name'},
            { data: 'quantity', name: 'quantity', class: 'autonumber' },
            { data: 'amount', name: 'amount', class: 'autoCurrency' },
            { data: 'amount_paid', name: 'amount_paid', class: 'autoCurrency' },
            { data: 'payment_status', name: 'payment_status' },
            { data: 'payment_method', name: 'payment_method' },
            // { data: 'customer_name', name: 'customer_name' },
            // { data: 'customer_phone', name: 'customer_phone' },
            // { data: 'customer_email', name: 'customer_email' },
            { data: 'expenses_incurred', name: 'expenses_incurred' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'payment_due_date', name: 'payment_due_date' },
            { data: 'dispatched_at', name: 'dispatched_at' },
            { data: 'created_at', name: 'created_at' },
        ],
        initComplete: function () {
            $('th').removeClass('autonumber').removeClass('autoCurrency');
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
        }
    });


    var productsPurchased = $('#products-purchased-table');
    // Datatable
    productsPurchased.DataTable({
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        colReorder: true,
        processing: true,
        serverSide: true,
        ajax: '/invoices-received-json',
        columns: [
            { data: 'product.name', name: 'product.name'},
            { data: 'quantity', name: 'quantity', class: 'autonumber' },
            { data: 'amount', name: 'amount', class: 'autoCurrency' },
            { data: 'payment_status', name: 'payment_status' },
            { data: 'payment_method', name: 'payment_method' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'created_at', name: 'created_at' },
        ],
        initComplete: function () {
            $('th').removeClass('autonumber').removeClass('autoCurrency');
            AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
            AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
        }
    });
});
