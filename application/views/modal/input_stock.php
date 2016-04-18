<!-- Modal fullscreen -->
<div class="modal modal-fullscreen fade" id="modal-new-stock-fullscreen"
	tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6">
						<h4 class="modal-title" id="myModalLabel">
							<span class="glyphicon glyphicon-plus"></span> Tambah Stock
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
					<form action="/" id="stock_form">
						<div class="col-sm-6">
							<input type="hidden" id="id" name="id"></input>
							<label for="lokasi">Lokasi Stock</label><br/>
							<span id="lokasi_detail"></span>
							<div class="select-style">
								<select class="form-control input-sm" id="lokasi" name="lokasi">
									<option>Pilih</option>
									<option value="1">Gudang Ryan</option>
									<option value="2">Gudang Willy</option>
									<option value="3">Gudang Showroom</option>
									<option value="4">Gudang Pinjaman</option>
								</select>
							</div>
							<div class="form-group">
								<label for="brand">Brand</label> <select
									class="form-control input-xs" id="brand" name="brand"
									data-live-search="true" title="Pilih Brand"></select> 
							</div>

							<div class="form-group">
							<label
								for="name">Product Name : </label>
							 <input type="text" id="name"
								class="form-control input-sm" name="name"
								data-provide="typeahead" autocomplete="off"></input><input type="hidden"
								id="product_id" name="product_id"></input>
							</div>
								 <label for="name">Product
								Code : </label> <br /> <span class="product_detail"></span> <br />
							
							
							<label for="jumlah">Jumlah</label> <input id="jumlah" type="text"
								class="form-control input-sm" name="jumlah" />
						</div>
						<div class="col-sm-6">
							<label  for="hargab">Harga Beli</label>	
							<input id="hargab" type="text" class="form-control input-sm" name="hargab" />
							<label for="hargabe">Harga CNT.</label> 
							<input id="hargabe" type="text" class="form-control input-sm" name="hargabe" />
							<label for="hargada">Harga Distributor Area</label> 
							<input id="hargada" type="text" class="form-control input-sm" name="hargada" /> 
							<label for="hargare">Harga Dealer</label>
							<input id="hargadl" type="text" class="form-control input-sm" name="hargadl" />
							<label for="hargare">Harga Retail</label>
							<input id="hargare" type="text" class="form-control input-sm" name="hargare" />
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="insert">Simpan</button>
				<button type="button" class="btn btn-success" id="update">Update</button>
			</div>
		</div>
	</div>
</div>