<?php 
	require_once "connect.php"; 
	require_once "inc/dbinfo.inc"; 
	include "inc/functions.php"; 
	include "inc/pigdet.php"; 
	$db = new phpork_functions (); 
	$pig = new pigdet_functions (); 
	if(isset($_POST['loc']) && isset($_POST['insertpigphp'])){
		$loc = $_POST['loc']; 
		$arr_house = $db->ddl_house($loc); 
		
		echo json_encode($arr_house); 
	} 
	if(isset($_POST['house']) && isset($_POST['insertpigphp'])){
		$house = $_POST['house']; 
		$arr_pen = $db->ddl_pen($house); 
		echo json_encode($arr_pen); 
	} 
	if(isset($_POST['week']) && isset($_POST['insertpigphp'])){
		$date = $_POST['week']; 
		$week = ceil( date( 'j', strtotime( $date ) ) / 7 ); 
		$year = date('Y',strtotime($date)); 
		$month = date('F',strtotime($date)); 
		$ddate = $month.' '.$year; 
		$arweek['week'] = $week; 
		$arweek['date'] =$ddate; 
		$arr_week[] = $arweek; 
		echo json_encode($arr_week); 
	} 
	if(isset($_POST['feed']) && isset($_POST['insertfeedphp'])){
		$feed = $_POST['feed']; 
		$ftype['ftype'] = $db->getFeedType($feed); 
		$arr_feed[] = $ftype; 
		echo json_encode($arr_feed); 
	} 
	if(isset($_POST['med']) && isset($_POST['insertmedphp'])){
		$med = $_POST['med']; 
		$mtype[] =  $db->getMedType($med); 
		echo json_encode($mtype); 
	} 
	if (isset($_GET['npig']) && isset($_GET['insertnewpid'])) {
		$npid = $_GET['npig']; 
		$rfid[] = $pig->getinsertRFID($npid); 
		echo json_encode($rfid); 
	} 
?>