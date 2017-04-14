<?php  
include 'database.php';
include 'oo.php';
session_start(); 
Customers::loginz();
Customers::importBootstrap();
Customers::displayCustomersHeading();

?>


