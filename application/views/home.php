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
			<div id="body" class="padding-top-80px">
				<div class="row">
					<?php

					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br/>
					<div class="col-sm-12">
						
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
		<script type="text/javascript" src="<?php echo asset_url() ?>/js/home.js"></script>
		
	</body>
</html>