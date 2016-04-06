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
    });

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
        $("#modal-new-invoice-fullscreen #hargabe").val(0);
        i++;
    });

    $('#modal-new-invoice-fullscreen #brand').change(function() {
        $('#name').typeahead('destroy');

        if ($('#modal-new-invoice-fullscreen #brand').val() != undefined) {
            $('#name').prop('disabled', false);
            $('#price_type').prop('disabled', false);
        }



        $.get('Product/findProductByBrandId', {
            brandId: $('#modal-new-invoice-fullscreen #brand').val()
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
                                        '#modal-new-invoice-fullscreen #product_id')
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



    $('#modal-new-invoice-fullscreen #insert').on('click', function() {
        alert('asdasd');
        console.log($('form#invoice_form')
            .serialize());
        /*	dataDetails=[{test:"1"},{test:"2"},{test:"3"}];
        data = {dataHeader:"1", dataDetail : dataDetails};
        $.post('Invoice/addInvoice', {invoice : JSON.stringify(data)},
            function(data) {}
        );*/
    });


});

function detailInvoice() {
    $('#modal-new-invoice-fullscreen').modal('show');
};