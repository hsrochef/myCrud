<?php

	include 'database.php';
	
	$pdo = Database::connect();
	if($_GET['cust_id']) 
		$sql = "SELECT * from crudCustomers WHERE cust_id=" . $_GET['cust_id']; 
	else
		$sql = "SELECT * from crudCustomers";

	$arr = array();
	foreach ($pdo->query($sql) as $row) {
	
		array_push($arr, $row['cust_name']);
		
	}
	Database::disconnect();

	echo '{"names":' . json_encode($arr) . '}';
?>