<?php
if (! isset ( $_GET ['active'] )) {
	$active = 'dash';
} else {
	$active = $_GET ['active'];
}
?>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?=site_url('Home')?>"><img src="<?php echo asset_url() ?>/images/logo.png" height="38px"></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse"
			id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li <?php if($active=='dash'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Home') ?>"><i class="fa fa-tachometer"></i> Dashboard</a>
				</li>
				<li <?php if($active=='invoice'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Invoice?active=invoice') ?>"><i class="fa fa-usd"></i> Invoice</a>
				</li>						
				<li <?php if($active=='inv'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Inventory?active=inv') ?>"><i class="fa fa-exchange"></i> Inventory Control</a>
				</li>
				<li <?php if($active=='role'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('User?active=role') ?>"><i class="fa fa-group"></i> Role Management</a>
				</li>
				<li <?php if($active=='cust'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Customer?active=cust') ?>"><i class="fa fa-user"></i> Customer Management</a>
				</li>
				<li <?php if($active=='report'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Report?active=report') ?>"><i class="fa fa-area-chart"></i> Reports</a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?php echo site_url('verifyLogin/logout') ?>">
						<span class="glyphicon glyphicon-log-out"> </span>
						Log out (<?php $session_data = $this->session->userdata('logged_in');echo $session_data['username'];?>)
					</a>
				</li>
			</ul>
		</div>
						<!-- /.navbar-collapse -->
	</div>
					<!-- /.container-fluid -->
</nav>