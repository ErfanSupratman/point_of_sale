$(document).ready(function() {
        var selected = [];
        var table = $('#brand_table').DataTable({
            select: 'single',
            "processing": true,
            "ajax": "Brand/getAllBrand",
            "columns": [{
                "data": "brand_code"
            }, {
                "data": "name"
            }],
            "columnDefs": [{
                "targets": [2],
                "orderable": false,
                "data": null,
                "className": "delete",
                "defaultContent": "<button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button>"
            }, {
                "targets": [0, 1],
                "className": "details-control",
            }]
        });

        $('#brand_table tbody').on('click', 'td.details-control', function() {
            var rowData = table.row(this).data();
            $('#modal-new-brand-fullscreen').modal('show');
            $("#modal-new-brand-fullscreen .title_header").text("Ubah Data");
            $("#modal-new-brand-fullscreen #brand_name").val(rowData.name);
            $("#modal-new-brand-fullscreen #brand_id").val(rowData.id)
            $("#modal-new-brand-fullscreen #active").prop('checked', Boolean(rowData.active > 0));
            $("#modal-new-brand-fullscreen #active").prop('disabled', true);
            $("#modal-new-brand-fullscreen #update").show();
            $("#modal-new-brand-fullscreen #insert").hide();
            $("#modal-new-brand-fullscreen .checkbox").hide();
        });

        $('#brand_table tbody').on('click', 'td.delete', function() {
            var rowData = table.row(this).data();
            swal({
                    title: "Are you sure?",
                    text: "Delete " + rowData.name + "!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function() {
                    $.get("Brand/deactiveBrand?id=" + rowData.id, function(data, status) {
                        if (data.success) {
                            swal("Deleted!", "Berhasil menghapus " + rowData.name + "", "success");
                            table.ajax.reload();
                        } else {
                            swal("Failed!", "Gagal menghapus " + rowData.name + "", "error");
                        }
                    });

                });
        });

         $("#status").fadeOut();
                $("#preloader").fadeOut();

        $("#modal-new-brand-fullscreen #update").click(function() {
             $("#status").fadeIn();
                $("#preloader").fadeIn();
            console.log("update clicked");
            var id = $("#modal-new-brand-fullscreen #brand_id").val();
            var fullName = $("#modal-new-brand-fullscreen #brand_name").val();
            $.post('Brand/updateBrand?id=' + id, {brand_name:fullName}, function(data) {
                 $("#status").fadeOut();
                $("#preloader").fadeOut();
                if (data.success) {
                    swal("Updated!", "Berhasil mengupdate " + fullName + "", "success");
                    table.ajax.reload();
                    $('#modal-new-brand-fullscreen').modal('hide');
                } else {
                    swal("Failed!", "Gagal mengupdate " + fullName + "", "error");
                }
            });
        });

        $("#modal-new-brand-fullscreen #insert").click(function() {
             $("#status").fadeIn();
                $("#preloader").fadeIn();
            var fullName = $("#modal-new-brand-fullscreen #brand_name").val();
            $.post('Brand/addBrand',  {brand_name:fullName}, function(data) {
                 $("#status").fadeOut();
                $("#preloader").fadeOut();
                if (data.success) {
                    swal("Inserted!", "Berhasil menyimpan " + fullName + "", "success");
                    table.ajax.reload();
                    $('#modal-new-brand-fullscreen').modal('hide');
                } else {
                    swal("Failed!", data.error, "error");
                }
            });
        });

        $("#modal-new-brand-fullscreen #brand_name").keyup(function(event) {
            if (event.keyCode == 13) {
                var brandId = $("#modal-new-brand-fullscreen #brand_id").val();
                var fullName = $("#modal-new-brand-fullscreen #brand_name").val();
                if (brandId == "") {
                    $.post('Brand/addBrand', {'brand_name':fullName}, function(data) {
                        if (data.success) {
                            swal("Inserted!", "Berhasil menyimpan " + fullName + "", "success");
                            table.ajax.reload();
                            $('#modal-new-brand-fullscreen').modal('hide');
                        } else {
                            swal("Failed!", data.error, "error");
                        }
                    });
                } else {
                	$.post('Brand/updateBrand?id=' + brandId, {'brand_name':fullName}, function(data) {
                if (data.success) {
                    swal("Updated!", "Berhasil mengupdate " + fullName + "", "success");
                    table.ajax.reload();
                    $('#modal-new-brand-fullscreen').modal('hide');
                } else {
                    swal("Failed!", data.error, "error");
                }
            });
                }
            }

        });
});

        function insertBrand() {
            $('#modal-new-brand-fullscreen').modal('show');
            $("#modal-new-brand-fullscreen .title_header").text("Tambah Data");
            $("#modal-new-brand-fullscreen #brand_name").val("");
            $("#modal-new-brand-fullscreen #active").prop('checked', true);
            $("#modal-new-brand-fullscreen #active").prop('disabled', true);
            $("#modal-new-brand-fullscreen .checkbox").hide();
            $("#modal-new-brand-fullscreen #brand_id").val("");

            $("#modal-new-brand-fullscreen #update").hide();
            $("#modal-new-brand-fullscreen #insert").show();

        };