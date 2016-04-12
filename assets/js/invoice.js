$(document).ready(function() {

    /*    $("#modal-new-invoice-fullscreen #print").on("click", function() {
        var divContents = $("#modal-new-invoice-fullscreen .modal-body").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>DIV Contents</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });*/

    $('#modal-new-invoice-fullscreen #print').on('click', function() {
        $("#modal-new-invoice-fullscreen").print({
            globalStyles: true,
            mediaPrint: false,
            stylesheet: null,
            noPrintSelector: ".no-print",
            iframe: false,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 1000,
            title: null,
            doctype: '<!doctype html>'
        });
    })

    var invoiceTable = {};
    $("#pendingMenu").addClass("active");
    $("#finishedMenu").removeClass("active");
    invoiceTable =
        $('#invoice_table').DataTable({
            "order": [],
            select: 'single',
            "processing": true,
            "ajax": "Invoice/getAllInvoiceByState?state=0",
            "columns": [{
                "data": "created_date"
            }, {
                "data": "invoice_code"
            }, {
                "data": "billing_name"
            }, {
                "data": "state"
            }],
            "columnDefs": [{
                "targets": 3,
                "data": "state",
                "render": function(data, type, full, meta) {
                    var state = "";
                    if (data == 0) {
                        state = '<span class="label label-warning">Pending</span>';
                    } else if (data == 1) {
                        state = '<span class="label label-success">Finished</span>';
                    }
                    return state;
                }
            }, {
                "targets": [4],
                "orderable": false,
                "data": null,
                "className": "delete",
                "defaultContent": "<button type='button' id='delete' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button>"

            }, {
                "targets": [0, 1, 2, 3],
                "className": "details-control",
            }]
        });

    $('#invoice_table tbody').on(
        'click',
        'td.details-control',
        function() {
            var rowData = invoiceTable.row(this).data();
            console.log("rowData >>>" + rowData);
            getInvoiceDetail(rowData.id);
        });

    countAllStateBadge();

    $(".modal-transparent").on('show.bs.modal', function() {
        setTimeout(function() {
            $(".modal-backdrop").addClass("modal-backdrop-transparent");
        }, 0);
    });

    /*
    $.get('Brand/getAllBrand', {}, function(data) {
        $.each(data.data, function(i, item) {
            $('#modal-new-invoice-fullscreen #brand').append(
                $("<option></option>").attr("value", item.id)
                .text(item.name));
            $('#modal-new-invoice-fullscreen #brand').selectpicker(
                'refresh');
        });
    }, 'json');

    $('#modal-new-invoice-fullscreen #brand').selectpicker({
        style: 'btn-sm btn-info',
        size: 8
    });*/

    $("#modal-new-invoice-fullscreen #add_row").on('click', function() {
        $('#name').prop('disabled', true);
        $('#jumlah').prop('disabled', true);
        $('#price_type').prop('disabled', true);
        $("#modal-new-invoice-fullscreen #name").val("");
        $("#modal-new-invoice-fullscreen #product_id").val("");
        $("#modal-new-invoice-fullscreen #jumlah").val("");
        $("#modal-new-invoice-fullscreen #price_type").val("");
        $(".product_detail").text("")
        $("#modal-new-invoice-fullscreen #brand").selectpicker('val', "");
        $('#brand').typeahead('destroy');
        $('#brand').val('');
        $('#name').typeahead('destroy');
        $('#name').val('');
        var getAllBrand = $.get('Brand/getAllBrand', {

        }, function(data) {
            $("#brand").typeahead({
                source: data.data
            });
        }, 'json');
        $("#modal-new-invoice-fullscreen #jumlah").keyup(function(event) {
            if (event.keyCode == 13) {
                addRowValue(i);
                i++
            }
        });
    });

    $('#modal-new-invoice-fullscreen').on('hidden.bs.modal', function(e) {
        $("#invoice_code").val("");
        $("#billing_name").val("");
        $("#billing_phone").val("");
        $("#billing_email").val("");
        $("#billing_address").val("");
        $("#term_of_payment").val("");
        $("#locationId").val("");
        $("#notes").val("");
        $("#invoice_id").val("");
        $("#freight").val("");
        $('.subTotal').text("");
        $('.grandTotal').text("");
        $('#brand').val('');
        $('#name').val('');
        $('#jumlah').val('');
        $('#price_type').val('Pilih');
        $('#name').prop('disabled', true);
        $('#price_type').prop('disabled', true);
        $('#jumlah').prop('disabled', true);
        $('.product_detail').text("");
        removeAllRow();
    })

    $('#modal-new-invoice-fullscreen').on('shown.bs.modal', function(e) {
        $("#modal-new-invoice-fullscreen #billing_name").focus();
    })

    var i = 1;

    $("#modal-new-invoice-fullscreen #insert_row").on('click', function() {
        addRowValue(i);
        i++;
    });



    $('#modal-new-invoice-fullscreen #brand').change(function() {
        $('#name').val('');
        $('.product_detail').fadeOut(500, function() {
            $(this).text("").fadeIn(500);
        });
    });

    $('#freight')
        .change(
            function(e) {
                calculateTotal();
            });

    $('#price_type')
        .change(
            function(e) {
                if ($('#price_type').val() != '' && $('#price_type').val() != 'Pilih') {
                    $('#jumlah').prop('disabled', false);
                }
            });

    $('#brand')
        .change(
            function(e) {
                console.log('test');
                $('#name').typeahead('destroy');
                $('#name').val('');
                $('.product_detail').fadeOut(500, function() {
                    $(this).text("").fadeIn(500);
                });
                var current = $('#brand').typeahead("getActive");
                console.log(current);
                if (current) {
                    if (current.name == $('#brand').val()) {
                        $('#modal-new-invoice-fullscreen #brand_id').val(current.id);
                        console.log('test success');
                        $.get('Product/findProductByBrandId', {
                            brandId: current.id
                        }, function(data) {
                            $("#name").typeahead({
                                source: data
                            });
                        }, 'json');
                        $('#name').prop('disabled', false);
                    } else {
                        $('.product_detail').fadeOut(
                            500,
                            function() {
                                $(this).text(
                                    "brand not found!")
                                    .fadeIn(500);
                            });
                    }
                } else {}
            });

    $('#name')
        .change(
            function(e) {

                var current = $('#name').typeahead(
                    "getActive");
                if (current) {
                    if (current.name == $('#name').val()) {
                        $('.product_detail')
                            .fadeOut(
                                500,
                                function() {
                                    $(this)
                                        .text(
                                            current.product_code)
                                        .fadeIn(500);
                                    $(
                                        '#modal-new-invoice-fullscreen #product_id')
                                        .val(
                                            current.id);
                                });
                        $('#price_type').prop('disabled', false);
                    } else {
                        $('.product_detail').fadeOut(
                            500,
                            function() {
                                $(this).text(
                                    "product not found!")
                                    .fadeIn(500);
                            });
                    }
                } else {}
            });

    $('#pending').on('click', function() {
        invoiceTable.ajax.url('Invoice/getAllInvoiceByState?state=0');
        invoiceTable.ajax.reload();
        $("#pendingMenu").addClass("active");
        $("#finishedMenu").removeClass("active");
    });

    $('#finished').on('click', function() {
        invoiceTable.ajax.url('Invoice/getAllInvoiceByState?state=1');
        invoiceTable.ajax.reload();
        $("#finishedMenu").addClass("active");
        $("#pendingMenu").removeClass("active");
    });


    $('#modal-new-invoice-fullscreen #finalize').on('click', function() {
        var invoiceId = $("#modal-new-invoice-fullscreen #invoice_id").val();
        if (invoiceId == "") {
            saveInvoice(true);
        } else {
            updateInvoice(true, invoiceId);
        }


    });

    $('#modal-new-invoice-fullscreen #insert').on('click', function() {
        var invoiceId = $('#modal-new-invoice-fullscreen #invoice_id').val();

        if (invoiceId == "") {
            saveInvoice(false);
        } else {
            updateInvoice(false, invoiceId)
        }

    });

    $('#invoice_item_list tbody')
        .on(
            'click',
            'td.delete',
            function() {
                alert('delete');
            });

    function saveInvoice(finalize) {
        var data = invoiceConverter(finalize);
        insertInvoiceToDB(data);
    }

    function updateInvoice(finalize, headerId) {
        var data = invoiceConverter(finalize);
        updateInvoiceToDB(data, headerId);
    }

    function invoiceConverter(finalize) {
        var state = 0;
        var dataHeader = {};
        var dataDetails = [];
        var billingName = $("#modal-new-invoice-fullscreen #billing_name").val();
        var billingPhone = $("#modal-new-invoice-fullscreen #billing_phone").val();
        var billingEmail = $("#modal-new-invoice-fullscreen #billing_email").val();
        var billingAddress = $("#modal-new-invoice-fullscreen #billing_address").val();
        var locationId = $("#modal-new-invoice-fullscreen #locationId").val();
        var notes = $("#modal-new-invoice-fullscreen #notes").val();
        var freight = $("#modal-new-invoice-fullscreen #freight").val();
        var termOfPayment = $("#modal-new-invoice-fullscreen #term_of_payment").val();

        if (finalize) {
            state = 1;
        }

        dataHeader = {
            billing_name: billingName,
            billing_phone: billingPhone,
            billing_email: billingEmail,
            state: state,
            billing_address: billingAddress,
            location_id: locationId,
            notes: notes,
            freight: freight,
            term_of_payment: termOfPayment
        };

        $('#invoice_item_list tbody tr').each(function() {
            console.log($(this).find('#jumlah_row #jumlah').val());
            var quantity = $(this).find('#jumlah_row #jumlah').val();
            var price = $(this).find('#harga_row #harga').val();
            var productId = $(this).find('#product_row #product_id').val();
            var rowData = {
                product_id: productId,
                quantity: quantity,
                price: price
            };
            dataDetails.push(rowData);
        });

        var data = {
            dataHeader: dataHeader,
            dataDetail: dataDetails
        };

        return data;
    }

    function insertInvoiceToDB(data) {
        $.post('Invoice/addInvoice', {
                invoice: JSON.stringify(data)
            },
            function(data) {
                if (data.success) {
                    swal("Success!", "Sukses tambah invoice ", "success");
                    $('#modal-new-invoice-fullscreen').modal('hide');
                    invoiceTable.ajax.reload();
                    countAllStateBadge();
                } else {
                    swal("Failed!", "Gagal tambah invoice ", "error");
                }

            }, 'json'
        ).fail(function() {
            swal("Failed!", "Gagal tambah invoice", "error");
        });
    }

    function updateInvoiceToDB(data, headerId) {
        $.post('Invoice/updateInvoice', {
                invoice: JSON.stringify(data),
                headerId: headerId
            },
            function(data) {
                if (data.success) {
                    swal("Success!", "Sukses update invoice ", "success");
                    $('#modal-new-invoice-fullscreen').modal('hide');
                    invoiceTable.ajax.reload();
                    countAllStateBadge();
                } else {
                    swal("Failed!", "Gagal update invoice ", "error");
                }

            }, 'json'
        ).fail(function() {
            swal("Failed!", "Gagal update invoice", "error");
        });
    }

    function detailInvoice() {
        $('#modal-new-invoice-fullscreen').modal('show');
    };



    function getInvoiceDetail(id) {
        $.get('Invoice/getInvoiceHeaderAndItemByInvoiceId?id=' + id, {}, function(data) {
            $('#modal-new-invoice-fullscreen').modal('show');
            $("#modal-new-invoice-fullscreen #invoice_code").val(data.header.invoice_code);
            $("#modal-new-invoice-fullscreen #invoice_id").val(data.header.id);
            $("#modal-new-invoice-fullscreen #billing_name").val(data.header.billing_name);
            $("#modal-new-invoice-fullscreen #billing_phone").val(data.header.billing_phone);
            $("#modal-new-invoice-fullscreen #billing_email").val(data.header.billing_email);
            $("#modal-new-invoice-fullscreen #billing_address").val(data.header.billing_address);
            $("#modal-new-invoice-fullscreen #term_of_payment").val(data.header.term_of_payment);
            $("#modal-new-invoice-fullscreen #locationId").val(data.header.location_id);
            $("#modal-new-invoice-fullscreen #notes").val(data.header.notes);
            $("#modal-new-invoice-fullscreen #freight").val(data.header.freight);
            $('#modal-new-invoice-fullscreen .subTotal').text("");
            $('#modal-new-invoice-fullscreen .grandTotal').text("");
            $('#brand').val('');

            $('#name').val('');
            $('#jumlah').val('');
            $('#price_type').val('Pilih');
            $('#name').prop('disabled', true);
            $('#price_type').prop('disabled', true);
            $('#jumlah').prop('disabled', true);
            $('.product_detail').text("");
            putValueForEachRow(data.detail, data.header.state);
            calculateTotal();
            if (data.header.state == 1) {
                $('#modal-new-invoice-fullscreen #finalize').hide();
                $('#modal-new-invoice-fullscreen #insert').hide();
                $('.add_row_div').hide();
            } else {
                $('#modal-new-invoice-fullscreen #finalize').show();
                $('#modal-new-invoice-fullscreen #insert').show();
                $('.add_row_div').show();
            }

        })
    }

    function countAllStateBadge() {
        $.get('Invoice/countAllStates', {}, function(data) {
            /*$('#pendingBadge').text(data);*/
            for (var key in data) {
                if (data[key].state == 0) {
                    $('#pendingBadge').text(data[key].total);
                } else if (data[key].state == 1) {
                    $('#finishedBadge').text(data[key].total);
                }

            }
        }, 'json');
    }

    function putValueForEachRow(data, state) {
        var x = 1
        for (var key in data) {
            console.log("data row :" + data[key]);
            var hidden = "";
            if (state == 1) {
                hidden = "hidden";
            }
            $('#invoice_item_list').append('<tr id="invoiceItem"><td>' + x + '</td>' +
                '<td id="jumlah_row">' + data[key].brand_name + '</td>' +
                '<td id="product_row">' + data[key].product_name + '<input type="hidden" class="form-control input-sm" id="product_id" name="product_id" value="' + data[key].product_id + '"></td>' +
                '<td>' + data[key].product_code + '</td>' +
                '<td id="jumlah_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="jumlah" name="jumlah" value="' + data[key].quantity + '"></input></td>' +
                '<td id="harga_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="harga" name="harga" value="' + data[key].price + '"></input></td>' +
                '<td><button type="button" onclick="removeRow(' + x + ')" data-id="' + x + '" id="delete" class="' + hidden + ' btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button></td></tr>');
            x++;
        }

    }

    function addRowValue(i) {
        var brand = $('#brand').val();
        var product = $('#name').val();
        var productCode = $('#modal-new-invoice-fullscreen .product_detail').text();
        var jumlah = $('#jumlah').val();
        var productId = $('#product_id').val();
        var locationId = $('#locationId').val();
        var harga = 0;
        $.get('Inventory/getPriceByProductIdAndLocationId?productId=' + productId + '&locationId=' + locationId, {},
            function(data) {
                if (data.length > 0) {
                    var priceType = $('#modal-new-invoice-fullscreen #price_type').val();
                    if (priceType == 'Bengkel') {
                        harga = data[0].harga_bengkel;
                    } else if (priceType == 'Dealer') {
                        harga = data[0].harga_dealer;
                    } else if (priceType == 'Distributor Area') {
                        harga = data[0].harga_dist_area;
                    } else if (priceType == 'Retail') {
                        harga = data[0].harga_retail;
                    }

                    $('#brand').val('');
                    $('#name').val('');
                    $('#modal-new-invoice-fullscreen .product_detail').text('');
                    $('#jumlah').val('');
                    $('#price_type').val('');
                    $('#invoice_item_list').slideUp(200, function() {
                        $('#invoice_item_list').append('<tr id="invoiceItem"><td>' + i + '</td>' +
                            '<td id="jumlah_row">' + brand + '</td>' +
                            '<td id="product_row">' + product + '<input type="hidden" class="form-control input-sm" id="product_id" name="product_id" value="' + productId + '"></td>' +
                            '<td>' + productCode + '</td>' +
                            '<td id="jumlah_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="jumlah" name="jumlah" value="' + jumlah + '"></input></td>' +
                            '<td id="harga_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="harga" name="harga" value="' + harga + '"></input></td>' +
                            '<td><button type="button" onclick="removeRow(' + i + ')" data-id="' + i + '" id="delete" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button></td></tr>');
                        $('#invoice_item_list').slideDown(200);
                        calculateTotal();
                    });
                } else {
                    swal("Failed!", "Gagal tambah product " + product, "error");
                }
            }, 'json');

    }

});


