<!-- Modal fullscreen -->
<div class="modal fade"
	id="modal-new-user-fullscreen" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6">
						<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <span class="title_header">Tambah User</span></h4>
					</div>
					<div class="col-sm-6" align="right">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="col-sm-12">
						<form action="/" id="user_form">
						
						<input type="hidden" id="user_id" name="user_id" class="form-control input-sm"></input>
						
						<div class="form-group">
							<label for="full_name_new">Nama Lengkap : </label><input type="text" id="full_name_new" name="full_name_new" class="form-control input-sm"></input>
						</div>
						<div class="form-group">
							<label for="hp_new">No. HP : </label><input type="text" id="hp_new" name="hp_new" class="form-control input-sm"></input>
						</div>
						<div class="form-group">
							<label for="username_new">Username : </label><input type="text" id="usrname_new" name="username_new" class="form-control input-sm"></input>
						</div>
						<div class="form-group">
							<label for="password_new">Password : </label><input type="password" id="password_new" name="password_new" class="form-control input-sm"></input>
						</div>
						<div class="form-group">
							<label for="role_new">Permission : </label>
						</div>
						<div class="form-group">
							<select class="form-control input-sm" id="role_new" name="role_new">
								<option value="0">Pilih Permission</option>
								<option value="1">Administrator</option>
								<option value="2">Invoice</option>
								<option value="3">Stock</option>
								<option value="4">Invoice & Stock</option>
								<option value="5">Manager</option>
							</select>
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
				<button type="button" class="btn btn-success" id="update">Update</button>
				<button type="button" class="btn btn-success" id="insert">Simpan</button>
			</div>
		</div>
	</div>
</div>