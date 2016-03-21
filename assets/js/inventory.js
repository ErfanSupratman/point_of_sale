$(document)
        .ready(
                function() {
                  $('#name').prop('disabled', true);
                  $('#name_movement').prop('disabled', true);

                  var requestBrand = $.ajax({
                    url: "Brand/getAllBrand",
                    method: "GET",
                    dataType: "json"
                  });

                  requestBrand.done(function(msg) {
                    console.log(msg);
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

                  var table = $('#stock_table')
                          .DataTable(
                                  {
                                    select: 'single',
                                    "processing": true,
                                    "ajax": "Inventory/getAllStock",
                                    "columns": [{
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
                                    "columnDefs": [
                                        {
                                          "targets": [9],
                                          "orderable": false,
                                          "data": null,
                                          "className": "delete",
                                          "defaultContent": "<button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button>"
                                        },
                                        {
                                          "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
                            $("#modal-new-product-fullscreen #product_id").val(
                                    rowData.brand_name);
                            $("#modal-new-product-fullscreen #brand_new")
                                    .selectpicker('val', rowData.brand_id);
                            $("#modal-new-product-fullscreen #update").show();
                            $("#modal-new-product-fullscreen #insert").hide();
                          });

                  $('#purchase_order').on(
                          'click',
                          '.clickable-row',
                          function(event) {
                            $('#modal-new-stock-fullscreen').modal('show');
                            $(this).addClass('active').siblings().removeClass(
                                    'active');
                          });

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

                  $('#name').change(function(e) {

                    var current = $('#name').typeahead("getActive");
                    if (current) {
                      if (current.name == $('#name').val()) {
                        $('.product_detail').fadeOut(500, function() {
                          $(this).text(current.product_code).fadeIn(500);
                        });
                      } else {
                        $('.product_detail').fadeOut(500, function() {
                          $(this).text("product not found!").fadeIn(500);
                        });
                      }
                    } else {
                    }
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
                    } else {
                    }
                  });

                });

function detailProduct() {
  $('#modal-new-product-fullscreen').modal('show');
};

function detailStock() {
  $('#modal-new-stock-fullscreen').modal('show');
};

function detailBrand() {
  $('#modal-new-brand-fullscreen').modal('show');
};