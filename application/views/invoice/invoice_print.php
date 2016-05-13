<!DOCTYPE html>
<html>
<head>
	<title>Invoice <?=$invoice_content->header->invoice_code?></title>
	<style type="text/css">
.boxer {
   display: table;
   width:800px;
   border-collapse: collapse;
}
 
.boxer .box-row {
   display: table-row;
}
 
.boxer .box {
   display: table-cell;
   text-align: left;
   vertical-align: top;
   border: 1px solid black;
}

	</style>
</head>
<body onload="javascript:window.print()">

<style type="text/css">
.table-header {border-collapse:collapse;border-spacing:0;margin:0px auto;width: 800px}
.table-header td{font-family:Arial, sans-serif;font-size:14px;border:none}
.tg  {border-collapse:collapse;border-spacing:0;margin:0px auto;width: 800px}
.tg-no-border {border-collapse:collapse;border-spacing:0;margin:0px auto;width: 800px}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg-no-border td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-lqy6{text-align:right;vertical-align:top;font-weight: bold}
.tg .tg-yw4l{vertical-align:top;}
.tg .tg-yw4l-center{vertical-align:top;text-align: center}
.tg .tg-yw4l-right{vertical-align:top;text-align: right}
.tg .tg-yw4l-right-bold{vertical-align:top;text-align: right;font-weight: bold}
.tg .tg-head{vertical-align:top;font-weight: bold}
</style>
<table class="table-header">
  <tr>
    <td width="100px"><img src="<?php echo asset_url() ?>/images/logo_invoice.png"></img></td>
    <td width="350px" valign="top">&nbsp;&nbsp;<span style="font-size:20px"><b>DETAILER GALLERY</b></span><br/>
</td>
    <td >
    	<table style="border-spacing:0;border-collapse:collapse">
    		<tr>
    			<td>Date
    			</td>
    			<td>
    				:
    			</td>
    			<td><?=$invoice_content->header->created_date?>
    			</td>
    		</tr>
    		<tr>
    			<td>Invoice No.
    			</td>
    			<td>
    				:
    			</td>
    			<td><?=$invoice_content->header->invoice_code?>
    			</td>
    		</tr>
    		<tr>
    			<td>Term Of Payment
    			</td>
    			<td>
    				:
    			</td>
    			<td><?=$invoice_content->header->term_of_payment?>
    			</td>
    		</tr>
			<tr>
    			<td>Bill To
    			</td>
    			<td>
    				:
    			</td>
    			<td><?=$invoice_content->header->billing_name?>
    			</td>
    		</tr>
    	</table>
	</td>
  </tr>
</table>
<table class="tg">
  <tr>
    <th class="tg-head">No<br></th>
    <th class="tg-head">Description</th>
    <th class="tg-head">Qty</th>
    <th class="tg-head">Unit Price (Rp)<br></th>
    <th class="tg-head">Amount (Rp)</th>
  </tr>
  <?php 
  $number = 1;
  $sum = 0;
  $freight = $invoice_content->header->freight;
  $discount = $invoice_content->header->discount;
  foreach ($invoice_content->detail as $obj) {
  	
  ?>
  <tr>
    <td class="tg-yw4l-center"><?=$number?></td>
    <td class="tg-yw4l"><?=$obj->product_name?></td>
    <td class="tg-yw4l"><?=$obj->quantity?></td>
    <td class="tg-yw4l"><?=number_format($obj->price)?></td>
    <td class="tg-yw4l-right"><?=number_format(intval($obj->price)*intval($obj->quantity))?></td>
  </tr>
  <?php
  $sum += (intval($obj->price)*intval($obj->quantity));
  $number++;
	}
  ?>
  <tr>
    <td class="tg-lqy6" colspan="4">Discount</td>
    <td class="tg-yw4l-right"><?=number_format($discount)?></td>
  </tr>
  <tr>
    <td class="tg-lqy6" colspan="4">Freight</td>
    <td class="tg-yw4l-right"><?=number_format($freight)?></td>
  </tr>
  <tr>
    <td class="tg-lqy6" colspan="4">Total</td>
    <td class="tg-yw4l-right-bold"><?=number_format(($sum+$freight)-$discount)?></td>
  </tr>
</table>
<br/>
<table class="table-header">
  <tr>
    <td width="600px">Pembayaran dapat ditransfer :<br/>
    	Bank Central Asia<br/>
    	No. Rek. : 4081143247<br/>
    	a.n : Ong Meyliana Sari
</td>
    <td >
    	<table style="border-spacing:0;border-collapse:collapse">
    		<tr>
    			<td style="text-align:center">Hormat Kami<br/><br/><br/>
    			</td>
    		</tr>
    		<tr>
    			<td>
    			</td>
    		</tr>
    		<tr>
    			<td>(_________________)
    			</td>
    		</tr>
    	</table>
	</td>
  </tr>
</table>
</body>
</html>
