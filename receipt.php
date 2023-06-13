<?php
	include 'backend.php';
	$backend = new Backend;

	$backend->checksession();

	if (isset($_POST['receiptbtn'])) {
		$shopname =  $_POST['shop'];
		$trans = $_POST['trans_id'];
		$shopID = $_POST['shop_id'];
		$datetime = $_POST['date'];
		$date = date("M d, Y h:i a",strtotime($datetime));
		$option = $_POST['delivery'];
		$status = $_POST['status'];
		$subtot = $_POST['total'];
		$paystats = $_POST['paystats'];
		$method = $_POST['method'];
		$comm = $_POST['comm'];
		$commission = number_format((float)$comm,2,'.',',');
		$tax = $_POST['vat'];
		$vat = number_format((float)$tax,2,'.',',');
		$subtota = $subtot - $comm - $tax;
		$subtotal = number_format((float)$subtota,2,'.',',');
		$total = number_format((float)$subtot,2,'.',',');
		

		$shopAddress = $backend->sellerAddress($shopID);
		$address = mysqli_fetch_assoc($shopAddress);

		$result = $backend->foodBought($trans);
	}else{
		$shopname =  "";
		$trans = "";
		$shopID = "";
		$datetime = "";
		$date = "";
		$option = "";
		$status ="";
		$total = "";
		$paystats = "";
		$method = "";
		$commission = 0;
		$subtotal = 0;
		$subtot = 0;
		$vat = 0;
		$comm = 0;
		$subtota = 0;
		$shopAddress = "";
		$address=[];
		$address['street'] = "";
		$address['zip'] = "";
		$address['contact'] = "";
		$address['city'] = "";
		$address['barangay'] = "";
		

		$result=[];
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
</head>
<body>
	<div class="container" id="receipt">
		<div class="row mb-4">
			<div class="col-md-6">
				<h1>Receipt</h1>
				<p class="font-weight-bold mb-0"><small class="text-secondary">Date:</small>  <?=$date?> </p>
				<p class="font-weight-bold mb-0"><small class="text-secondary">Receipt #:</small> 2023<?=$trans?> </p>
				<p class="font-weight-bold mb-0"><small class="text-secondary">Delivery Option:</small> <?=$option?> </p>
				<p class="font-weight-bold mb-0"><small class="text-secondary">Order Status:</small> <?=$status?> </p>
				<p class="font-weight-bold"><small class="text-secondary">Payment Status:</small> <?=$paystats?> </p>
			</div>
			<div class="col-md-6 text-md-right">
				<h2 class="mb-0"><i class="bi bi-shop"></i> <?=$shopname?></h2>
				<p class="mb-0"><?=$address['street']?></p>
				<p class="mb-0"><?=$address['barangay'].', '.$address['city'].' City, '.$address['zip'];?></p>
				<p class="mb-0">Contact #: <?=$address['contact']?></p>
			</div>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
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
					<td><?=number_format((float)$row['food_discountedPrice'],2,'.',',')?></td>
					<td>₱ <?=number_format((float)$row['quantity']*$row['food_discountedPrice'],2,'.',',')?></td>
				</tr>
				<?php
						}
					}
				?>
				<tr>
					<td colspan="3">Subtotal</td>
					<td>₱ <?=$subtotal?></td>
				</tr>
				<tr>
					<td colspan="3">Processing Fee</td>
					<td>₱ <i><?=$commission?></i></td>
				</tr>
				<tr>
					<td colspan="3" >VAT(12%)</td>
					<td>₱ <?=$vat?></td>
				</tr >
					<td colspan="3">Total Payment</td>
					<td>₱ <?=$total?></td>
				</tr>
				<tr>
				<td colspan="3">Payment Method</td>
				<td><?=$method?></td>
				</tr>
			</tbody>
		</table>
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
			?><br>
			<div class="d-flex align-items-center justify-content-center">
				<button class="btn btn-info shadow" onclick="downloadWindow()"><i class="bi bi-box-arrow-down"> Download Receipt</i></button>
				<!-- <button class="btn btn-secondary" id="dlpage" onclick="downloadPage()"><i class="bi bi-box-arrow-down"> Download Receipt</i></button> -->
			</div>
			<br>
			<?=($_SESSION['role'] == 'Buyer') ? "<h4><a href='checkout.php?trans_id=$trans' class='text-center' id='again'><i class='bi bi-repeat'> Order Again</i> </a></h4>":"";?>
		<h4><a href="<?=($_SESSION['role'] == 'Buyer')? 'transactions.php' : 'admin-transaction.php' ?>" id="backbtn"><i class="bi bi-arrow-return-left">Back</i></a></h4>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
	<script>
		function downloadWindow() {
  // Hide the content of the webpage
  document.body.style.display = "none";

  // Use html2canvas to capture a screenshot of the webpage
  html2canvas(document.querySelector('#receipt')).then(function(canvas) {
    // Convert the canvas image to a data URL with PNG format
	
    var dataURL = canvas.toDataURL("image/png");
	console.log(dataURL);

    // Create a link element and set its attributes
    var link = document.createElement("a");
    link.href = dataURL;
    link.download = "window.png";

    // Simulate a click on the link element to download the file
    link.click();

    // Show the content of the webpage again
    document.body.style.display = "block";
  });
}
	</script>
</body>
</html>

			
