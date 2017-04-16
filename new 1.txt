<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$password_hash = md5($password); 
$loginApproved = false; 


include 'database.php';
$pdo = Database::connect();
$sql = 'SELECT * FROM crudPasswords WHERE username = "' . $username . '"';

foreach ($pdo->query($sql) as $row) {
	if (0 == strcmp(trim($row['password']), trim($password_hash))) {
		$loginApproved = true;
		$_SESSION['userid'] = $row['userid'];

	}
}
Database::disconnect();
header("Location: index.php");
?>