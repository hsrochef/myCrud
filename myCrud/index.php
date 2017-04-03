<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Rochefort CRUD Customer</h3>
            </div>
            <div class="row">
			    <p>
                    <a href="createCustomer.php" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Customer Name</th>
                      <th>Customer Phone</th>
                      <th>Customer Address</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM crudCustomers ORDER BY cust_id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['cust_name'] . '</td>';
                            echo '<td>'. $row['cust_phone'] . '</td>';
                            echo '<td>'. $row['cust_address'] . '</td>';
							echo '<td width=250>';
							echo '<a class="btn" href="readCustomer.php?id='.$row['cust_id'].'">Read</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="updateCustomer.php?id='.$row['cust_id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteCustomer.php?id='.$row['cust_id'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';	
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
		
			<div class="row">
                <h3>Rochefort CRUD Vendor</h3>
            </div>
            <div class="row">
		            <div class="row">
			    <p>
                    <a href="createVendor.php" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Vendor Name</th>
                      <th>Vendor Phone</th>
                      <th>Vendor Address</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM crudVendors ORDER BY vendor_id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['vendor_name'] . '</td>';
                            echo '<td>'. $row['vendor_phone'] . '</td>';
                            echo '<td>'. $row['vendor_address'] . '</td>';
							echo '<td width=250>';
							echo '<a class="btn" href="readVendor.php?id='.$row['vendor_id'].'">Read</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="updateVendor.php?id='.$row['vendor_id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteVendor.php?id='.$row['vendor_id'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';	
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
		
			<div class="row">
				<h3>Rochefort CRUD Shipment</h3>
            </div>
            <div class="row">
		          <div class="row">
			    <p>
                    <a href="createShipment.php" class="btn btn-success">Create</a>
                </p>
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
                  <tbody>
                  <?php
                   $pdo = Database::connect();
                   $sql = 'SELECT shipment_id, cust_name, vendor_name, shipment_data, shipment_amount
						   FROM crudCustomers, crudVendors, crudShipments
						   WHERE crudCustomers.cust_id = crudShipments.cust_id
						   AND crudVendors.vendor_id = crudShipments.vendor_id';
						   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['shipment_id'] . '</td>';
                            echo '<td>'. $row['cust_name'] . '</td>';
                            echo '<td>'. $row['vendor_name'] . '</td>';
							echo '<td>'. $row['shipment_data'] . '</td>';
                            echo '<td>'. $row['shipment_amount'] . '</td>';
							echo '<td width=250>';
							echo '<a class="btn" href="readShipment.php?id='.$row['shipment_id'].'">Read</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="updateShipment.php?id='.$row['shipment_id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteShipment.php?id='.$row['shipment_id'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';	
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
		
		
		
    </div> <!-- /container -->
  </body>
</html>