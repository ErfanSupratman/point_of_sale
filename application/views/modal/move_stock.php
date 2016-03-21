<!-- Modal fullscreen -->
<div class="modal modal-fullscreen fade" id="modal-move-stock-fullscreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6">
						<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-transfer"></span> Pindah Stock</h4>
					</div>
					<div class="col-sm-6" align="right">
						
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6">
						<label for="brand_movement">Brand</label><select class="form-control input-sm" id="brand_movement">
								<option value="0">Pilih brand</option>
								<option value="Bilt-Hamber">Bilt-Hamber</option>
								<option value="Halfords">Halfords</option>
								<option value="Simoniz">Simoniz</option>
							</select> <label
							for="name">Product Name : </label><input type="text" id="name_movement"
							class="form-control input-sm" data-provide="typeahead"></input>
							<label for="code">Product Code :
						</label><br /> <span class="product_detail_movement"></span> <br />	
					</div>
					<div class="col-sm-6">
						<label for="lokasi_awal">Lokasi Stock Awal</label>
						<div class="select-style">
							<select class="form-control" id="lokasi_awal">
								<option>Pilih</option>
								<option>Gudang</option>
								<option>Pinjam</option>
								<option>Showroom</option>
							</select>
						</div>
						<label for="jumlah">Jumlah</label>
						<input id="jumlah" type="text" readonly="true" value="100" class="form-control"/>
						<label for="lokasi_tujuan">Lokasi Stock Tujuan</label>
						<div class="select-style">
							<select class="form-control" id="lokasi_tujuan">
								<option>Pilih</option>
								<option>Gudang</option>
								<option>Pinjam</option>
								<option>Showroom</option>
							</select>
						</div>
						<label for="jumlah_tujuan">Jumlah</label>
						<input id="jumlah_tujuan" type="text" class="form-control"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Simpan</button>
			</div>
		</div>
	</div>
</div>