function calculateTotal() {
    var subTotal = 0;
    var grandTotal = 0;
    var freight = 0;
    if ($('#modal-new-invoice-fullscreen #freight').val() != "") {
        freight = $('#modal-new-invoice-fullscreen #freight').val();
    }
    $('#invoice_item_list tbody tr').each(function() {
        var quantity = parseInt($(this).find('#jumlah_row #jumlah').val());
        console.log('quantity ' + quantity);
        var price = parseInt($(this).find('#harga_row #harga').val());
        console.log('price ' + price);
        var total = quantity * price;
        subTotal += total;
    });

    grandTotal = subTotal + parseInt(freight);
    $('#modal-new-invoice-fullscreen .grandTotal').fadeOut(500, function() {
        $('#modal-new-invoice-fullscreen .grandTotal').text(grandTotal).fadeIn(500);
    });

    $('#modal-new-invoice-fullscreen .subTotal').fadeOut(500, function() {
        $('#modal-new-invoice-fullscreen .subTotal').text(subTotal).fadeIn(500);
    });

    $('#modal-new-invoice-fullscreen .subTotal').text(subTotal);
    $('#modal-new-invoice-fullscreen .grandTotal').text(grandTotal);
    $('#brand').val('');
    $('#name').val('');
    $('#name').prop('disabled', true);
    $('#price_type').prop('disabled', true);
}

function removeRow(id) {
    $('#invoice_item_list').slideUp(200, function() {
        $('#invoice_item_list').slideDown(200);
        $('[data-id=' + id + ']').parents('tr').remove();
    });

    calculateTotal();
}

function removeAllRow() {
    $('#invoice_item_list tbody').each(function() {
        $(this).remove();
    });
}