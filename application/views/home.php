<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to CodeIgniter</title>
<link rel="stylesheet" href="<?=asset_url()?>/css/bootstrap.min.css">
<link rel="stylesheet"
	href="<?=asset_url()?>/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?=asset_url()?>/css/font-awesome.min.css">
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

.huge {
	font-weight: bold;
	font-size: 20px;
}

.navbar-inverse {
	border-radius: 0px !important;
}
</style>

<script type="text/javascript"
	src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2013',  1000,      400],
          ['2014',  1170,      460],
          ['2015',  660,       1120],
          ['2016',  1030,      540]
        ]);

        var options = {
		  backgroundColor : '#F2F2F2',
          title: 'Company Performance (Rp)',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
		 animation:{
			startup: true,
			duration: 1000,
			easing: 'out',
      }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
		
      }
	  
    </script>
</head>
<body style="background-color: #F2F2F2">
<?php
$this->load->view ( 'navigation/main' );
?>

	<div class="container-fluid">
		<div id="body">
			<div class="row">

				<div class="col-sm-3">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-money fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">Rp. 1500000</div>
									<div>Today Sales</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="panel-footer">
								<span class="pull-left">View Details</span> <span
									class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-money fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">Rp. 50000000</div>
									<div>This Month Sales</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="panel-footer">
								<span class="pull-left">View Details</span> <span
									class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-money fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">Rp. 1000000000</div>
									<div>This Year Sales</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="panel-footer">
								<span class="pull-left">View Details</span> <span
									class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-sm-8">
					<div id="chart_div" style="width: 100%; height: 300px;"></div>
				</div>
			</div>
		</div>


	</div>
	<!--
	<p>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?><br/> <?php echo  (ENVIRONMENT === 'development') ?  'POS Application Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
	-->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?=asset_url()?>/js/bootstrap.min.js"></script>
</body>
</html>