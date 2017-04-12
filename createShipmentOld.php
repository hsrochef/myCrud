<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$vendorError = null;
		$custError = null;
		$dataError = null;
		$amountError = null;

		
		// keep track post values
		$vendor = $_POST['vendor'];
		$cust = $_POST['cust'];
		$data = $_POST['data'];
		$amount = $_POST['amount'];
		// validate input
		$valid = true;
		if (empty($vendor)) {
			$nameError = 'Please enter vendor ID';
			$valid = false;
		}
		
		if (empty($cust)) {
			$custError = 'Please enter customer ID';
			$valid = false;
		}
		
		if (empty($data)) {
			$dataError = 'Please enter valid data';
			$valid = false;
		}
		if (empty($amount)) {
			$amountError = 'Please enter valid amount';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO crudShipments (vendor_id, cust_id, shipment_data, shipment_amount) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($vendor,$cust,$data,$amount));
			Database::disconnect();
			header("Location: index.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a Shipment</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="createShipment.php" method="post">
					  <div class="control-group <?php echo !empty($vendorError)?'error':'';?>">
					    <label class="control-label">Vendor ID</label>
					    <div class="controls">
					      	<input name="vendor" type="text"  placeholder="vendor" value="<?php echo !empty($vendor)?$vendor:'';?>">
					      	<?php if (!empty($vendorError)): ?>
					      		<span class="help-inline"><?php echo $vendorError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($custError)?'error':'';?>">
					    <label class="control-label">Customer ID</label>
					    <div class="controls">
					      	<input name="cust" type="text" placeholder="cust" value="<?php echo !empty($cust)?$cust:'';?>">
					      	<?php if (!empty($custError)): ?>
					      		<span class="help-inline"><?php echo $custError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($dataError)?'error':'';?>">
					    <label class="control-label">Shipment Data</label>
					    <div class="controls">
					      	<input name="data" type="text"  placeholder="data" value="<?php echo !empty($data)?$data:'';?>">
					      	<?php if (!empty($dataError)): ?>
					      		<span class="help-inline"><?php echo $dataError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					   <div class="control-group <?php echo !empty($amountError)?'error':'';?>">
					    <label class="control-label">Shipment Amount</label>
					    <div class="controls">
					      	<input name="amount" type="text"  placeholder="amount" value="<?php echo !empty($amount)?$amount:'';?>">
					      	<?php if (!empty($amountError)): ?>
					      		<span class="help-inline"><?php echo $amountError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>