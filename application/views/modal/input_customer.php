<!-- Modal fullscreen -->
<div class="modal fade"
	id="modal-new-cust-fullscreen" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6">
						<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <span class="title_header">Tambah Customer</span></h4>
					</div>
					<div class="col-sm-6" align="right">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<form action="/" id="cust_form">
						<input type="hidden" id="cust_id" name="cust_id">
							<div class="form-group">
								<label for="user_name_new">Nama Lengkap : </label><input type="text" id="user_name_new" name="user_name_new" class="form-control input-sm"></input>
							</div>
							<div class="form-group">
								<label for="hp_new">No. HP : </label><input type="text" id="hp_new" name="hp_new" class="form-control input-sm"></input>
							</div>
							<div class="form-group">
								<label for="alamat_new">Alamat : </label>
							<textarea class="form-control" rows="5" id="alamat_new" name="alamat_new" ></textarea>
							</div>
							<div class="checkbox">
								<label>
								<input id="active" name="active" type="checkbox"> Aktif
								</label>
							</div>
						</form>
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