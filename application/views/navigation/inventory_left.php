<?php
if (! isset ( $_GET ['active'] )) {
	$active = 'dash';
} else {
	$active = $_GET ['active'];
}
?>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
				aria-expanded="false">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">LOGO</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse"
			id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li <?php if($active=='dash'){echo 'class="active"';}?>><a
					href="home">Dashboard</a></li>
				<li><a href="#">Point Of Sales</a></li>
				<li <?php if($active=='inv'){echo 'class="active"';}?>><a
					href="inventory?active=inv">Inventory Control</a></li>
				<li><a href="#">Employee Management</a></li>
				<li><a href="#">Customer Management</a></li>
				<li><a href="#">Reports</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-cog"></span>
						Setting</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-log-out"></span>
						Log out</a></li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>