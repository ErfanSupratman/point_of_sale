        $(document)
            .ready(
                function() {

                    /*
                        INITIALIZER
                    */
                    $('#name').prop('disabled', true);
                    $('#name_movement').prop('disabled', true);

                    var requestBrand = $.ajax({
                        url: "Brand/getAllBrand",
                        method: "GET",
                        dataType: "json"
                    });

                    requestBrand.done(function(msg) {
                        var options;
                        $.each(msg.data, function(i, item) {
                            $('#modal-new-stock-fullscreen #brand').append(
                                $("<option></option>").attr("value", item.id)
                                .text(item.name));
                            console.log(item.id);
                            $('#modal-new-stock-fullscreen #brand').selectpicker(
                                'refresh');
                        });
                    });

                    requestBrand.fail(function(jqXHR, textStatus) {
                        console.log(textStatus)
                    });

                    var tableBooking = {};

                    $('#brand').change(function() {
                        $('#name').typeahead('destroy');

                        if ($('#brand').val() != undefined) {
                            $('#name').prop('disabled', false);
                        }

                        $.get('Product/findProductByBrandId', {
                            brandId: $('#brand').val()
                        }, function(data) {
                            $("#name").typeahead({
                                source: data
                            });
                        }, 'json');

                        $('#name').val('');
                        $('.product_detail').fadeOut(500, function() {
                            $(this).text("").fadeIn(500);
                        });
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
                                                        '#modal-new-stock-fullscreen #product_id')
                                                        .val(
                                                            current.id);
                                                });
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


                    /*
                        STOCK
                    */

                    var table = $('#stock_table')
                        .DataTable({
                            select: 'single',
                            "processing": true,
                            "ajax": "Inventory/getAllStock",
                            "columns": [{
                                "data": "stock_code"
                            }, {
                                "data": "product_code"
                            }, {
                                "data": "product_name"
                            }, {
                                "data": "brand_name"
                            }, {
                                "data": "stock"
                            }, {
                                "data": "harga_bengkel"
                            }, {
                                "data": "harga_dist_area"
                            }, {
                                "data": "harga_dealer"
                            }, {
                                "data": "harga_retail"
                            }, {
                                "data": "location_name"
                            }],
                            "columnDefs": [{
                                "targets": [10],
                                "orderable": false,
                                "data": null,
                                "className": "booking",
                                "defaultContent": "<button id='booking' type='button' class='btn btn-info btn-sm'><i class='fa fa-bookmark'></i></button>"

                            }, {
                                "targets": [11],
                                "orderable": false,
                                "data": null,
                                "className": "delete",
                                "defaultContent": "<button type='button' id='delete' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button>"

                            }, {
                                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                                "className": "details-control",
                            }]
                        });
                    $('#modal-new-stock-fullscreen #brand').selectpicker({
                        style: 'btn-info',
                        size: 8
                    });

                    $('#stock_table tbody').on(
                        'click',
                        'td.details-control',
                        function() {
                            var rowData = table.row(this).data();
                            $('#modal-new-stock-fullscreen').modal('show');
                            $("#modal-new-stock-fullscreen .title_header")
                                .text("Ubah Data");
                            $("#modal-new-stock-fullscreen #name").val(
                                rowData.product_name);
                            $("#modal-new-stock-fullscreen #id").val(
                                rowData.id);
                            $("#modal-new-stock-fullscreen #lokasi").val(
                                rowData.warehouse_id);
                            $("#modal-new-stock-fullscreen #product_id").val(
                                rowData.product_id);
                            $("#modal-new-stock-fullscreen #jumlah").val(
                                rowData.stock);
                            $(".product_detail").text(rowData.product_code)
                            $("#modal-new-stock-fullscreen #brand")
                                .selectpicker('val', rowData.brand_id);
                            $("#modal-new-stock-fullscreen #hargabe").val(
                                rowData.harga_bengkel);
                            $("#modal-new-stock-fullscreen #hargada").val(
                                rowData.harga_dist_area);
                            $("#modal-new-stock-fullscreen #hargadl").val(
                                rowData.harga_dealer);
                            $("#modal-new-stock-fullscreen #hargare").val(
                                rowData.harga_retail);
                            $("#modal-new-stock-fullscreen #update").show();
                            $("#modal-new-stock-fullscreen #insert").hide();
                        });


                    $('#stock_table tbody')
                        .on(
                            'click',
                            'td.delete',
                            function() {
                                var rowData = table.row(this).data();
                                swal({
                                        title: "Are you sure?",
                                        text: "Delete " + rowData.product_name + "!",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "Yes, delete it!",
                                        closeOnConfirm: false
                                    },
                                    function() {
                                        $
                                            .get(
                                                "Inventory/deactiveStock?id=" + rowData.id,
                                                function(data,
                                                    status) {
                                                    if (data.success) {
                                                        swal(
                                                            "Deleted!",
                                                            "Berhasil menghapus " + rowData.product_name + "",
                                                            "success");
                                                        table.ajax
                                                            .reload();
                                                    } else {
                                                        swal(
                                                            "Failed!",
                                                            "Gagal menghapus " + rowData.product_name + "",
                                                            "error");
                                                    }
                                                });

                                    });
                            });

                    $("#modal-new-stock-fullscreen #insert").click(
                        function() {
                            var fullName = $(
                                "#modal-new-stock-fullscreen #name").val();
                            $.post('Inventory/addStock', $('form#stock_form')
                                .serialize(),
                                function(data) {
                                    if (data.success) {
                                        swal("Inserted!", "Berhasil menyimpan " + fullName + "", "success");
                                        table.ajax.reload();
                                        $('#modal-new-stock-fullscreen').modal('hide');
                                    } else {
                                        swal("Failed!", "Gagal menyimpan " + fullName + "", "error");
                                    }
                                }).fail(function() {
                                swal("Failed!", "Gagal menyimpan " + fullName + "", "error");
                            });
                        });

                    $("#modal-new-stock-fullscreen #update").click(
                        function() {
                            var fullName = $(
                                "#modal-new-stock-fullscreen #name").val();
                            $.post('Inventory/updateStock?id=' + $(
                                    "#modal-new-stock-fullscreen #id").val(), $('form#stock_form')
                                .serialize(),
                                function(data) {
                                    if (data.success) {
                                        swal("Updated!", "Berhasil menyimpan " + fullName + "", "success");
                                        table.ajax.reload();
                                        $('#modal-new-stock-fullscreen').modal('hide');
                                    } else {
                                        swal("Failed!", "Gagal menyimpan " + fullName + "", "error");
                                    }
                                });
                        });

                    /*
                        BOOKING
                    */

                    $('#stock_table tbody')
                        .on(
                            'click',
                            'td.booking',
                            function() {
                                var rowData = table.row(this).data();
                                $('#modal-new-booking-fullscreen').modal('show');
                                $('#modal-new-booking-fullscreen .title_header').text('Booking ' + rowData.stock_code + '-' + rowData.product_name);
                                $('#modal-new-booking-fullscreen #stock_id').val(rowData.id);
                                $('#modal-new-booking-fullscreen .stock_code').text(rowData.stock_code);
                                $('#modal-new-booking-fullscreen #quantity').val("");
                                $('#modal-new-booking-fullscreen #notes').val("");
                                $('#modal-new-booking-fullscreen .available_stock').text(rowData.stock);
                                $('#modal-new-booking-fullscreen .product_name').text(rowData.product_name);
                                $('#modal-new-booking-fullscreen .product_code').text(rowData.product_code);
                                tableBooking = loadBookingTable(rowData.id);

                                $('#modal-new-booking-fullscreen #booking_table tbody').on({
                                    mouseenter: function() {
                                        $(this).popover({
                                            'container': 'body',
                                            'title': 'notes ',
                                            'content': 'sasdasd',
                                            'placement': 'top',
                                            delay: {
                                                "show": 500,
                                                "hide": 100
                                            }
                                        });
                                        $(this).popover('show');
                                        //stuff to do on mouse enter
                                    },
                                    mouseleave: function() {
                                        $(this).popover('hide');
                                    }
                                }, 'td.details-control');

                            });

                    $('#modal-new-booking-fullscreen').on('hidden.bs.modal', function(e) {
                        console.log('destroy');
                        tableBooking.destroy();
                    })

                    $("#modal-new-booking-fullscreen #insert").click(
                        function() {
                            var fullName = $(
                                "#modal-new-booking-fullscreen #name").val();
                            $.post('Booking/addBooking', $('form#booking_form')
                                .serialize(),
                                function(data) {
                                    if (data.success) {
                                        swal("Inserted!", "Berhasil menyimpan", "success");

                                        table.ajax.reload();
                                        tableBooking.ajax.reload();
                                        $('#modal-new-booking-fullscreen #quantity').val("");
                                        $('#modal-new-booking-fullscreen #notes').val("");
                                        //$('#modal-new-booking-fullscreen').modal('hide');
                                        $('#modal-new-booking-fullscreen .available_stock').text(data.availableStock);
                                        //availableStock
                                    } else {
                                        swal("Failed!", "Gagal menyimpan " + data.error, "error");
                                    }
                                }).fail(function() {
                                swal("Failed!", "Gagal menyimpan", "error");
                            });
                        });

                    $('#purchase_order').on(
                        'click',
                        '.clickable-row',
                        function(event) {
                            $('#modal-new-stock-fullscreen').modal('show');
                            $(this).addClass('active').siblings().removeClass(
                                'active');
                        });

                    $('#brand_movement').change(function() {
                        if ($('#brand_movement').val() == 'Bilt-Hamber') {
                            $('#name_movement').prop('disabled', false);
                            $('#name_movement').typeahead({
                                source: [{
                                    id: "X-0001",
                                    name: "Bilt-Hamber auto-wash"
                                }, {
                                    id: "X-0007",
                                    name: "Bilt-Hamber auto-wheel"
                                }],
                                autoSelect: true
                            });
                        } else if ($('#brand_movement').val() == 'Halfords') {
                            $('#name_movement').prop('disabled', false);
                            $('#name_movement').typeahead({
                                source: [{
                                    id: "X-0002",
                                    name: "Halfords Car Wash"
                                }],
                                autoSelect: true
                            });
                        } else if ($('#brand_movement').val() == 'Simoniz') {
                            $('#name_movement').prop('disabled', false);
                            $('#name_movement').typeahead({
                                source: [{
                                    id: "X-0005",
                                    name: "Simoniz Alloy Clean Plus"
                                }, {
                                    id: "X-0003",
                                    name: "Simoniz Protection Car Wash"
                                }],
                                autoSelect: true
                            });
                        } else {
                            $('#name_movement').prop('disabled', true);
                        }
                    });

                    $('#name_movement').change(function(e) {

                        var current = $('#name_movement').typeahead("getActive");
                        if (current) {
                            if (current.name == $('#name_movement').val()) {
                                $('.product_detail_movement').fadeOut(500, function() {
                                    $(this).text(current.id).fadeIn(500);
                                });
                            } else {
                                console.log($('#brand_movement').val());
                                $('.product_detail_movement').fadeOut(500, function() {
                                    $(this).text("product not found!").fadeIn(500);
                                });
                            }
                        } else {}
                    });

                    $('#addStock').on("click", function() {
                        $('#modal-new-stock-fullscreen').modal('show');
                        $("#modal-new-stock-fullscreen .title_header")
                            .text("Ubah Data");
                        $("#modal-new-stock-fullscreen #name").val("");
                        $("#modal-new-stock-fullscreen #lokasi").val("");
                        $("#modal-new-stock-fullscreen #product_id").val("");
                        $("#modal-new-stock-fullscreen #jumlah").val("");
                        $(".product_detail").text("")
                        $("#modal-new-stock-fullscreen #brand")
                            .selectpicker('val', "");
                        $("#modal-new-stock-fullscreen #hargabe").val(0);
                        $("#modal-new-stock-fullscreen #hargada").val(0);
                        $("#modal-new-stock-fullscreen #hargadl").val(0);
                        $("#modal-new-stock-fullscreen #hargare").val(0);
                        $("#modal-new-stock-fullscreen #update").hide();
                        $("#modal-new-stock-fullscreen #insert").show();
                    });

                });

        /*
            FUNCTION
        */

        function loadBookingTable(stockId) {
            var tableBookingNow = $('#modal-new-booking-fullscreen #booking_table').DataTable({
                select: 'single',
                "processing": true,
                "ajax": "Booking/getListBookingByStockId?stock_id=" + stockId,
                "columns": [{
                    "data": "created_date"
                }, {
                    "data": "created_by"
                }, {
                    "data": "booking_code"
                }, {
                    "data": "quantity"
                }],
                "columnDefs": [{
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
            $('#modal-new-booking-fullscreen #booking_table tbody')
                .on(
                    'click',
                    'td.delete',
                    function() {
                        var rowData = tableBookingNow.row(this).data();
                        swal({
                                title: "Are you sure?",
                                text: "Delete Booking Code " + rowData.booking_code + "!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, delete it!",
                                closeOnConfirm: false
                            },
                            function() {
                                $
                                    .get(
                                        "Booking/deactiveBooking?id=" + rowData.id + "&stockId=" + rowData.stock_id,
                                        function(data,
                                            status) {
                                            if (data.success) {
                                                swal(
                                                    "Deleted!",
                                                    "Berhasil menghapus " + rowData.booking_code + "",
                                                    "success");
                                                tableBookingNow.ajax
                                                    .reload();
                                                $("#modal-new-booking-fullscreen .available_stock").text(data.stock);
                                            } else {
                                                swal(
                                                    "Failed!",
                                                    "Gagal menghapus " + rowData.booking_code + "",
                                                    "error");
                                            }
                                        });

                            });
                    });
            return tableBookingNow;
        }