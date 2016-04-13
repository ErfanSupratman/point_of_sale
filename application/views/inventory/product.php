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
						$this->load->view ( 'navigation/inventory_top' );
						
						// inventory new product modal
						$this->load->view ( 'modal/input_product.php' );
						
						
						
					?>
				</div>
				<div class="row" style="background-color: #ffffff">
					<br/>
					<div class="col-sm-2">
						<ul class="nav nav-pills nav-stacked">
							<li class="active"><a href="product?tab=prod&active=inv">List Product</a></li>
							<li class=""><a href="brand?tab=prod&active=inv">List Brand</a></li>
						</ul>
					</div>
					<div class="col-sm-10">
						<!-- Button modal fullscreen -->
						<button type="button" class="btn btn-success btn-md hidden-xs hidden-sm" onclick="insertProduct()">
							<span class="glyphicon glyphicon-plus"></span> Tambah Barang Baru
						</button>

						<button type="button" class="btn btn-success btn-md hidden-lg hidden-md btn-block" onclick="insertProduct()">
							<span class="glyphicon glyphicon-plus"></span> Tambah Barang Baru
						</button>
						
						<br/>
						<hr/>
						<?=$inventory_content?>
						<div class="table-responsive">
						<table id="product_table" class="table table-striped table-hover" style="font-size:1em" cellspacing="0" width="98%">
							<thead>
								<tr>
									<th>Kode Produk</th>
									<th>Nama Produk</th>
									<th>Brand</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Kode Produk</th>
									<th>Nama Produk</th>
									<th>Brand</th>
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
		
		<script type="text/javascript" src="<?=asset_url()?>/js/product.js"></script>

	</body>
</html>