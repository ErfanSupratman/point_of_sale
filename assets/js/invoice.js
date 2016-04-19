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

    $('#modal-new-invoice-fullscreen #export_xls').on('click', function() {
       /* $("#modal-new-invoice-fullscreen").print({
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
        });*/
        window.location.href = 'PrintExcel/invoiceXls?id='+$("#modal-new-invoice-fullscreen #invoice_id").val();
    });

    $('#modal-new-invoice-fullscreen #print').on('click', function() {
       /* $("#modal-new-invoice-fullscreen").print({
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
        });*/
        window.open('invoice/printInvoice?id='+$("#modal-new-invoice-fullscreen #invoice_id").val());
    })

    var invoiceTable = {};
    $("#bookingMenu").addClass("active");
    $("#pendingMenu").removeClass("active");
    $("#finishedMenu").removeClass("active");
    $("#voidMenu").removeClass("active");
    invoiceTable =
        $('#invoice_table').DataTable({
            "order": [],
            select: 'single',
            "processing": true,
            "ajax": "Invoice/getAllInvoiceByState?state=0",
            "columns": [{
                "data": "created_date"
            }, {
                "data": "booking_code"
            },{
                "data": "finalize_date"
            },{
                "data": "invoice_code"
            }, {
                "data": "billing_name"
            }, {
                "data": "state"
            }],
            "columnDefs": [{
                "targets": 5,
                "data": "state",
                "render": function(data, type, full, meta) {
                    var state = "";
                    if (data == 0) {
                        state = '<span class="label label-info">Booking</span>';
                    } else if (data == 1) {
                        state = '<span class="label label-warning">Pending</span>';
                    } else if (data == 2) {
                        state = '<span class="label label-success">Finished</span>';
                    } else if (data == 3) {
                        state = '<span class="label label-danger">Void</span>';
                    }
                    return state;
                }
            }, {
                "targets": [0, 1, 2, 3,4,5],
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
        $("#booking_code").val("");
        $('.add_row_div').show();
        removeAllRow();

    })

    $('#modal-new-invoice-fullscreen').on('shown.bs.modal', function(e) {
        $("#modal-new-invoice-fullscreen #billing_name").focus();
        $("#modal-new-invoice-fullscreen #insertDetailForm").removeClass("in");
    })

    $('#modal-new-invoice-fullscreen').on('show.bs.modal', function(e) {
        $("#modal-new-invoice-fullscreen #finalize_btn").hide();
        $("#modal-new-invoice-fullscreen #update_btn").hide();
        $('#modal-new-invoice-fullscreen #finalize_btn').hide();
        $('#modal-new-invoice-fullscreen #update_btn').hide();
        $('#modal-new-invoice-fullscreen #confirm_btn').hide();
        $('#modal-new-invoice-fullscreen #void_btn').hide();
        $('#modal-new-invoice-fullscreen #booking_btn').show();
        $('#modal-new-invoice-fullscreen #state').val("");
        $('#modal-new-invoice-fullscreen #print').hide();
        $('#modal-new-invoice-fullscreen #export_xls').hide();
    })

    $('#modal-finalize-fullscreen').on('shown.bs.modal', function(e) {
        $("#modal-finalize-fullscreen #finalize_date").val("");
        $("#modal-finalize-fullscreen #finalize_date").focus();
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

    $('#booking').on('click', function() {
        invoiceTable.ajax.url('Invoice/getAllInvoiceByState?state=0');
        invoiceTable.ajax.reload();
        $("#bookingMenu").addClass("active");
        $("#pendingMenu").removeClass("active");
        $("#finishedMenu").removeClass("active");
        $("#voidMenu").removeClass("active");
    });

    $('#pending').on('click', function() {
        invoiceTable.ajax.url('Invoice/getAllInvoiceByState?state=1');
        invoiceTable.ajax.reload();
        $("#pendingMenu").addClass("active");
        $("#bookingMenu").removeClass("active");
        $("#finishedMenu").removeClass("active");
        $("#voidMenu").removeClass("active");
    });

    $('#finished').on('click', function() {
        invoiceTable.ajax.url('Invoice/getAllInvoiceByState?state=2');
        invoiceTable.ajax.reload();
        $("#finishedMenu").addClass("active");
        $("#pendingMenu").removeClass("active");
        $("#bookingMenu").removeClass("active");
        $("#voidMenu").removeClass("active");
    });

    $('#void').on('click', function() {
        invoiceTable.ajax.url('Invoice/getAllInvoiceByState?state=3');
        invoiceTable.ajax.reload();
        $("#finishedMenu").removeClass("active");
        $("#pendingMenu").removeClass("active");
        $("#bookingMenu").removeClass("active");
        $("#voidMenu").addClass("active");
    });


    $('#modal-new-invoice-fullscreen #finalize_btn').on('click', function() {
        var invoiceId = $("#modal-new-invoice-fullscreen #invoice_id").val();
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk finalisasi invoice ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: "Processing!",
                    text: "",
                    timer: 1,
                    showConfirmButton: false
                }, function() {
                    $("#modal-finalize-fullscreen").modal("show");
                    swal.close();
                    $('#modal-finalize-fullscreen #insert').on('click', function() {
                        console.log($("#modal-finalize-fullscreen #finalize_date").val());
                        if (invoiceId == "") {
                            saveInvoice(2);
                        } else {
                            updateInvoice(2, invoiceId);
                        }
                    });
                });
            } else {
                swal.close();
                $("#modal-finalize-fullscreen #finalize_date").val("");
            }
        });
    });


    $('#modal-new-invoice-fullscreen #void_btn').on('click', function() {
        var invoiceId = $("#modal-new-invoice-fullscreen #invoice_id").val();
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk Void invoice ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: "Processing!",
                    text: "",
                    timer: 1,
                    showConfirmButton: false
                }, function() {
                    voidInvoiceToDB(invoiceId);
                    swal.close();
                });
            } else {
                swal.close();
            }
        });
    });

    $('#modal-new-invoice-fullscreen #confirm_btn').on('click', function() {
        var invoiceId = $("#modal-new-invoice-fullscreen #invoice_id").val();
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk untuk create invoice pending?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: "Processing!",
                    text: "",
                    timer: 1,
                    showConfirmButton: false
                }, function() {
                    if (invoiceId == "") {
                        saveInvoice(1);
                    } else {
                        updateInvoice(1, invoiceId);
                    }
                    swal.close();
                });
            } else {
                swal.close();
            }
        });
    });

    $('#modal-new-invoice-fullscreen #booking_btn').on('click', function() {
        var invoiceId = $('#modal-new-invoice-fullscreen #invoice_id').val();

        if (invoiceId == "") {
            saveInvoice(0);
        } else {
            updateInvoice(0, invoiceId)
        }

    });

    $('#modal-new-invoice-fullscreen #update_btn').on('click', function() {
        var invoiceId = $('#modal-new-invoice-fullscreen #invoice_id').val();
        updateInvoice("", invoiceId)
    });

    $('#invoice_item_list tbody')
        .on(
            'click',
            'td.delete',
            function() {
                alert('delete');
            });

    function saveInvoice(state) {
        var data = invoiceConverter(state);
        insertInvoiceToDB(data);
    }

    function updateInvoice(state, headerId) {
        var data = invoiceConverter(state);
        updateInvoiceToDB(data, headerId);
    }

    function invoiceConverter(state) {
        var dataHeader = {};
        var dataDetails = [];
        var billingName = $("#modal-new-invoice-fullscreen #billing_name").val();
        var finalizeDate = $("#modal-finalize-fullscreen #finalize_date").val();
        var billingPhone = $("#modal-new-invoice-fullscreen #billing_phone").val();
        var billingEmail = $("#modal-new-invoice-fullscreen #billing_email").val();
        var billingAddress = $("#modal-new-invoice-fullscreen #billing_address").val();
        var locationId = $("#modal-new-invoice-fullscreen #locationId").val();
        var notes = $("#modal-new-invoice-fullscreen #notes").val();
        var freight = $("#modal-new-invoice-fullscreen #freight").val();
        var termOfPayment = $("#modal-new-invoice-fullscreen #term_of_payment").val();

        if (state == '') {
            state = $("#modal-new-invoice-fullscreen #state").val();
        }

        console.log('state ' + state);

        dataHeader = {
            billing_name: billingName,
            billing_phone: billingPhone,
            billing_email: billingEmail,
            finalize_date: finalizeDate,
            state: state,
            billing_address: billingAddress,
            location_id: locationId,
            notes: notes,
            freight: freight,
            term_of_payment: termOfPayment
        };

        $('#invoice_item_list tbody tr').each(function() {
            console.log($(this).find('#jumlah_row #jumlahs').val());
            console.log($(this).find('#product_row #product_ids').val());
            var quantity = $(this).find('#jumlah_row #jumlahs').val();
            var price = removeCommas($(this).find('#harga_row #hargas').val());
            var productId = $(this).find('#product_row #product_ids').val();
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
                    swal("Failed!", "Gagal tambah invoice "+data.error, "error");
                }

            }, 'json'
        ).fail(function(error) {
            swal("Failed!", "Gagal tambah invoice", "error");
        });
    }

    function voidInvoiceToDB(invoiceId) {
        $.get('Invoice/voidInvoice?id=' + invoiceId, {}, function(data) {
            if (data.success) {
                swal("Success!", "Sukses void invoice ", "success");
                $('#modal-new-invoice-fullscreen').modal('hide');
                invoiceTable.ajax.reload();
                countAllStateBadge();
            } else {
                swal("Failed!", "Gagal tambah invoice ", "error");
            }
        }).fail(function() {
            swal("Failed!", "Gagal void invoice", "error");
        });;

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
                    $('#modal-finalize-fullscreen').modal('hide');
                    invoiceTable.ajax.reload();
                    countAllStateBadge();
                } else {
                    swal("Failed!", "Gagal update invoice," + data.error, "error");
                }

            }, 'json'
        ).fail(function() {
            swal("Failed!", "Gagal update invoice 2", "error");
        });
    }

    function detailInvoice() {
        $('#modal-new-invoice-fullscreen').modal('show');
    };

    function getInvoiceDetail(id) {
        $.get('Invoice/getInvoiceHeaderAndItemByInvoiceId?id=' + id, {}, function(data) {
            $('#modal-new-invoice-fullscreen').modal('show');
            $("#modal-new-invoice-fullscreen #invoice_code").val(data.header.invoice_code);
            $("#modal-new-invoice-fullscreen #booking_code").val(data.header.booking_code);
            $("#modal-new-invoice-fullscreen #invoice_id").val(data.header.id);
            $("#modal-new-invoice-fullscreen #billing_name").val(data.header.billing_name);
            $("#modal-new-invoice-fullscreen #billing_phone").val(data.header.billing_phone);
            $("#modal-new-invoice-fullscreen #billing_email").val(data.header.billing_email);
            $("#modal-new-invoice-fullscreen #billing_address").val(data.header.billing_address);
            $("#modal-new-invoice-fullscreen #term_of_payment").val(data.header.term_of_payment);
            $("#modal-new-invoice-fullscreen #locationId").val(data.header.location_id);
            $("#modal-new-invoice-fullscreen #notes").val(data.header.notes);
            $("#modal-new-invoice-fullscreen #freight").val(data.header.freight);
            $("#modal-new-invoice-fullscreen #state").val(data.header.state);
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
            $('#modal-new-invoice-fullscreen #export_xls').show();
            $('#modal-new-invoice-fullscreen #print').show();
            if (data.header.state == 0) {
                $('#modal-new-invoice-fullscreen #finalize_btn').hide();
                $('#modal-new-invoice-fullscreen #update_btn').show();
                $('#modal-new-invoice-fullscreen #confirm_btn').show();
                $('#modal-new-invoice-fullscreen #void_btn').show();
                $('#modal-new-invoice-fullscreen #booking_btn').hide();
                $('.add_row_div').show();
            } else if (data.header.state == 1) {
                $('#modal-new-invoice-fullscreen #finalize_btn').show();
                $('#modal-new-invoice-fullscreen #update_btn').show();
                $('#modal-new-invoice-fullscreen #confirm_btn').hide();
                $('#modal-new-invoice-fullscreen #void_btn').show();
                $('#modal-new-invoice-fullscreen #booking_btn').hide();
                $('.add_row_div').show();
            } else if (data.header.state == 2) {
                $('#modal-new-invoice-fullscreen #finalize_btn').hide();
                $('#modal-new-invoice-fullscreen #update_btn').hide();
                $('#modal-new-invoice-fullscreen #confirm_btn').hide();
                $('#modal-new-invoice-fullscreen #void_btn').show();
                $('#modal-new-invoice-fullscreen #booking_btn').hide();
                $('.add_row_div').hide();
            } else if (data.header.state == 3) {
                $('#modal-new-invoice-fullscreen #finalize_btn').hide();
                $('#modal-new-invoice-fullscreen #update_btn').hide();
                $('#modal-new-invoice-fullscreen #confirm_btn').hide();
                $('#modal-new-invoice-fullscreen #void_btn').hide();
                $('#modal-new-invoice-fullscreen #booking_btn').hide();
                $('.add_row_div').hide();
            } else {
                $('#modal-new-invoice-fullscreen #finalize_btn').hide();
                $('#modal-new-invoice-fullscreen #update_btn').hide();
                $('#modal-new-invoice-fullscreen #confirm_btn').hide();
                $('#modal-new-invoice-fullscreen #void_btn').hide();
                $('#modal-new-invoice-fullscreen #booking_btn').show();
            }

        })
    }

    function countAllStateBadge() {
        $.get('Invoice/countAllStates', {}, function(data) {
            /*$('#pendingBadge').text(data);*/
            $('#bookingBadge').text("");
            $('#pendingBadge').text("");
            $('#finishedBadge').text("");
            $('#voidBadge').text("");
            for (var key in data) {
                if (data[key].state == 0) {
                    $('#bookingBadge').text(data[key].total);
                } else if (data[key].state == 1) {
                    $('#pendingBadge').text(data[key].total);
                } else if (data[key].state == 2) {
                    $('#finishedBadge').text(data[key].total);
                } else if (data[key].state == 3) {
                    $('#voidBadge').text(data[key].total);
                }

            }
        }, 'json');
    }

    function putValueForEachRow(data, state) {
        var x = 1
        for (var key in data) {
            console.log("data row :" + data[key]);
            var hidden = "";
            var price = addCommas(data[key].price);
            if (state >= 2) {
                hidden = "hidden";
            }
            $('#invoice_item_list').append('<tr id="invoiceItem"><td>' + x + '</td>' +
                '<td id="jumlah_row">' + data[key].brand_name + '</td>' +
                '<td id="product_row">' + data[key].product_name + '<input type="hidden" class="form-control input-sm" id="product_ids" name="product_ids" value="' + data[key].product_id + '"></td>' +
                '<td>' + data[key].product_code + '</td>' +
                '<td id="jumlah_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="jumlahs" name="jumlahs" value="' + data[key].quantity + '"></input></td>' +
                '<td id="harga_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="hargas" name="hargas" value="' + price + '"></input></td>' +
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
                            '<td id="product_row">' + product + '<input type="hidden" class="form-control input-sm" id="product_ids" name="product_ids" value="' + productId + '"></td>' +
                            '<td>' + productCode + '</td>' +
                            '<td id="jumlah_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="jumlahs" name="jumlah" value="' + jumlah + '"></input></td>' +
                            '<td id="harga_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="hargas" name="harga" value="' + harga + '"></input></td>' +
                            '<td><button type="button" onclick="removeRow(' + i + ')" data-id="' + i + '" id="delete" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button></td></tr>');
                        $('#invoice_item_list').slideDown(200);
                        calculateTotal();
                    });
                } else {
                    swal("Failed!", "Gagal, karena product" + product+ " tidak ada di warehouse tersebut", "error");
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
        var quantity = parseInt($(this).find('#jumlah_row #jumlahs').val());
        console.log('quantity ' + quantity);
        var price = parseInt(removeCommas($(this).find('#harga_row #hargas').val()));

        console.log('price ' + price);
        var total = quantity * price;
        subTotal += total;
        $(this).find('#harga_row #hargas').val(addCommas(price));
    });

    grandTotal = subTotal + parseInt(freight);
    subTotal = addCommas(subTotal);
    grandTotal = addCommas(grandTotal);
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

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function removeCommas(price){
        return parseFloat(price.replace(/,/g,''));
    }