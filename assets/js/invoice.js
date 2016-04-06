$(document).ready(function() {
    var dataHeader = {};
    var dataDetails = [];
    $('#name').prop('disabled', true);
    $('#price_type').prop('disabled', true);

    $('#purchase_order').DataTable({
        "order": [],
        "columnDefs": [{
            "targets": [0, 1, 2, 3, 4],
            "orderable": false,
        }]
    });

    $(".modal-transparent").on('show.bs.modal', function() {
        setTimeout(function() {
            $(".modal-backdrop").addClass("modal-backdrop-transparent");
        }, 0);
    });
    $(".modal-transparent").on('hidden.bs.modal', function() {
        $(".modal-backdrop").addClass("modal-backdrop-transparent");
    });

    $(".modal-fullscreen").on('show.bs.modal', function() {
        setTimeout(function() {
            $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
        }, 0);
    });
    $(".modal-fullscreen").on('hidden.bs.modal', function() {
        $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
    });

    $('#purchase_order').on('click', '.clickable-row', function(event) {
        $('#modal-new-product-fullscreen').modal('show');
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('.collapse').collapse();

    $('.collapse').collapse('hide');

    var i = 1;
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
        //$('#addr' + i).html("<td>" + i + "</td><td>" + (i + 1) + "</td><td>" + (i + 1) + "</td><td>" + (i + 1) + "</td><td>" + (i + 1) + "</td><td>" + (i + 1) + "</td><td>" + (i + 1) + "</td>");
        /*$('#invoice_item_list').append('<tr id="addr' + (i + 1) + '"><td>' + i + '</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>');*/
        $('#name').prop('disabled', true);
        $("#modal-new-invoice-fullscreen #name").val("");
        $("#modal-new-invoice-fullscreen #lokasi").val("");
        $("#modal-new-invoice-fullscreen #product_id").val("");
        $("#modal-new-invoice-fullscreen #jumlah").val("");
        $(".product_detail").text("")
        $("#modal-new-invoice-fullscreen #brand").selectpicker('val', "");
        $('#brand').typeahead('destroy');
        $('#brand').val('');
        $('#name').typeahead('destroy');
        $('#name').val('');
        $.get('Brand/getAllBrand', {

        }, function(data) {
            $("#brand").typeahead({
                source: data.data
            });
        }, 'json');
    });

    $("#modal-new-invoice-fullscreen #insert_row").on('click', function() {
        var brand = $('#brand').val();
        var product = $('#name').val();
        var productCode = $('#modal-new-invoice-fullscreen .product_detail').text();
        var jumlah = $('#jumlah').val();
        var productId = $('#product_id').val();
        var locationId = $('#locationId').val();
        var harga = 0;
        $.get('Inventory/getPriceByProductIdAndLocationId?productId=' + productId + '&locationId=' + locationId, {},
            function(data) {

                var priceType = $('#modal-new-invoice-fullscreen #price_type').val();

                /*
                <option >Retail</option>
                <option >Dealer</option>
                <option >Distributor Area</option>
                <option >Bengkel</option>
                */


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
                        '<td id="product_row    ">' + product + '</td>' +
                        '<td>' + productCode + '</td>' +
                        '<td id="jumlah_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="jumlah" name="jumlah" value="' + jumlah + '"></input></td>' +
                        '<td id="harga_row"><input onchange="calculateTotal()" type="text" class="form-control input-sm" id="harga" name="harga" value="' + harga + '"></input></td>' +
                        '<td><button type="button" onclick="removeRow(' + i + ')" data-id="' + i + '" id="delete" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button></td></tr>');
                    $('#invoice_item_list').slideDown(200);
                    calculateTotal();
                });
            }, 'json');



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





    $('#modal-new-invoice-fullscreen #insert').on('click', function() {
        /*	dataDetails=[{test:"1"},{test:"2"},{test:"3"}];
        data = {dataHeader:"1", dataDetail : dataDetails};
        $.post('Invoice/addInvoice', {invoice : JSON.stringify(data)},
            function(data) {}
        );*/

        $('#invoice_item_list tbody tr').each(function() {
            console.log($(this).find('#jumlah_row #jumlah').val());
        });
    });

    $('#invoice_item_list tbody')
        .on(
            'click',
            'td.delete',
            function() {
                alert('delete');
            });


});

function detailInvoice() {
    $('#modal-new-invoice-fullscreen').modal('show');
};

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