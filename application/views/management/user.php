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
						$this->load->view ( 'navigation/role_top' );
						
						// inventory new product modal
						$this->load->view ( 'modal/input_user.php' );
						
						
						
					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br/>
	<!--				<div class="col-sm-2">
						<ul class="nav nav-pills nav-stacked">
							<li class="active"><a href="User?active=role">List User</a></li>
							
						</ul>
					</div>-->
					<div class="col-sm-12">
						<!-- Button modal fullscreen -->
						<button type="button" class="btn btn-success btn-md" onClick="insertUser()">
							<span class="glyphicon glyphicon-plus"></span>  Tambah User Baru
						</button>
						
						<br/>
						<hr/>
						
						<div class="table-responsive">
						<table id="user_table" class="table table-striped table-hover" style="font-size:1em" cellspacing="0" width="98%">
							<thead>
								<tr>
									<th>Username</th>
									<th>Nama</th>
									<th>Permission</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Username</th>
									<th>Nama</th>
									<th>Permission</th>
									<th>Action</th>
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
		<!--
			<p>Page rendered in <strong>{elapsed_time}</strong> seconds. 
			<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
			<br/> 
			<?php echo  (ENVIRONMENT === 'development') ?  'POS Application Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
		-->
				<script type="text/javascript" src="<?=asset_url()?>/js/user.js"></script>
	</body>
</html>