$(document).ready(function() {
	var selected = [];
	 $("#status").fadeOut();
                $("#preloader").fadeOut();
	var table = $('#user_table').DataTable({
			select: 'single',
			"processing": true,
			"ajax": "User/getAllUsers",
			"columns": [
            { "data": "username" },
            { "data": "full_name" },
            { "data": "permission_name" }
			],
		"columnDefs" : [ {
			"targets" : [ 3],
			"orderable" : false,
			"data": null,
			"className":"delete",
            "defaultContent": "<button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button>"
		}, {
			"targets" : [ 0,1,2],
			"orderable" : true,
			"className":"details-control",
		} ]
		});
	
	$('#user_table tbody').on('click', 'td.details-control', function () {
        var rowData = table.row( this ).data();
		$('#modal-new-user-fullscreen').modal('show'); 
		$("#modal-new-user-fullscreen .title_header").text("Ubah Data");
	    $("#modal-new-user-fullscreen #usrname_new").val( rowData.username );
		$("#modal-new-user-fullscreen #full_name_new").val( rowData.full_name );
		$("#modal-new-user-fullscreen #hp_new").val( rowData.telepon );
		$("#modal-new-user-fullscreen #role_new").val( rowData.permission_id );
		$("#modal-new-user-fullscreen #password_new").val( "" );
		$("#modal-new-user-fullscreen #user_id").val(rowData.id)
		$("#modal-new-user-fullscreen #active").prop('checked', Boolean(rowData.active>0));
		$("#modal-new-user-fullscreen #active").prop('disabled', true);
		$("#modal-new-user-fullscreen #update").show();
		$("#modal-new-user-fullscreen #insert").hide();
		$("#modal-new-user-fullscreen .checkbox").hide();
    } );
	
	$('#user_table tbody').on('click', 'td.delete', function () {
        var rowData = table.row( this ).data();
		swal({
		  title: "Are you sure?",
		  text: "Delete "+rowData.full_name+"!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Yes, delete it!",
		  closeOnConfirm: false
		},
		function(){
		  $.get("User/deactiveUser?id="+rowData.id, function(data, status){
				if(data.success){
					swal("Deleted!", "Berhasil menghapus "+rowData.full_name+"", "success");
					table.ajax.reload();
				}else{
					swal("Failed!", "Gagal menghapus "+rowData.full_name+"", "error");
				}			
			});
		  
		});
    } );
	
	$( "#modal-new-user-fullscreen #update" ).click(function() {
		 $("#status").fadeIn();
                $("#preloader").fadeIn();
		var id = $("#modal-new-user-fullscreen #user_id").val();
		var fullName = $("#modal-new-user-fullscreen #full_name_new").val();
		$.post( 'User/updateUser?id='+id, $('form#user_form').serialize(), function(data) {
			 $("#status").fadeOut();
                $("#preloader").fadeOut();
			if(data.success){
				swal("Updated!", "Berhasil mengupdate "+fullName+"", "success");
				table.ajax.reload();
				$('#modal-new-user-fullscreen').modal('hide');
			}else{
				swal("Failed!", data.error, "error");
			}
		});
	});

	$( "#modal-new-user-fullscreen #insert" ).click(function() {
		 $("#status").fadeIn();
                $("#preloader").fadeIn();
		var fullName = $("#modal-new-user-fullscreen #full_name_new").val();
		$.post( 'User/addUser', $('form#user_form').serialize(), function(data) {
			 $("#status").fadeOut();
                $("#preloader").fadeOut();
			if(data.success){
				swal("Inserted!", "Berhasil menyimpan "+fullName+"", "success");
				table.ajax.reload();
				$('#modal-new-user-fullscreen').modal('hide');
			}else{
				swal("Failed!", data.error, "error");
			}
		});
	});
	
});


function insertUser(){
	$('#modal-new-user-fullscreen').modal('show'); 
	$("#modal-new-user-fullscreen .title_header").text("Tambah Data");
    $("#modal-new-user-fullscreen #usrname_new").val("");
	$("#modal-new-user-fullscreen #full_name_new").val("");
	$("#modal-new-user-fullscreen #user_id").val("");
	$("#modal-new-user-fullscreen #password_new").val("");
	$("#modal-new-user-fullscreen #hp_new").val("");
	$("#modal-new-user-fullscreen #role_new").val("0");
	$("#modal-new-user-fullscreen #active").prop('checked', true);
	$("#modal-new-user-fullscreen #active").prop('disabled', true);
	$("#modal-new-user-fullscreen .checkbox").hide();
    $("#modal-new-user-fullscreen #update").hide();
	$("#modal-new-user-fullscreen #insert").show();

  
};
