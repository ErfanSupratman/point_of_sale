<!-- Modal fullscreen -->
<div class="modal modal-fullscreen fade" id="modal-new-booking-fullscreen"
	tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6">
						<h4 class="modal-title" id="myModalLabel">
							<span class="glyphicon glyphicon-plus"></span> <span class="title_header">Tambah Booking</span>
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
					<form action="/" id="booking_form">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="stock_code">Stock Code</label><br/><span class="stock_code"></span>
							</div>
							<div class="form-group">
								<label for="product_code">Product Code/Name</label><br/><span class="product_code"></span>/<span class="product_name"></span>
							</div>
							<div class="form-group">
								<label for="available_stock">Available Stock</label><br/><span class="available_stock"></span>
							</div>
							<div class="form-group">
								<input type="hidden" id="stock_id" name="stock_id"></input>
								<label for="quantity">Jumlah</label> <input id="quantity" type="text"
									class="form-control input-sm" name="quantity" />
							</div>
							<div class="form-group">
								<label for="notes">Catatan</label><textarea class="form-control" rows="7" name="notes" id="notes"></textarea>
							</div>
							<button type="button" class="btn btn-success" id="insert">Simpan</button>
						</div>
						<div class="col-sm-6">
							<table id="booking_table" class="table table-striped table-hover"
							style="font-size: 1em" cellspacing="0" width="98%">
							<thead>
								<tr>
									<th>Booking Date</th>
									<th>Created By</th>
									<th>Booking Code</th>
									<th>Jumlah</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>