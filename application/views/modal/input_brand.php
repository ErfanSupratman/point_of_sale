<!-- Modal fullscreen -->
<div class="modal fade"
	id="modal-new-brand-fullscreen" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6">
						<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-plus"></span> <span class="title_header">Tambah Brand</span></h4>
					</div>
					<div class="col-sm-6" align="right">
						
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
			<div id="preloader">
    <div id="status">&nbsp;</div>
    </div>
				<div class="row">
					<input type="hidden" id="brand_id" name="brand_id"></input>
					<div class="col-sm-12">
						<label for="brand_name">Brand Name : </label><input type="text" id="brand_name" name="brand_name" class="form-control input-sm"></input>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="insert">Simpan</button>
				<button type="button" class="btn btn-success" id="update">Update</button>
			</div>
		</div>
	</div>
</div>