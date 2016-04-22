<?php

$tab = "stock";

if (isset ( $_GET ['tab'] )) {
	$tab = $_GET ['tab'];
}
?>
<ul class="nav nav-tabs">
	<li role="presentation"
		class="<?php if($tab=="stock") {echo "active";}?>"><a
		href="inventory?tab=stock&active=inv"><i class="fa fa-archive"></i>
			Stock</a></li>
			<?php if(in_array("SUPER_ADMIN", $permissions)){ ?>
			<li role="presentation" class="<?php if($tab=="prod") {echo "active";}?>"><a
		href="product?tab=prod&active=inv"><i class="glyphicon glyphicon-barcode"></i>
			Product</a></li>
			<?php }?>
</ul>