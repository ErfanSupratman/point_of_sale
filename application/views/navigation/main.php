<?php
defined('BASEPATH') or exit('No direct script access allowed');
$session_data = $this->session->userdata('logged_in');
$permissions = $session_data['permissions'];
$username = $session_data['username'];
if (! isset ( $_GET ['active'] )) {
	$active = 'dash';
} else {
	$active = $_GET ['active'];
}

$inventory = false;
$invoice = false;
$user = false;
$report = false;
$customer = false;

foreach ($permissions as $permission) {
	if($permission->permission==1){
		$inventory = true;
		$invoice = true;
		$user = true;
		$report = true;
		$customer = true;	
		break;
	}
	if($permission->page=='INVOICE' && $permission->allowed && $permission->action=="VIEW"){
		$invoice = true;
	} else if($permission->page=='INVENTORY' && $permission->allowed && $permission->action=="VIEW"){
		$inventory = true;
	} else if($permission->page=='USER' && $permission->allowed && $permission->action=="VIEW"){
		$user = true;
	} else if($permission->page=='CUSTOMER' && $permission->allowed && $permission->action=="VIEW"){
		$customer = true;
	} else if($permission->page=='REPORT' && $permission->allowed && $permission->action=="VIEW"){
		$report = true;
	}
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
				<?php if($invoice){ ?>
				<li <?php if($active=='invoice'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Invoice?active=invoice') ?>"><i class="fa fa-usd"></i> Invoice</a>
				</li>					
				<?php } if($inventory){ ?>	
				<li <?php if($active=='inv'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Inventory?active=inv') ?>"><i class="fa fa-exchange"></i> Inventory Control</a>
				</li>
				<?php } if($user){ ?>
				<li <?php if($active=='role'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('User?active=role') ?>"><i class="fa fa-group"></i> Role Management</a>
				</li>
				<?php } if($customer){ ?>
				<li <?php if($active=='cust'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Customer?active=cust') ?>"><i class="fa fa-user"></i> Customer Management</a>
				</li>
				<?php } if($report){ ?>
				<li <?php if($active=='report'){echo 'class="active"';}?>>
					<a href="<?php echo site_url('Report?active=report') ?>"><i class="fa fa-area-chart"></i> Reports</a>
				</li>
				<?php }?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?php echo site_url('verifyLogin/logout') ?>">
						<span class="glyphicon glyphicon-log-out"> </span>
						Log out (<?php echo $username;?>)
					</a>
				</li>
			</ul>
		</div>
						<!-- /.navbar-collapse -->
	</div>
					<!-- /.container-fluid -->
</nav>