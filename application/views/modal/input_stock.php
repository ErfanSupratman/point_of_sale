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
					<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
				<?php if(!in_array("SUPER_ADMIN", $permissions)){
					$readOnly="readOnly";
				}else{
					$readOnly="";
				}?>
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
							<label for="brand">Brand</label> 
							<div class="brand">
								<select
								class="form-control input-xs" id="brand" readonly="true" name="brand"
							data-live-search="true" title="Pilih Brand"></select>
							
						</div><br/>
							<span id="brand_name"></span>
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
							class="form-control input-sm" <?=$readOnly?> name="jumlah" />
						</div>
						<div class="col-sm-6">
							<?php if(in_array("BUY_PRICE", $permissions) || in_array("SUPER_ADMIN", $permissions)){ ?>
								<label  for="hargab">Harga Beli</label>
								<input <?=$readOnly?> id="hargab" type="text" class="form-control input-sm" name="hargab" />
							<?php }?>
								
							<?php if(in_array("VIEW_SELL_PRICE", $permissions) || in_array("SUPER_ADMIN", $permissions)){ ?>
								<label for="hargabe">Harga CNT.</label>
								<input <?=$readOnly?> id="hargabe" type="text" class="form-control input-sm" name="hargabe" />
								<label for="hargada">Harga Distributor Area</label>
								<input <?=$readOnly?> id="hargada" type="text" class="form-control input-sm" name="hargada" />
								<label for="hargare">Harga Dealer</label>
								<input <?=$readOnly?> id="hargadl" type="text" class="form-control input-sm" name="hargadl" />
								<label for="hargare">Harga Retail</label>
								<input <?=$readOnly?> id="hargare" type="text" class="form-control input-sm" name="hargare" />
							<?php }?>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<?php 
							if(in_array("SUPER_ADMIN", $permissions)){
								echo '<button type="button" class="btn btn-success" id="insert">Simpan</button>
				<button type="button" class="btn btn-success" id="update">Update</button>';
							} 
						?>
				
			</div>
		</div>
	</div>
</div>