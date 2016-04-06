<?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Invoice</title>
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
		<div class="container-fluid">
			<div id="body">
				<div class="row">
					<?php
						// invoice top menu
						$this->load->view ( 'navigation/invoice_top' );
						// input invoice
						$this->load->view ( 'modal/input_invoice.php' );
					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br/>
					<div class="col-sm-2">
						<ul class="nav nav-pills nav-stacked">
							<li id="pendingMenu"><a href="#" id="pending"><span class="label label-warning">Pending</span> <span id="pendingBadge" class="badge"></span></a></li>
						</ul>
						<ul class="nav nav-pills nav-stacked">
							<li id="finishedMenu"><a href="#" id="finished"><span class="label label-success">Finished</span> <span id="finishedBadge" class="badge"></span></a></li>
						</ul>
					</div>
					<div class="col-sm-10">
						<!-- Button modal fullscreen -->

						<button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-new-invoice-fullscreen">
							<span class="glyphicon glyphicon-file"></span>  Buat Invoice Baru
						</button>
								
						<br/>
						<hr/>
						<div class="table-responsive">
							<table id="invoice_table" class="table table-striped table-hover" style="font-size:1em" cellspacing="0">
								<thead>
									<tr>
										<th>Tgl. Invoice</th>
										<th>No. Invoice</th>
										<th>Customer</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Tgl. Invoice</th>
										<th>No. Invoice</th>
										<th>Customer</th>
										<th>Status</th>
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
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/jquery.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/bootstrap.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/bootstrap3-typeahead.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/jquery.dataTables.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/dataTables.bootstrap.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/dataTables.buttons.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/buttons.bootstrap.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/bootstrap-select.min.js"></script>
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/invoice.js"></script><!--  -->
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/sweetalert.min.js"></script>
	</body>
</html>