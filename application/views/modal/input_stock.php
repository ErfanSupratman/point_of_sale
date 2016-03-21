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
					<div class="col-sm-6">
						<label for="brand">Brand</label> <select
							class="form-control input-xs" id="brand" name="brand"
							data-live-search="true" title="Pilih Brand"></select> <label
							for="name">Product Name : </label> <input type="text" id="name"
							class="form-control input-sm" name="name"
							data-provide="typeahead"></input> <label for="name">Product Code
							: </label> <br /> <span class="product_detail"></span> <br /> <label
							for="lokasi">Lokasi Stock</label>
						<div class="select-style">
							<select class="form-control input-sm" id="lokasi" name="lokasi">
								<option>Pilih</option>
								<option>Gudang</option>
								<option>Pinjam</option>
								<option>Showroom</option>
							</select>
						</div>
						<label for="jumlah">Jumlah</label> <input id="jumlah" type="text"
							class="form-control input-sm" name="jumlah" />
					</div>
					<div class="col-sm-6">
						<label for="hargab">Harga Beli</label>
						<div class="row">
							<div class="col-sm-4">
								<select class="form-control input-sm" id="currency">
									<option value="">Select Currency</option>
									<option value="AUD">Australian Dollar</option>
									<option value="BRL">Brazilian Real</option>
									<option value="CAD">Canadian Dollar</option>
									<option value="CZK">Czech Koruna</option>
									<option value="DKK">Danish Krone</option>
									<option value="EUR">Euro</option>
									<option value="HKD">Hong Kong Dollar</option>
									<option value="HUF">Hungarian Forint</option>
									<option value="IDR">Indonesian Rupiah</option>
									<option value="ILS">Israeli New Sheqel</option>
									<option value="JPY">Japanese Yen</option>
									<option value="MYR">Malaysian Ringgit</option>
									<option value="MXN">Mexican Peso</option>
									<option value="NOK">Norwegian Krone</option>
									<option value="NZD">New Zealand Dollar</option>
									<option value="PHP">Philippine Peso</option>
									<option value="PLN">Polish Zloty</option>
									<option value="GBP">Pound Sterling</option>
									<option value="SGD">Singapore Dollar</option>
									<option value="SEK">Swedish Krona</option>
									<option value="CHF">Swiss Franc</option>
									<option value="TWD">Taiwan New Dollar</option>
									<option value="THB">Thai Baht</option>
									<option value="TRY">Turkish Lira</option>
									<option value="USD" SELECTED="YES">U.S. Dollar</option>
								</select>
							</div>
							<div class="col-sm-4">
								<input id="hargab" type="text" placeholder="harga"
									class="form-control input-sm" name="hargab" />
							</div>
							<div class="col-sm-4">
								<input id="kurs" placeholder="Kurs" type="text"
									class="form-control input-sm" />
							</div>
						</div>
						<label for="hargada">Harga Distributor Area</label> <input
							id="hargada" type="text" class="form-control input-sm"
							name="hargada" /> <label for="hargabe">Harga Bengkel</label> <input
							id="hargabe" type="text" class="form-control input-sm"
							name="hargabe" /> <label for="hargare">Harga Retail</label> <input
							id="hargare" type="text" class="form-control input-sm"
							name="hargare" />
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