<!-- Modal fullscreen -->
<div class="modal modal-fullscreen fade"
	id="modal-new-invoice-fullscreen" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="#" id="invoice_form">
				<div class="modal-header">
					<div class="row">
						<div class="col-sm-6">
							<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-file"></span> Invoice</h4>
						</div>
						<div class="col-sm-6" align="right">
							<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-print"></span></button>
							<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label for="billing_name">Nama Penerima</label>
							<input type="text" id="billing_name" name="billing_name" class="form-control input-sm"/>
							<label for="billing_phone">No. Telepon</label>
							<input type="text" id="billing_phone" name="billing_phone" class="form-control input-sm"/>
							<label for="billing_email">Email</label>
							<input type="text" id="billing_email" name="billing_email" class="form-control input-sm"/>
						</div>
						<div class="col-sm-6">
							<label for="billing_address">Alamat Penagihan</label>
							<textarea class="form-control" rows="3" id="billing_address" name="billing_address"></textarea>
							<label for="lokasi">Lokasi Stock</label>
							<div class="select-style">
								<select class="form-control input-sm" id="locationId" name="locationId">
									<option>Pilih</option>
									<option value="1">Gudang</option>
									<option value="2">Pinjam</option>
									<option value="3">Showroom</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						
						<div class="col-sm-12">
							<hr/>
							<button id="add_row" type="button" class="btn btn-success btn-sm pull-left" data-toggle="collapse" data-target="#insertDetailForm">Add Row</button>
							<br/>
							<br/>
							<div class="well collapse out" id="insertDetailForm">
								<div class="row">
									<div class="col-sm-2">
										<label for="brand">Brand</label>
										<!-- <select class="form-control input-xs input-sm" id="brand" name="brand"data-live-search="true" autocomplete="false" title="Pilih Brand"></select> -->
										<input type="text" id="brand"
										class="form-control input-sm" name="brand"
										data-provide="typeahead" autocomplete="off"></input>
										<input type="hidden"
										id="brand_id" name="brand_id"></input>
									</div>
									<div class="col-sm-2">
										<label
										for="name">Nama Barang</label>
										<input type="text" id="name"
										class="form-control input-sm" name="name"
										data-provide="typeahead" autocomplete="off"></input>
										<input type="hidden"
										id="product_id" name="product_id"></input>
									</div>
									<div class="col-sm-2">
										<label for="name">Kode Barang</label> <br /> <span class="product_detail"></span>
									</div>
									<div class="col-sm-2">
										<label for="price_type">Tipe Harga</label>
										<select id="price_type" class="form-control input-sm" name="price_type">
											<option>Pilih</option>
											<option >Retail</option>
											<option >Dealer</option>
											<option >Distributor Area</option>
											<option >Bengkel</option>
										</select>
									</div>
									<div class="col-sm-2">
										<label for="jumlah">Jumlah</label>
										<input type="text" id="jumlah" class="form-control input-sm" name="jumlah"></input>
									</div>
									<div class="col-sm-2">
										<br/>
										<button type="button" id="insert_row" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
									</div>
									<div class="col-sm-2">
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br/>
							<div class="table-responsive">
								
								
								<table id="invoice_item_list" class="table table-striped table-hover" style="font-size:1em" cellspacing="0">
									<thead>
										<tr>
											<th>No.</th>
											<th>Brand</th>
											<th>Nama Barang</th>
											<th>Kode Barang</th>
											<th>Jumlah</th>
											<th>Harga</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label for="notes">Catatan</label>
							<textarea class="form-control" rows="3" id="notes" name="notes"></textarea>
						</div>
						<div class="col-sm-6">
							<h3>Sub Total : Rp. <span class="subTotal">0</span></h3>
							<h3>Biaya Pengiriman : <input type="text" class="form-control input-sm"
							id="freight" name="freight"></input></h3>
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br/>
							<div class="alert alert-warning">
								<h2 style="text-align:center"><strong>Grand Total : Rp. <span class="grandTotal">0</span></strong></h2>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger pull-left btn-lg" data-dismiss="modal"><span class="glyphicon glyphicon-thumbs-up"></span> Lunas</button>
					<button type="button" class="btn btn-success btn-lg" id="insert"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>