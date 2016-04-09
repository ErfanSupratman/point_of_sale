<?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>
<!DOCTYPE html>
<html lang="en">
	<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Inventory</title>
		<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap-datepicker3.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/normalize.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/style.css">
		<link rel="stylesheet" href="<?=asset_url()?>/css/sweetalert.css">
		
		<link href="<?=asset_url()?>/css/responsive.bootstrap.min.css" rel="stylesheet">
		<link href="<?=asset_url()?>/css/dataTables.bootstrap.min.css" rel="stylesheet">
		<link href="<?=asset_url()?>/css/buttons.bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap-flaty.min.css">
	</head>
	<body style="background-color: #F2F2F2">
		<?php
			$this->load->view ( 'navigation/main' );
		?>
		<div class="container-fluid">
			<div id="body" class="padding-top-80px">
				<div class="row">
					<?php
						// inventory top menu
						$this->load->view ( 'navigation/customer_top' );
						
						// inventory new product modal
						$this->load->view ( 'modal/input_customer.php' );
						
					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br/>
				
					<div class="col-sm-12">
						<!-- Button modal fullscreen -->
						<button type="button" class="btn btn-success btn-md" onclick="insertCustomer()">
							<span class="glyphicon glyphicon-plus"></span>  Tambah Customer Baru
						</button>
						
						<br/>
						<hr/>
						<?=$inventory_content?>
						<div class="table-responsive">
						<table id="customer_table" class="table table-striped table-hover" style="font-size:1em" cellspacing="0" width="98%">
							<thead>
								<tr>
									<th>Customer Code</th>
									<th>Customer Name</th>
									<th>No. Tlp</th>
									<th>Address</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Customer Code</th>
									<th>Customer Name</th>
									<th>No. Tlp</th>
									<th>Address</th>
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
		<script type="text/javascript" src="<?=asset_url()?>/js/customer.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>/js/sweetalert.min.js"></script>
	</body>
</html>