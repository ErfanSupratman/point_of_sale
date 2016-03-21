<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap-flaty.min.css">
	<style>
		
	
	.footer {
			text-align: right;
		font-size: 11px;
		border-top: 5px solid #D0D0D0;
		line-height: 15px;
		padding: 0 10px 0 10px;
    width: 100%;
    height: 50px;
    position: absolute;
    bottom: 0;
    left: 0;
	background-color: #ffffff;
}
	</style>
</head>
<body  style="background-image: url('<?=asset_url()?>/images/maxresdefault.jpg')">

	<div class="container-fluid">
		<div id="body">
			<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
				<h1 style="text-align:center;color:white"><span class="glyphicon glyphicon-shopping-cart"></span> <strong>LOGO<strong></h1>
					<div class="panel panel-default">
						<div class="panel-heading">Login</div>
						<div class="panel-body">
							<div class="form-group">
							  <label for="usr">Name:</label>
							  <input type="text" class="form-control" id="usr">
							</div>
							<div class="form-group">
							  <label for="pwd">Password:</label>
							  <input type="password" class="form-control" id="pwd">
							</div>
							
							<a class="btn btn-primary" style="float:right" href="<?php echo site_url('Inventory') ?>"><span class="glyphicon glyphicon-log-in"></span> Log In</a>
						</div>
					</div>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>

		
	</div>
	<div class="footer">
	<p>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?><br/> <?php echo  (ENVIRONMENT === 'development') ?  'POS Application Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?=asset_url()?>/js/bootstrap.min.js"></script>
</body>
</html>