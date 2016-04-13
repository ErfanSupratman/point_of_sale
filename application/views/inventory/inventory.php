<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
		<?php
		$this->load->view ( 'navigation/head' );
	?>
	<body>
		<?php
			$this->load->view('navigation/main');
		?>
		<div class="container-fluid" >
			<div id="body" class="padding-top-80px">
				<div class="row">
					<?php
					// inventory top menu
					$this->load->view('navigation/inventory_top');
					// inventory new stock modal
					$this->load->view('modal/input_stock.php');
					// inventory new booking modal
					$this->load->view('modal/input_booking.php');
					// inventory move stock
					$this->load->view('modal/move_stock.php');
					$this->load->view('modal/history_stock.php');
					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br />
					<div class="col-sm-12">
						<!-- Button modal fullscreen
						<button type="button" id="moveStock" class="btn btn-warning btn-md">
							<span class="glyphicon glyphicon-transfer"></span> Pindah Stock
						</button>
						-->
						<button type="button" id="addStock" onclick="addStock()" class="btn btn-success btn-md hidden-xs hidden-sm">
						<span class="glyphicon glyphicon-plus"></span> Tambah Stock Barang
						</button>
						<button type="button" id="addStock" onclick="addStock()" class="btn btn-success btn-md hidden-lg hidden-md btn-block">
						<span class="glyphicon glyphicon-plus"></span> Tambah Stock Barang
						</button>
						<!--<div class="select-style pull-right hidden-sm hidden-xs"
										style="width: 200px">
										<select class="form-control input-md" id="lokasi_stock">
														<option>Filter Lokasi</option>
														<option>Gudang</option>
														<option>Pinjam</option>
														<option>Showroom</option>
										</select>
						</div>
						<div class="hidden-lg hidden-md">
										<br />
										<div class="select-style">
														<select class="form-control input-md" id="lokasi_stock">
																		<option>Filter Lokasi</option>
																		<option>Gudang</option>
																		<option>Pinjam</option>
																		<option>Showroom</option>
														</select>
										</div>
						</div>-->
						<br />
						<hr />
						<?php echo $inventory_content ?>
						<div class="table-responsive">
							<table id="stock_table" class="table table-striped table-hover"
								style="font-size: 1em" cellspacing="0" width="98%">
								<thead>
									<tr>
										<th>Brand</th>
										<th>Nama Produk</th>
										<th>Jumlah</th>
										<th>Hrg. Bengkel</th>
										<th>Hrg. Dist. Area</th>
										<th>Hrg. Dealer</th>
										<th>Hrg. Retail</th>
										<th>Lokasi</th>
										<!-- <th>Booking</th> -->
										<th>History</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tfoot>
								<tr>
									<th>Brand</th>
									<th>Nama Produk</th>
									<th>Jumlah</th>
									<th>Hrg. Bengkel</th>
									<th>Hrg. Dist. Area</th>
									<th>Hrg. Dealer</th>
									<th>Hrg. Retail</th>
									<th>Lokasi</th>
									<th>History</th>
									<!-- <th>Booking</th> -->
									<th>Delete</th>
								</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			$this->load->view('navigation/footer');
		?>
		<script type="text/javascript" src="<?php echo asset_url() ?>/js/inventory.js"></script>
	</body>
</html>