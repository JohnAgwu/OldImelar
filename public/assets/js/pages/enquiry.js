'use strict';
$(document).ready(function() {
    $('.enquiry-table').footable({
        columns: [
            { "name": "terminal_id", "title": "TERMINAL ID"},
            { "name": "merchant_id", "title": "MERCHANT ID"},
            { "name": "merchant_name", "title": "MERCHANT NAME" },
            { "name": "message", "title": "MESSAGE" }
        ],
        rows: $.get('/enquiries/all'),
        paging: {
            "enabled": true
        },
        sorting: {
            "enabled": true
        }
    });
});
