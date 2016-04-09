<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Inventory</title>
		<link rel="stylesheet" href="<?php echo asset_url() ?>/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo asset_url() ?>/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo asset_url() ?>/css/normalize.css">
		<link rel="stylesheet" href="<?php echo asset_url() ?>/css/style.css">
		<link rel="stylesheet" href="<?php echo asset_url() ?>/css/sweetalert.css">
		<link rel="stylesheet"
			href="<?php echo asset_url() ?>/css/bootstrap-select.min.css">
			<link href="<?php echo asset_url() ?>/css/responsive.bootstrap.min.css"
			rel="stylesheet">
			<link href="<?php echo asset_url() ?>/css/dataTables.bootstrap.min.css"
			rel="stylesheet">
			<link href="<?php echo asset_url() ?>/css/buttons.bootstrap.min.css"
			rel="stylesheet">
			<link rel="stylesheet"
				href="<?php echo asset_url() ?>/css/bootstrap-flaty.min.css">
			</head>
			<body style="background-color: #F2F2F2">
				<?php
				$this->load->view('navigation/main');
				?>
				<div class="container-fluid" >
					<div id="body">
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
												<th>Kode Stock</th>
												<th>Kode Produk</th>
												<th>Nama Produk</th>
												<th>Brand</th>
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
											<th>Kode Stock</th>
											<th>Kode Produk</th>
											<th>Nama Produk</th>
											<th>Brand</th>
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
				<!--
						<p>Page rendered in <strong>{elapsed_time}</strong> seconds.
					<?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
					<br/>
				<?php echo (ENVIRONMENT === 'development') ? 'POS Application Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
				-->
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/jquery.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/bootstrap.js"></script>
				<script type="text/javascript"
				src="<?php echo asset_url() ?>/js/bootstrap3-typeahead.js"></script>
				<script type="text/javascript"
				src="<?php echo asset_url() ?>/js/jquery.dataTables.min.js"></script>
				<script type="text/javascript"
				src="<?php echo asset_url() ?>/js/dataTables.bootstrap.min.js"></script>
				<script type="text/javascript"
				src="<?php echo asset_url() ?>/js/dataTables.buttons.min.js"></script>
				<script type="text/javascript"
				src="<?php echo asset_url() ?>/js/buttons.bootstrap.min.js"></script>
				<script type="text/javascript"
				src="<?php echo asset_url() ?>/js/bootstrap-select.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/inventory.js"></script>
				<script type="text/javascript"
				src="<?php echo asset_url() ?>/js/sweetalert.min.js"></script>
			</body>
		</html>