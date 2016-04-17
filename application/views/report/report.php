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
						// inventory top menu
						$this->load->view ( 'navigation/report_top' );
						
					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br/>
					<div class="col-sm-2">
						<ul class="nav nav-pills nav-stacked">
							<li class="active"><a href="report?tab=income">Income</a></li>
							<!-- <li class=""><a href="report?tab=pending">Pending</a></li> -->
						</ul>
					</div>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-3">
								<div class="input-group date input-sm" data-provide="datepicker" 
								data-date-format="yyyy/mm/dd" >
								    <input type="text" placeholder="Masukkan tanggal awal" 
								    id="start_date" class="form-control">
								    <div class="input-group-addon">
								        <span class="glyphicon glyphicon-th"></span>
								    </div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="input-group date input-sm" data-provide="datepicker" 
								data-date-format="yyyy/mm/dd" >
								    <input type="text" placeholder="Masukkan tanggal akhir" 
								    id="end_date" class="form-control">
								    <div class="input-group-addon">
								        <span class="glyphicon glyphicon-th"></span>
								    </div>
								</div>
							</div>
							<div class="col-sm-2">
								<button class="btn btn-success btn-block" id="filter_report_btn"><i class="fa fa-search"></i> Cari</button>
							</div>
						
						</div>
					
						<hr/>
						<div class="row">
							<div class="col-md-1">
									<button class="btn btn-default btn-block btn-sm pull-right" id="print_report_btn"><i class="fa fa-print"></i> Print</button>
							</div>
						</div>
						<br/>
						<div class="table-responsive">
						<table id="report_table" class="table table-striped table-hover" style="font-size:1em" cellspacing="0" width="98%">
							<thead>
								<tr>
									<th>Created Date</th>
									<th>Paid Date</th>
									<th>Last Updated By</th>
									<th>Invoice No.</th>
									<th>Booking No.</th>
									<th>Customer</th>
									<th>Freight</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Created Date</th>
									<th>Paid Date</th>
									<th>Last Updated By</th>
									<th>Invoice No.</th>
									<th>Booking No.</th>
									<th>Customer</th>
									<th>Freight</th>
									<th>Amount</th>
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
		
		<script type="text/javascript" src="<?=asset_url()?>/js/report.js"></script>

	</body>
</html>
