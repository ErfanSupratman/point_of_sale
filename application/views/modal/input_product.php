<!-- Modal fullscreen -->
<div class="modal fade" id="modal-new-product-fullscreen" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6">
						<h4 class="modal-title" id="myModalLabel">
							<span class="glyphicon glyphicon-plus"></span> <span
								class="title_header">Tambah Product</span>
						</h4>
					</div>
					<div class="col-sm-6" align="right">
						<button type="button" class="btn btn-default btn-sm"
							data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span>
						</button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="col-sm-12">
						<form id="product_form" action="/">
							<input type="hidden" class="form-control input-sm"
								id="product_id" name="product_id"></input> <label for="brand">Brand</label>
							<div class="input-group">
								<select class="form-control selectpicker input-xs"
									id="brand_new" name="brand_new" data-live-search="true"
									title="Pilih Brand"></select>
							</div>
							<!-- /input-group -->

							<label for="name">Product Name : </label> <input type="text"
								id="name_new" name="name_new" class="form-control input-sm"></input>
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