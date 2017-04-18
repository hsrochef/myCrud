<?php
class Customers
{
	
public function loginz()
{
	if (empty($_SESSION['userid'])){ // user not set
  Customers::login();
  exit();
}}

public function login() {
    echo '<form action="login.php" method="post">';
	echo '<p>Username:';
	echo '<input type="text" name="username"><br>';
	echo '<p>Password:';
	echo '<input type="password" name="password"><br>';
	echo '<input type="submit" value="Submit">';
	echo '</form>';
	echo '<a class="btn btn-success" href="register.php">Register</a>';
} 

	
	
public function displayCustomers()
	{
		$pdo = Database::connect();
					   $sql = 'SELECT * FROM crudCustomers ORDER BY userid DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['first_name'] . '</td>';
                            echo '<td>'. $row['phone_number'] . '</td>';
                            echo '<td>'. $row['address'] . '</td>';
							

							echo '<td width=250>';
							echo '<a class="btn btn-success" href="readCustomer.php?id='.$row['userid'].'">Read</a>';
							echo '&nbsp;';

							echo '<a class="btn btn-success" href="updateCustomer.php?id='.$row['userid'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteCustomer.php?id='.$row['userid'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';	
                   }
                   Database::disconnect();
	}

public function displayVendors()
	{
		$pdo = Database::connect();
                   $sql = 'SELECT * FROM crudVendors ORDER BY vendor_id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['vendor_name'] . '</td>';
                            echo '<td>'. $row['vendor_phone'] . '</td>';
                            echo '<td>'. $row['vendor_address'] . '</td>';
							echo '<td width=250>';
					
							echo '<a class="btn btn-success" href="updateVendor.php?id='.$row['vendor_id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteVendor.php?id='.$row['vendor_id'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';	
                   }
                   Database::disconnect();
	}
public function displayShipments()
	{
		$pdo = Database::connect();
                   $sql = 'SELECT shipment_id, first_name, vendor_name, shipment_data, shipment_amount
						   FROM crudCustomers, crudVendors, crudShipments
						   WHERE crudCustomers.userid = crudShipments.cust_id
						   AND crudVendors.vendor_id = crudShipments.vendor_id';
						   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['shipment_id'] . '</td>';
                            echo '<td>'. $row['first_name'] . '</td>';
                            echo '<td>'. $row['vendor_name'] . '</td>';
							echo '<td>'. $row['shipment_data'] . '</td>';
                            echo '<td>'. $row['shipment_amount'] . '</td>';
							echo '<td width=250>';
						
							echo '<a class="btn btn-success" href="updateShipment.php?id='.$row['shipment_id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteShipment.php?id='.$row['shipment_id'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';	
                   }
                   Database::disconnect();
	}

public function importBootstrap()
{
		echo'<!DOCTYPE html>
<html lang="en">
<head>
</head>
 <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body>
	<meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>';
	
}
	
	
public function displayCustomersHeading()
	{
		    echo'<div class="container">
            <div class="row">
                <h3>Rochefort CRUD Customer <a href="createCustomer.php" class="btn btn-success">Create</a></h3>
				<h3>Welcome Admin, '.$_SESSION['first_name'].'</h3>';

			echo '</div>
            <div class="row">
			   
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Customer Name</th>
                      <th>Customer Phone</th>
                      <th>Customer Address</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>';
					   Customers::displayCustomers();
                  echo'</tbody>
            </table>
        </div>
		<div class="row">
                <h3>Rochefort CRUD Vendor <a href="createVendor.php" class="btn btn-success">Create</a></h3>
            </div>
            <div class="row">
		            <div class="row">
			   
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Vendor Name</th>
                      <th>Vendor Phone</th>
                      <th>Vendor Address</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>';
                   Customers::displayVendors();
                  echo '</tbody>
            </table>
        </div>
		
			<div class="row">
				<h3>Rochefort CRUD Shipment <a href="createShipment.php" class="btn btn-success">Create</a></h3>
            </div>
            <div class="row">
		          <div class="row">
			  
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Shipment ID</th>
                      <th>Customer Name</th>
					  <th>Vendor Name</th>
                      <th>Shipment Data</th>
                      <th>Shipment Amount</th>               
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>';
                   Customers::displayShipments();
                  echo '</tbody>
            </table>
        </div>
		<a href="logout.php" class="btn btn-danger">Log Out</a></div>';
	}

public function callAll()
{
	echo'<!DOCTYPE html>
<html lang="en">
<head>';
	Customers::importBootstrap();
echo'</head>
 
<body>';
	Customers::displayCustomersHeading();
echo'</body>
</html>';

}



	
}
	

?>





