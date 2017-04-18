<?php

	include 'database.php';
	
	$pdo = Database::connect();
	if($_GET['userid']) 
		$sql = "SELECT * from crudCustomers WHERE userid=" . $_GET['userid']; 
	else
		$sql = "SELECT * from crudCustomers";

	$arr = array();
	foreach ($pdo->query($sql) as $row) {
	
		array_push($arr, $row['first_name']);
		
	}
	Database::disconnect();

	echo '{"names":' . json_encode($arr) . '}';
?>