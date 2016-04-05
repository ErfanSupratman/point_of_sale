<!-- Modal fullscreen -->
<div class="modal modal-fullscreen fade"
	id="modal-new-invoice-fullscreen" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
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
						<label for="receiver">Nama Penerima</label>
						<input type="text" id="receiver" name="receiver" class="form-control input-sm"/>
						<label for="phone">No. Telepon</label>
						<input type="text" id="phone" name="phone" class="form-control input-sm"/>
						<label for="email">Email</label>
						<input type="text" id="email" name="email" class="form-control input-sm"/>
					</div>
					<div class="col-sm-6">
						<label for="bill_address">Alamat Penagihan</label>
						<textarea class="form-control" rows="5" id="bill_address" name="bill_address"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
					<br/>
					<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-new-invoice-fullscreen">
						<span class="glyphicon glyphicon-plus"></span> Barang
					</button>
					<div class="table-responsive">
						<table id="invoice_item_list" class="table table-striped table-hover" style="font-size:1em" cellspacing="0">
							<thead>
								<tr>
									<th>No.</th>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
									<th class="hidden-xs">Brand</th>
									<th>Jumlah</th>
									<th>Harga</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No.</th>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
									<th class="hidden-xs">Brand</th>
									<th>Jumlah</th>
									<th>Harga</th>
									<th>Action</th>
								</tr>
							</tfoot>
							<tbody>
								<tr>
									<td class="clickable-row">1</td>
									<td class="clickable-row">X-0007</td>
									<td class="clickable-row">Bilt-Hamber auto-wheel</td>
									<td class="hidden-xs">Bilt-Hamber</td>
									<td>1</td>
									<td>Rp. 100000</td>
									<td>
										<button type="button" class="btn btn-danger btn-sm">
											<span class="glyphicon glyphicon-trash"></span>
										</button>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-new-product-fullscreen">
											<span class="glyphicon glyphicon-pencil"></span>
										</button>
									</td>
								</tr>
								<tr>
									<td class="clickable-row">2</td>
									<td class="clickable-row">X-0002</td>
									<td class="clickable-row">Halfords Car Wash</td>
									<td class="hidden-xs">Halfords</td>
									<td>2</td>
									<td>Rp. 200000</td>
									<td>
										<button type="button" class="btn btn-danger btn-sm">
											<span class="glyphicon glyphicon-trash"></span>
										</button>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-new-product-fullscreen">
											<span class="glyphicon glyphicon-pencil"></span>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<label for="notes">Catatan</label>
					<textarea class="form-control" rows="7" id="notes"></textarea>
				</div>
				<div class="col-sm-6">
					<h3>Sub Total : Rp. 300000</h3>
					<h3>Biaya Pengiriman : Rp. 100000</h3>
					<div class="alert alert-warning">
						<h1 style="text-align:center"><strong>Grand Total : Rp. 400000</strong></h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<br/>
				</div>
			</div>
		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-left btn-lg" data-dismiss="modal"><span class="glyphicon glyphicon-thumbs-up"></span> Lunas</button>
				<button type="button" class="btn btn-success btn-lg" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
			</div>
		</div>
	</div>
</div>