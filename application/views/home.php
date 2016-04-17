<?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$this->load->view('navigation/head');
		?>
		
	</head>
	<body style="background-color: #F2F2F2">
		<?php
			$this->load->view ( 'navigation/main' );
		?>
		<div class="container-fluid">
			<div id="body" class="padding-top-80px">
				
				<div class="row" style="background-color: #ffffff">
					<br/>
					<div class="col-sm-4">
					    <button class="btn btn-warning btn-block"><h2>Booking<br/><span id="bookingBadge"></span></h2></button>
					</div>
					<div class="col-sm-4">
					    <button class="btn btn-danger btn-block"><h2>Pending<br/><span id="pendingBadge"></span></h2></button>
					</div>
					<div class="col-sm-4">
					    <button class="btn btn-success btn-block"><h2>Finished<br/><span id="finishedBadge"></span></h2></button>
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
		<?php
			$this->load->view('navigation/footer');
		?>
		
		<script type="text/javascript" src="<?php echo asset_url() ?>/js/home.js"></script>
		
	</body>
</html>