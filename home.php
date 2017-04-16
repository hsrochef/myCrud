<?php  
include 'database.php';
include 'ooh.php';
session_start(); 
Customers::loginz();
Customers::importBootstrap();
Customers::displayCustomersHeading();

?>


