<?php 
 

$personid = $_SESSION["fr_person_id"];
$eventid = $_GET['event_id'];

require 'database.php';

if ( !empty($_POST)) {

	// initialize user input validation variables
	$personError = null;
	$eventError = null;
	
	// initialize $_POST variables
	$person = $_POST['person'];    // same as HTML name= attribute in put box
	$event = $_POST['event'];
	
	// validate user input
	$valid = true;
	if (empty($person)) {
		$personError = 'Please choose a volunteer';
		$valid = false;
	}
	if (empty($event)) {
		$eventError = 'Please choose an event';
		$valid = false;
	} 
		
	// insert data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO crudShipments 
			(cust_id,vendor_id) 
			values(?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($person,$event));
		Database::disconnect();
		header("Location: createShipment.php");
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="../cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">
    
		<div class="span10 offset1">
		
			<div class="row">
				<h3>Assign a Customer to a Vendor to create Shipment</h3>
			</div>
	
			<form class="form-horizontal" action="createShipment.php" method="post">
		
				<div class="control-group">
					<label class="control-label">Customer</label>
					<div class="controls">
					
					</div>	<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM crudCustomers ORDER BY cust_name ASC';
							echo "<select class='form-control' name='person' id='person_id'>";
								foreach ($pdo->query($sql) as $row) {
									if($personid==$row['id'])
										echo "<option value='" . $row['id'] . " '> " . $row['cust_name']  . "</option>";
								}
							echo "</select>";
							Database::disconnect();
						?>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
			  
				<div class="control-group">
					<label class="control-label">Vendor</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM crudVendors ORDER BY vendor_name ASC';
							echo "<select class='form-control' name='event' id='event_id'>";
								foreach ($pdo->query($sql) as $row) {
									if($personid==$row['id'])
										echo "<option value='" . $row['id'] . " '> " . $row['vendor_name']  . "</option>";
								}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
						<a class="btn" href="index.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
</html>