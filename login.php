<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$password_hash = md5($password); 

$loginApproved = false;
include 'database.php';
//Find record w/ Email adress
   $pdo = Database::connect();
   $sql = 'SELECT * FROM crudCustomers WHERE username = "'.$username.'"';
   foreach ($pdo->query($sql) as $row) {
	   if (0 == strcmp(trim($row['password']), trim($password_hash))){
		   $loginApproved = true;
		   $_SESSION['userid'] = $row['userid'];
		   $_SESSION['username'] = $username;
	   $_SESSION['first_name'] = $row['first_name'];}
		  if($row['admin'] == 1){
		 $_SESSION['isadmin'] = 1;
		  }
		   else
		  {
			   $_SESSION['isadmin'] = 0;
		   }
   }
   database::disconnect();
    if($_SESSION['isadmin']){
	   header("location: index.php");
   }
   else{
		 header("location: home.php");
   } 
?>

