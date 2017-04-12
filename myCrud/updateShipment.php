<?php 
session_start();
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
		$cust_idError = null;
		$vendor_idError = null;
		$data_Error = null;
		$amount_Error = null;
		
		// keep track post values
		$cust_id = $_POST['cust_id'];
		$vendor_id = $_POST['vendor_id'];
		$data = $_POST['data'];
		$amount = $_POST['amount'];
		
		// validate input
		$valid = true;
		if (empty($cust_id)) {
			$cust_ideError = 'No Customer ID';
			$valid = false;
		}
		
		if (empty($vendor_id)) {
			$vendor_id = 'No Vendor ID';
			$valid = false;
		}
		
		if (empty($data)) {
			$data_Error = 'Please enter item details';
			$valid = false;
		}
		
		if (empty($amount)) {
			$amount_Error = 'Please enter amount';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE crudShipments  set cust_id = ?, vendor_id = ?, data =?, amount = ? WHERE shipment_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($cust_id,$vendor_id,$data,$amount,$id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM crudShipments, crudCustomers, crudVendors WHERE 
							crudShipments.cust_id = crudCustomers.cust_id AND 
							crudShipments.vendor_id = crudVendors.vendor_id AND shipment_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$cust_id = $data['cust_id'];
		$vendor_id = $data['vendor_id'];
		$data = $data['data'];
		$amount = $data['amount'];
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
    		
	    			<form class="form-horizontal" action="updateShipment.php?id=<?php echo $id ?>" method="post">
					  <div class="control-group <?php echo !empty($cust_idError)?'error':'';?>">
					    <label class="control-label">Customer ID</label>
					    <div class="controls">
					      	<input name="cust_id" type="text"  placeholder="ID" value="<?php echo !empty($cust_id)?$cust_id:'';?>" readonly style="background-color: #DCDCDC;">
					      	<?php if (!empty($cust_idError)): ?>
					      		<span class="help-inline"><?php echo $cust_idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($vendor_idError)?'error':'';?>">
					    <label class="control-label">Vendor ID</label>
					    <div class="controls">
					      	<input name="vendor_id" type="text"  placeholder="ID" value="<?php echo !empty($vendor_id)?$vendor_id:'';?>" readonly style="background-color: #DCDCDC;">
					      	<?php if (!empty($vendor_idError)): ?>
					      		<span class="help-inline"><?php echo $vendor_idError;?></span>
					      	<?php endif; ?>
					    </div>
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
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>