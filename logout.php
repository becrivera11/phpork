<?php /* This file logouts the admin. */ 
session_start(); 
unset($_SESSION["username"]); 
unset($_SESSION["password"]); 
header("Location: login.php"); 
exit; 
?>