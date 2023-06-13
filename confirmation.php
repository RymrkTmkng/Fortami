<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Confirmation</title>
</head>
<body>
<?php
	include 'backend.php';
	$backend = new Backend;

	$backend->checksession();

	if (isset($_POST['receipt'])) {
		$buyer =  $_POST['buyer'];
		$buyer_id = $_POST['buyer_id'];
		$trans_id = $_POST['trans_id'];
		$address = $_POST['address'];
		$subtot = $_POST['total_payment'];
		$received = $_POST['order_date'];
		$status = $_POST['status'];
		$option = $_POST['option'];
        $paystats = $_POST['paystats'];
        $contact = $_POST['contact'];
		$shop = $_POST['shop_name'];
		$shop_address = $_POST['shop_address'];
		$shop_contact = $_POST['contact'];
		$result = $backend->foodBought($trans_id);
		$tax = $_POST['vat'];
		$comm = $_POST['comm'];
		$commission = number_format((float)$comm,2,'.',',');
		$vat = number_format((float)$tax,2,'.',',');
		$subtota = $subtot - $tax - $comm;
		$subtotal = number_format((float)$subtota,2,'.',',');
		$total = number_format((float)$subtot,2,'.',',');
	}else{
		$buyer = "";
		$buyer_id = "";
		$trans_id = "";
		$address = "";
		$total = 0;
		$received = "";
		$status = "";
		$option = "";
        $paystats = "";
        $contact = "";
		$shop = "";
		$shop_address = "";
		$shop_contact = "";
		$commission = 0;
		$subtotal = 0;
		$vat = 0;
		$comm = 0;
		$result= [];
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Fortami Receipt</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="./Styles/receipt.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<style>
		body{
			background-image:linear-gradient(#4990b5,skyblue);
		}
	</style>
</head>
<body>
<div class="container">
	<div class="row mb-4">
		<div class="col-md-6">
			<h1 class="">Receipt</h1>
			<p class="font-weight-bold mb-0"><small class="text-secondary">Date:</small> <?=date("M d, Y h:i:s a",strtotime($received))?></p>
			<p class="font-weight-bold mb-0"><small class="text-secondary">Receipt #:</small> 2023<?=$trans_id?> </p>
			<p class="font-weight-bold mb-0"><small class="text-secondary">Delivery Option:</small> <?=$option?> </p>
			<p class="font-weight-bold mb-0"><small class="text-secondary">Order Status:</small> <?=$status?> </p>
			<p class="font-weight-bold"><small class="text-secondary">Payment Status:</small>  <?=$paystats?> </p>
		</div>
		<div class="col-md-6 text-md-right">
			<h2 class=" rounded shadow"> <i class="bi bi-person-square"> Recipient</i></h2>
			<h4 class="mb-0"> <strong><?=$buyer?></strong></h4>
			<p class="mb-0"><h6><?=$address?></h6>
			Contact #: <?=$contact?>
			</p>

		</div>
	</div>
	<hr>
	<div class="col-12 table-responsive">
		<table class="table table-striped">
			<thead>
				<tr >
					<th>Food</th>
					<th>Qty</th>
					<th>Price</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if (!is_null($result)) {
						foreach ($result as $row) {
				?>
				<tr>
					<td><?=$row['food_name']?></td>
					<td><?=$row['quantity']?></td>
					<td>₱ <?=number_format((float)$row['food_discountedPrice'],2,'.',',')?></td>
					<td>₱ <?=number_format((float)$row['quantity']*$row['food_discountedPrice'],2,'.',',')?></td>
				</tr>
				<?php
						}
					}
				?>
				<tr>
					<td colspan="3">Subtotal</td>
					<td>₱ <i><?=$subtotal?></i></td>
				</tr>
				<tr>
					<td colspan="3">Processing Fee</td>
					<td>₱ <i><?=$commission?></i></td>
				</tr>
				<tr>
					<td colspan="3" >VAT(12%)</td>
					<td>₱ <?=$vat?></td>
				</tr>
				<tr class="bg-dark text-light bg-gradient">
					<td colspan="3" >Total Payment</td>
					<td>₱ <?=$total?></td>
				</tr>
			</tbody>
		</table>
	</div>
    <div class="col-12">
		<?php
				if ($status == 'Received') {
					if ($option == 'Delivery') {
						echo "<div class='col-12 bg-success p-3 text-center rounded'>
						    	<h2 class='text-light'>Successfully Delivered</h2>
							  </div>";
					}
					else{
						echo "<div class='col-12 bg-success p-3 text-center rounded'>
						    	<h2 class='text-light'>Successful Pick-up</h2>
							  </div>";
					}
				}
				else {
					echo "<div class='col-12 bg-danger p-3 text-center rounded'>
						    	<h2 class='text-light'>Cancelled</h2>
							  </div>";
				}
		?>
	</div>
	<div class="d-flex justify-content-center align-items-center">
		<button class="btn btn-dark my-2" id="exclude" onclick="printPage()"><i class="bi bi-printer"> Print Receipt</i></button>
	</div>
    <div class="col-12 my-2">
		<h4><a href="sales.php" id="backbtn"><i class="bi bi-arrow-return-left">Back</i></a></h4>
    </div>
	<script>
		function printPage(){
			var ex = document.querySelector('#exclude');
			var backbtn = document.querySelector('#backbtn');

			ex.remove();
			backbtn.remove();
			window.print();
		}
	</script>
</body>
</html>