<?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>
<!DOCTYPE html>
<html lang="en">
	<?php
		$this->load->view ( 'navigation/head' );
	?>
	<body style="background-color: #F2F2F2">
		<?php
			$this->load->view ( 'navigation/main' );
		?>
		<div class="container-fluid">
			<div id="body" class="padding-top-80px">
				<div class="row">
					<?php
						// invoice top menu
						$this->load->view ( 'navigation/invoice_top' );
						// input invoice
						$this->load->view ( 'modal/input_invoice.php' );

						$this->load->view ( 'modal/input_finalize.php' );
					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br/>
					<div class="col-sm-2">
						<ul class="nav nav-pills nav-stacked">
							<li id="bookingMenu"><a href="#" id="booking"><span class="label label-info">Booking</span> <span id="bookingBadge" class="badge"></span></a></li>
						</ul>
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
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Tgl. Invoice</th>
										<th>No. Invoice</th>
										<th>Customer</th>
										<th>Status</th>
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
		
				<script type="text/javascript" src="<?php echo asset_url() ?>/js/invoice.js"></script><!--  -->
				

	</body>
</html>