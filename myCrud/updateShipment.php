<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$vendorError = null;
		$custError = null;
		$shipmentData = null;
		
		// keep track post values
		$vendor = $_POST['vendor_id'];
		$cust = $_POST['cust_id'];
		$shipmentData = $_POST['shipment_data'];
		
		// validate input
		$valid = true;

		if (empty($vendor)) {
			$vendorError = 'Please enter vendor';
			$valid = false;
		}
		
		if (empty($cust)) {
			$custError = 'Please enter cust';
			$valid = false;
		} 
		
		if (empty($shipmentData)) {
			$shipmentDataError = 'Please enter shipmentData';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE crudShipments set vendor_id = ?, cust_id = ?, shipment_data = ? WHERE shipment_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($vendor,$cust,$shipmentData,$id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM crudShipments where shipment_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$vendor = $data['vendor_id'];
		$cust = $data['cust_id'];
		$shipmentData = $data['shipment_data'];
		Database::disconnect();
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
		    			<h3>Update a Shipment</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="updateShipment.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($vendorError)?'error':'';?>">
					    <label class="control-label">vendor</label>
					    <div class="controls">
					      	<input name="vendor_id" type="text"  placeholder="vendor" value="<?php echo !empty($vendor)?$vendor:'';?>">
					      	<?php if (!empty($vendorError)): ?>
					      		<span class="help-inline"><?php echo $vendorError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($custError)?'error':'';?>">
					    <label class="control-label">cust</label>
					    <div class="controls">
					      	<input name="cust_id" type="text"  placeholder="cust" value="<?php echo !empty($cust)?$cust:'';?>">
					      	<?php if (!empty($custError)): ?>
					      		<span class="help-inline"><?php echo $custError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
						  <div class="control-group <?php echo !empty($shipmentDataError)?'error':'';?>">
					    <label class="control-label">shipmentData</label>
					    <div class="controls">
					      	<input name="shipment_data" type="text"  placeholder="shipmentData" value="<?php echo !empty($shipmentData)?$shipmentData:'';?>">
					      	<?php if (!empty($shipmentDataError)): ?>
					      		<span class="help-inline"><?php echo $shipmentDataError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
							

					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>