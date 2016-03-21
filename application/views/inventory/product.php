<?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>
<!DOCTYPE html>
<html lang="en">
	<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Product</title>
			<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap-datepicker3.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/normalize.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/style.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/sweetalert.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap-select.min.css">
		
		<link href="<?=asset_url()?>/css/responsive.bootstrap.min.css" rel="stylesheet">
		<link href="<?=asset_url()?>/css/dataTables.bootstrap.min.css" rel="stylesheet">
		<link href="<?=asset_url()?>/css/buttons.bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap-flaty.min.css">
	</head>
	<body style="background-color: #F2F2F2">
		<?php
			$this->load->view ( 'navigation/main' );
		?>
		<div class="container-fluid" style="padding:10px">
			<div id="body" style="padding:10px">
				<div class="row">
					<?php
						// inventory top menu
						$this->load->view ( 'navigation/inventory_top' );
						
						// inventory new product modal
						$this->load->view ( 'modal/input_product.php' );
						
						
						
					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br/>
					<div class="col-sm-2">
						<ul class="nav nav-pills nav-stacked">
							<li class="active"><a href="product?tab=prod&active=inv">List Product</a></li>
							<li class=""><a href="brand?tab=prod&active=inv">List Brand</a></li>
						</ul>
					</div>
					<div class="col-sm-10">
						<!-- Button modal fullscreen -->
						<button type="button" class="btn btn-success btn-md" onclick="insertProduct()">
							<span class="glyphicon glyphicon-plus"></span>  Tambah Barang Baru
						</button>
						
						<br/>
						<hr/>
						<?=$inventory_content?>
						<div class="table-responsive">
						<table id="product_table" class="table table-striped table-hover" style="font-size:1em" cellspacing="0" width="98%">
							<thead>
								<tr>
									<th>Kode Produk</th>
									<th>Nama Produk</th>
									<th>Brand</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Kode Produk</th>
									<th>Nama Produk</th>
									<th>Brand</th>
									<th>Action</th>
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
			<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
			<br/> 
			<?php echo  (ENVIRONMENT === 'development') ?  'POS Application Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
		-->
		<script type="text/javascript" src="<?=asset_url()?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/bootstrap.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/bootstrap3-typeahead.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/buttons.bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/product.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/sweetalert.min.js"></script>

	</body>
</html>