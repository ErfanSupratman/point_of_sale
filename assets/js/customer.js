$(document).ready(function() {
	var selected = [];
	var table = $('#customer_table').DataTable({
			select: 'single',
			"processing": true,
			"ajax": "Customer/getAllCustomer",
			"columns": [
				{ "data": "customer_code" },
				{ "data": "nama" },
				{ "data": "telepon" },
				{ "data": "alamat" }
			],
		"columnDefs" : [ {
			"targets" : [ 4],
			"orderable" : false,
			"data": null,
			"className":"delete",
            "defaultContent": "<button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button>"
		}, {
			"targets" : [ 0,1,2,3],
			"orderable" : true,
			"className":"details-control",
		} ]
		});
	
	$('#customer_table tbody').on('click', 'td.details-control', function () {
        var rowData = table.row( this ).data();
		$('#modal-new-cust-fullscreen').modal('show'); 
		$("#modal-new-cust-fullscreen .title_header").text("Ubah Data");
		$("#modal-new-cust-fullscreen #cust_id").val(rowData.id);
    $("#modal-new-cust-fullscreen #user_name_new").val(rowData.nama);
	$("#modal-new-cust-fullscreen #hp_new").val(rowData.telepon);
	$("#modal-new-cust-fullscreen #alamat_new").val(rowData.alamat);
	$("#modal-new-cust-fullscreen #email").val(rowData.email);
	$("#modal-new-cust-fullscreen #pic").val(rowData.pic);
	$("#modal-new-cust-fullscreen #active").prop('checked', Boolean(rowData.active>0));
	$("#modal-new-cust-fullscreen #active").prop('disabled', true);
    $("#modal-new-cust-fullscreen #update").show();
	$("#modal-new-cust-fullscreen #insert").hide();
	$("#modal-new-cust-fullscreen .checkbox").hide();
    } );
	
	$('#customer_table tbody').on('click', 'td.delete', function () {
        var rowData = table.row( this ).data();
		swal({
		  title: "Are you sure?",
		  text: "Delete "+rowData.nama+"!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Yes, delete it!",
		  closeOnConfirm: false
		},
		function(){
		  $.get("Customer/deactiveCustomer?id="+rowData.id, function(data, status){
				if(data.success){
					swal("Deleted!", "Berhasil menghapus "+rowData.nama+"", "success");
					table.ajax.reload();
				}else{
					swal("Failed!", "Gagal menghapus "+rowData.nama+"", "error");
				}			
			});
		  
		});
    } );
	
	$( "#modal-new-cust-fullscreen #update" ).click(function() {
		var id = $("#modal-new-cust-fullscreen #cust_id").val();
		var fullName = $("#modal-new-cust-fullscreen #user_name_new").val();
		$.post( 'Customer/updateCustomer?id='+id, $('form#cust_form').serialize(), function(data) {
			if(data.success){
				swal("Updated!", "Berhasil mengupdate "+fullName+"", "success");
				table.ajax.reload();
				$('#modal-new-cust-fullscreen').modal('hide');
			}else{
				swal("Failed!", "Gagal mengupdate "+fullName+"", "error");
			}
		});
	});

	$( "#modal-new-cust-fullscreen #insert" ).click(function() {
		var fullName = $("#modal-new-cust-fullscreen #user_name_new").val();
		$.post( 'Customer/addCustomer', $('form#cust_form').serialize(), function(data) {
			if(data.success){
				swal("Inserted!", "Berhasil menyimpan "+fullName+"", "success");
				table.ajax.reload();
				$('#modal-new-cust-fullscreen').modal('hide');
			}else{
				swal("Failed!", "Gagal menyimpan "+fullName+"", "error");
			}
		});
	});
	
});


function insertCustomer(){
	$('#modal-new-cust-fullscreen').modal('show'); 
	$("#modal-new-cust-fullscreen .title_header").text("Tambah Data");
    $("#modal-new-cust-fullscreen #user_name_new").val("");
	$("#modal-new-cust-fullscreen #hp_new").val("");
	$("#modal-new-cust-fullscreen #pic").val("");
	$("#modal-new-cust-fullscreen #email").val("");
	$("#modal-new-cust-fullscreen #alamat_new").val("");
	$("#modal-new-cust-fullscreen #active").prop('checked', true);
	$("#modal-new-cust-fullscreen #active").prop('disabled', true);
	$("#modal-new-cust-fullscreen .checkbox").hide();
	
    $("#modal-new-cust-fullscreen #update").hide();
	$("#modal-new-cust-fullscreen #insert").show();
  
};
