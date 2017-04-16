<?php 
session_start();
if(!isset($_SESSION["userid"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$cust_idError = null;
		$vendor_idError = null;
		$dataError = null;
		$amountError = null;
		$admin = $_SESSION['isadmin'];
		// keep track post values
		$cust_id = $_POST['userid'];
		$vendor_id = $_POST['vendor_id'];
		$data = $_POST['data'];
		$amount = $_POST['amount'];
		
		// validate input
		$valid = true;
		if (empty($cust_id)) {
			$cust_idError = 'Please select a Cutomer';
			$valid = false;
		}
		
		if (empty($vendor_id)) {
			$vendor_idError = 'Please select a Vendor';
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
			$sql = "INSERT INTO crudShipments (crudShipments.vendor_id, crudShipments.cust_id, shipment_data, shipment_amount) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($vendor_id,$cust_id,$data,$amount));
			Database::disconnect();
			header("Location: home.php");
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
    		
	    			<form class="form-horizontal" action="createShipmentuser.php" method="post">
					  <div class="control-group <?php echo !empty($cust_idError)?'error':'';?>">
					    <label class="control-label">Customer</label>
					    <div class="controls">
					      	<?php
							$pdo = Database::connect();
								$sql = 'SELECT * FROM crudCustomers WHERE userid = "'.$_SESSION['userid'].'" ORDER BY userid DESC';
								echo "<select class='form-control' name='userid' id='id'>";
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['userid'] . " '>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
								}
								echo "</select>";
								Database::disconnect();
							?>
					      	<?php if (!empty($cust_idError)): ?>
					      		<span class="help-inline"><?php echo $cust_idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($vendor_idError)?'error':'';?>">
					    <label class="control-label">Vendor</label>
					    <div class="controls">
					      	<?php
								$pdo = Database::connect();
								$sql = 'SELECT * FROM crudVendors ORDER BY vendor_id DESC';
								
								echo "<select class='form-control' name='vendor_id' id='id'>";
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['vendor_id'] . " '> " . $row['vendor_name'] . "</option>";
								}
								echo "</select>";
								
								Database::disconnect();
							?>
					      	<?php if (!empty($vendor_idError)): ?>
					      		<span class="help-inline"><?php echo $vendor_idError;?></span>
					      	<?php endif; ?>
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
						  <a class="btn" href="home.php">Back</a>
						</div>
					</form>
				</div>
    </div> <!-- /container -->
  </body>
</html>