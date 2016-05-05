<?php 
	session_start(); 
	require_once "connect.php"; 
	require_once "inc/dbinfo.inc"; 
	if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
		header("Location: login.php"); 
	} 
	include "inc/functions.php"; 
	include "inc/pigdet.php"; 
	$pig = new pigdet_functions(); 
	$db = new phpork_functions(); 
	echo json_encode($db->updateFeeds($_GET['fid'],$_GET['frid'],$_SESSION['user_id'])); 
	echo "<script>alert('Successfully updated!');</script>"; 
?>