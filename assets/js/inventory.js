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
                            $('#modal-new-stock-fullscreen #brand').selectpicker(
                                'refresh');

                            $('#modal-move-stock-fullscreen #brand_movement').append(
                                $("<option></option>").attr("value", item.id)
                                .text(item.name));
                            $('#modal-move-stock-fullscreen #brand_movement').selectpicker(
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
                                        $('.product_detail').fadeOut(500, function() {
                                            $(this).text(current.product_code).fadeIn(500);
                                            $('#modal-new-stock-fullscreen #product_id').val(current.id);
                                            $.get('Inventory/getPriceByProductIdAndLocationId?productId=' + current.id + '&locationId=' + $('#modal-new-stock-fullscreen #lokasi').val(), {},
                                                function(data) {
                                                    if (data.length > 0) {
                                                        $("#modal-new-stock-fullscreen #id").val(data[0].id);
                                                        $("#modal-new-stock-fullscreen #hargabe").val(data[0].harga_bengkel);
                                                        $("#modal-new-stock-fullscreen #hargada").val(data[0].harga_dist_area);
                                                        $("#modal-new-stock-fullscreen #hargadl").val(data[0].harga_dealer);
                                                        $("#modal-new-stock-fullscreen #hargare").val(data[0].harga_retail);
                                                        $("#modal-new-stock-fullscreen #hargab").val(data[0].harga_beli);
                                                    }
                                                })

                                        });
                                    } else {
                                        $('.product_detail').fadeOut(500, function() {
                                            $(this).text("product not found!").fadeIn(500);
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
                                "data": "brand_name"
                            }, {
                                "data": "product_name"
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
                            "columnDefs": [
                                /*                            {
                                "targets": [10],
                                "orderable": false,
                                "data": null,
                                "className": "booking",
                                "defaultContent": "<button id='booking' type='button' class='btn btn-info btn-sm'><i class='fa fa-bookmark'></i></button>"

                            }, */
                                {
                                    "targets": [8],
                                    "orderable": false,
                                    "data": null,
                                    "className": "history",
                                    "defaultContent": "<button type='button' id='history' class='btn btn-info btn-sm'><span class='fa fa-history fa-lg'></span></button>"

                                }, {
                                    "targets": [9],
                                    "orderable": false,
                                    "data": null,
                                    "className": "delete",
                                    "defaultContent": "<button type='button' id='delete' class='btn btn-danger btn-sm'><span class='fa fa-trash-o fa-lg'></span></button>"

                                }, {
                                    "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                                    "className": "details-control",
                                }
                            ]
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
                            $("#modal-new-stock-fullscreen #lokasi").hide();
                            $("#modal-new-stock-fullscreen #lokasi_detail").text(rowData.location_name);
                            $("#modal-new-stock-fullscreen #product_id").val(
                                rowData.product_id);
                            $("#modal-new-stock-fullscreen #jumlah").val(
                                rowData.stock);
                            $(".product_detail").text(rowData.product_code)
                            $("#modal-new-stock-fullscreen #brand")
                                .selectpicker('val', rowData.brand_id);
                            $("#modal-new-stock-fullscreen #hargabe").val(
                                rowData.harga_bengkel);
                            $("#modal-new-stock-fullscreen #hargab").val(
                                rowData.harga_beli);
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
                            var fullName = $("#modal-new-stock-fullscreen #name").val();
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
                        HISTORY STOCK
                    */

                    var tableHistory = $('#modal-history-stock-fullscreen #history_table')
                        .DataTable({
                            select: 'single',
                            "processing": true,
                            "serverSide": true,
                            "ajax": "Inventory/getHistoryStock?id=0",
                            "columns": [{
                                "data": "created_date"
                            }, {
                                "data": "created_by"
                            }, {
                                "data": "stock_in"
                            }, {
                                "data": "stock_out"
                            }, {
                                "data": "notes"
                            }]
                        });

                    $('#stock_table tbody')
                        .on(
                            'click',
                            'td.history',
                            function() {
                                var rowData = table.row(this).data();
                                $("#modal-history-stock-fullscreen").modal('show');
                                $("#modal-history-stock-fullscreen .title_header").text('History Stock ' + rowData.product_name + ' | ' + rowData.location_name);
                                tableHistory.ajax.url('Inventory/getHistoryStock?id=' + rowData.id);
                                tableHistory.ajax.reload();
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
                                        var rowData = tableBooking.row(this).data();
                                        $(this).popover({
                                            'container': 'body',
                                            'title': 'notes-' + rowData.booking_code,
                                            'content': rowData.notes,
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

                    /*
                        MOVEMENT


                    $('#moveStock').on("click", function() {
                        $('#modal-move-stock-fullscreen').modal('show');
                        $("#modal-move-stock-fullscreen .title_header")
                            .text("Pindah Stock");
                        $("#modal-move-stock-fullscreen #name_movement").val("");
                        $("#modal-move-stock-fullscreen #source_location").val("");
                        $("#modal-move-stock-fullscreen #product_id").val("");
                        $("#modal-move-stock-fullscreen #source_stock").val("");
                        $(".product_detail_movement").text("")
                        $("#modal-new-stock-fullscreen #brand")
                            .selectpicker('val', "");
                        $("#modal-new-stock-fullscreen #hargabe").val(0);
                        $("#modal-new-stock-fullscreen #hargada").val(0);
                        $("#modal-new-stock-fullscreen #hargadl").val(0);
                        $("#modal-new-stock-fullscreen #hargare").val(0);
                        $("#modal-new-stock-fullscreen #insert").show();
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
                        $('#name_movement').typeahead('destroy');

                        if ($('#brand_movement').val() != undefined) {
                            $('#name_movement').prop('disabled', false);
                        }

                        $.get('Product/findProductByBrandId', {
                            brandId: $('#brand_movement').val()
                        }, function(data) {
                            $("#name_movement").typeahead({
                                source: data
                            });
                        }, 'json');

                        $('#name_movement').val('');
                        $('.product_detail_movement').fadeOut(500, function() {
                            $(this).text("").fadeIn(500);
                        });
                    });

                    $('#name_movement')
                        .change(
                            function(e) {

                                var current = $('#name_movement').typeahead(
                                    "getActive");
                                if (current) {
                                    if (current.name == $('#name_movement').val()) {
                                        $('.product_detail_movement')
                                            .fadeOut(
                                                500,
                                                function() {
                                                    $(this)
                                                        .text(
                                                            current.product_code)
                                                        .fadeIn(500);
                                                    $(
                                                        '#modal-move-stock-fullscreen #product_id')
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
                            }); */

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
        };

        function addStock() {
            $('#modal-new-stock-fullscreen').modal('show');
            $("#modal-new-stock-fullscreen .title_header").text("Ubah Data");
            $("#modal-new-stock-fullscreen #name").val("");
            $("#modal-new-stock-fullscreen #lokasi").val("");
            $("#modal-new-stock-fullscreen #product_id").val("");
            $("#modal-new-stock-fullscreen #jumlah").val("");
            $(".product_detail").text("")
            $("#modal-new-stock-fullscreen #brand").selectpicker('val', "");
            $("#modal-new-stock-fullscreen #hargabe").val(0);
            $("#modal-new-stock-fullscreen #hargab").val(0);
            $("#modal-new-stock-fullscreen #hargada").val(0);
            $("#modal-new-stock-fullscreen #hargadl").val(0);
            $("#modal-new-stock-fullscreen #hargare").val(0);
            $("#modal-new-stock-fullscreen #lokasi").show();
            $("#modal-new-stock-fullscreen #lokasi_detail").text("");
            $("#modal-new-stock-fullscreen #update").hide();
            $("#modal-new-stock-fullscreen #insert").show();
        }