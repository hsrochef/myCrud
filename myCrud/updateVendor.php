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
		$nameError = null;
		$phoneError = null;
		$addressError = null;
		
		// keep track post values
		$name = $_POST['vendor_name'];
		$phone = $_POST['vendor_phone'];
		$address = $_POST['vendor_address'];
		
		// validate input
		$valid = true;

		if (empty($name)) {
			$nameError = 'Please enter name';
			$valid = false;
		}
		
		if (empty($phone)) {
			$phoneError = 'Please enter phone';
			$valid = false;
		} 
		
		if (empty($address)) {
			$addressError = 'Please enter address';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE crudVendors set vendor_name = ?, vendor_phone = ?, vendor_address = ? WHERE vendor_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$phone,$address,$id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM crudVendors where vendor_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['vendor_name'];
		$phone = $data['vendor_phone'];
		$address = $data['vendor_address'];
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
		    			<h3>Update a Vendor</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="updateVendor.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">name</label>
					    <div class="controls">
					      	<input name="vendor_name" type="text"  placeholder="name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($phoneError)?'error':'';?>">
					    <label class="control-label">phone</label>
					    <div class="controls">
					      	<input name="vendor_phone" type="text"  placeholder="phone" value="<?php echo !empty($phone)?$phone:'';?>">
					      	<?php if (!empty($phoneError)): ?>
					      		<span class="help-inline"><?php echo $phoneError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
						  <div class="control-group <?php echo !empty($addressError)?'error':'';?>">
					    <label class="control-label">address</label>
					    <div class="controls">
					      	<input name="vendor_address" type="text"  placeholder="address" value="<?php echo !empty($address)?$address:'';?>">
					      	<?php if (!empty($addressError)): ?>
					      		<span class="help-inline"><?php echo $addressError;?></span>
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