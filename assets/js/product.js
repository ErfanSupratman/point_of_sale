$(document)
        .ready(
                function() {
                  var selected = [];

                  var requestBrand = $.ajax({
                    url: "Brand/getAllBrand",
                    method: "GET",
                    dataType: "json"
                  });

                  requestBrand.done(function(msg) {
                    console.log(msg);
                    var options;
                    $.each(msg.data, function(i, item) {
                      $('#modal-new-product-fullscreen #brand_new').append(
                              $("<option></option>").attr("value", item.id)
                                      .text(item.name));
                      console.log(item.id);
                      $('#modal-new-product-fullscreen #brand_new')
                              .selectpicker('refresh');
                    });
                  });

                  requestBrand.fail(function(jqXHR, textStatus) {
                    console.log(textStatus)
                  });

                  var table = $('#product_table')
                          .DataTable(
                                  {
                                    select: 'single',
                                    "processing": true,
                                    "ajax": "Product/getAllProduct",
                                    "columns": [{
                                      "data": "product_code"
                                    }, {
                                      "data": "name"
                                    }, {
                                      "data": "brand_name"
                                    }],
                                    "columnDefs": [
                                        {
                                          "targets": [3],
                                          "orderable": false,
                                          "data": null,
                                          "className": "delete",
                                          "defaultContent": "<button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button>"
                                        }, {
                                          "targets": [0, 1, 2],
                                          "className": "details-control",
                                        }]
                                  });

                  $('.selectpicker').selectpicker({
                    style: 'btn-info',
                    size: 8
                  });

                  $('#product_table tbody').on(
                          'click',
                          'td.details-control',
                          function() {
                            var rowData = table.row(this).data();
                            $('#modal-new-product-fullscreen').modal('show');
                            $("#modal-new-product-fullscreen .title_header")
                                    .text("Ubah Data");
                            $("#modal-new-product-fullscreen #name_new").val(
                                    rowData.name);
                            $("#modal-new-product-fullscreen #product_id").val(
                                    rowData.id);
                            $("#modal-new-product-fullscreen #brand_new")
                                    .selectpicker('val', rowData.brand_id);
                            $("#modal-new-product-fullscreen #update").show();
                            $("#modal-new-product-fullscreen #insert").hide();
                          });

                  $('#product_table tbody')
                          .on(
                                  'click',
                                  'td.delete',
                                  function() {
                                    var rowData = table.row(this).data();
                                    swal(
                                            {
                                              title: "Are you sure?",
                                              text: "Delete " + rowData.name
                                                      + "!",
                                              type: "warning",
                                              showCancelButton: true,
                                              confirmButtonColor: "#DD6B55",
                                              confirmButtonText: "Yes, delete it!",
                                              closeOnConfirm: false
                                            },
                                            function() {
                                              $
                                                      .get(
                                                              "Product/deactiveProduct?id="
                                                                      + rowData.id,
                                                              function(data,
                                                                      status) {
                                                                if (data.success) {
                                                                  swal(
                                                                          "Deleted!",
                                                                          "Berhasil menghapus "
                                                                                  + rowData.name
                                                                                  + "",
                                                                          "success");
                                                                  table.ajax
                                                                          .reload();
                                                                } else {
                                                                  swal(
                                                                          "Failed!",
                                                                          "Gagal menghapus "
                                                                                  + rowData.name
                                                                                  + "",
                                                                          "error");
                                                                }
                                                              });

                                            });
                                  });

                  $("#modal-new-product-fullscreen #update")
                          .click(
                                  function() {
                                    var id = $(
                                            "#modal-new-product-fullscreen #product_id")
                                            .val();
                                    var fullName = $(
                                            "#modal-new-product-fullscreen #name_new")
                                            .val();
                                    $
                                            .post(
                                                    'Product/updateProduct?id='
                                                            + id,
                                                    $('form#product_form')
                                                            .serialize(),
                                                    function(data) {
                                                      if (data.success) {
                                                        swal(
                                                                "Updated!",
                                                                "Berhasil mengupdate "
                                                                        + fullName
                                                                        + "",
                                                                "success");
                                                        table.ajax.reload();
                                                        $(
                                                                '#modal-new-product-fullscreen')
                                                                .modal('hide');
                                                      } else {
                                                        swal(
                                                                "Failed!",
                                                                "Gagal mengupdate "
                                                                        + fullName
                                                                        + "",
                                                                "error");
                                                      }
                                                    });
                                  });

                  $("#modal-new-product-fullscreen #insert").click(
                          function() {
                            var fullName = $(
                                    "#modal-new-product-fullscreen #name_new")
                                    .val();
                            $.post('Product/addProduct', $('form#product_form')
                                    .serialize(), function(data) {
                              if (data.success) {
                                swal("Inserted!", "Berhasil menyimpan "
                                        + fullName + "", "success");
                                table.ajax.reload();
                                $('#modal-new-product-fullscreen')
                                        .modal('hide');
                              } else {
                                swal("Failed!", "Gagal menyimpan " + fullName
                                        + "", "error");
                              }
                            });
                          });

                  $('#add_brand').click(function() {
                    $('#other_brand_new').show();
                    $('#brand_new').hide();
                    $('#cancel_brand').show();
                    $('#add_brand').hide();
                  });

                  $('#cancel_brand').click(function() {
                    $('#other_brand_new').val("");
                    $('#other_brand_new').hide();
                    $('#brand_new').show();
                    $('#cancel_brand').hide();
                    $('#add_brand').show();
                  });

                  $('#name').prop('disabled', true);
                  $('#name_movement').prop('disabled', true);
                  $('[data-toggle="tooltip"]').tooltip();
                  $('#other_brand_new').hide();
                  $('#cancel_brand').hide();

                });

function insertProduct() {
  $('#modal-new-product-fullscreen').modal('show');
  $("#modal-new-product-fullscreen .title_header").text("Tambah Data");
  $("#modal-new-product-fullscreen #name_new").val("");
  $('#modal-new-product-fullscreen #brand_new').selectpicker('val', '');

  $('#modal-new-product-fullscreen #update').hide();
  $('#modal-new-product-fullscreen #insert').show();

};
