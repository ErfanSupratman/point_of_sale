$(document).ready(function() {
    var table = $('#report_table').DataTable({
        select: 'single',
        "processing": true,
        "ajax": "Report/getIncomeReport",
        "filter": false,
        "columns": [{
            "data": "created_date"
        }, {
            "data": "finalize_date"
        }, {
            "data": "updated_by"
        }, {
            "data": "invoice_code"
        }, {
            "data": "booking_code"
        }, {
            "data": "billing_name"
        }, {
            "data": "freight"
        }, {
            "data": "amount"
        }]
    });

    $('#filter_report_btn').on('click', function() {
        startDate = $('#start_date').val();
        endDate = $('#end_date').val();
        if (startDate == "" || endDate == "") {
            swal("Failed!", "Tanggal Start dan Akhir harus diisi!", "error");
        } else {
            table.ajax.url('Report/getIncomeReport?startDate=' + startDate + '&endDate=' + endDate);
            table.ajax.reload();
        }
    });

    $('#print_report_btn').on('click', function() {
        startDate = $('#start_date').val();
        endDate = $('#end_date').val();

        if (startDate == "" || endDate == "") {
            swal("Failed!", "Tanggal Start dan Akhir harus diisi!", "error");
        } else {
            window.location.href = 'PrintExcel/incomeReport?startDate=' + startDate + '&endDate=' + endDate;
        }


    })

});