$(document).ready(function() {
	$('#name').prop('disabled', true);
	$('#name_movement').prop('disabled', true);
	$('#purchase_order').DataTable({
		"order" : [],
		"columnDefs" : [ {
			"targets" : [ 0, 1, 2, 3, 4],
			"orderable" : false,
		} ]
	});
	
	$('.datepicker').datepicker();
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
	
	$('#brand').change(function(){
		$('#name').typeahead('destroy')
		if($('#brand').val()=='Bilt-Hamber'){
			$('#name').prop('disabled', false);
			$('#name').typeahead({
				source : [ {
					id : "X-0001",
					name : "Bilt-Hamber auto-wash"
				}, {
					id : "X-0007",
					name : "Bilt-Hamber auto-wheel"
				} ],
				autoSelect : true
			});
		}else if($('#brand').val()=='Halfords'){
			$('#name').prop('disabled', false);
			$('#name').typeahead({
				source : [ {
					id : "X-0002",
					name : "Halfords Car Wash"
				} ],
				autoSelect : true
			});
		}else if($('#brand').val()=='Simoniz'){
			$('#name').prop('disabled', false);
			$('#name').typeahead({
				source : [ {
					id : "X-0005",
					name : "Simoniz Alloy Clean Plus"
				}, {
					id : "X-0003",
					name : "Simoniz Protection Car Wash"
				} ],
				autoSelect : true
			});
		}else{
			$('#name').prop('disabled', true);
		}
		
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
					$(this).text(current.id).fadeIn(500);
				});
			} else {
				console.log($('#brand').val());
				$('.product_detail').fadeOut(500, function() {
					$(this).text("product not found!").fadeIn(500);
				});
			}
		} else {
		}
	});
	
	$('#brand_movement').change(function(){
		if($('#brand_movement').val()=='Bilt-Hamber'){
			$('#name_movement').prop('disabled', false);
			$('#name_movement').typeahead({
				source : [ {
					id : "X-0001",
					name : "Bilt-Hamber auto-wash"
				}, {
					id : "X-0007",
					name : "Bilt-Hamber auto-wheel"
				} ],
				autoSelect : true
			});
		}else if($('#brand_movement').val()=='Halfords'){
			$('#name_movement').prop('disabled', false);
			$('#name_movement').typeahead({
				source : [ {
					id : "X-0002",
					name : "Halfords Car Wash"
				} ],
				autoSelect : true
			});
		}else if($('#brand_movement').val()=='Simoniz'){
			$('#name_movement').prop('disabled', false);
			$('#name_movement').typeahead({
				source : [ {
					id : "X-0005",
					name : "Simoniz Alloy Clean Plus"
				}, {
					id : "X-0003",
					name : "Simoniz Protection Car Wash"
				} ],
				autoSelect : true
			});
		}else{
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

function detailInvoice(){
	$('#modal-new-invoice-fullscreen').modal('show'); 
};

