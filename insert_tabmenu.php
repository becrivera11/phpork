<!DOCTYPE HTML> 
<html lang="en"> 
<?php 
	session_start(); 
	require_once "connect.php"; 
	require_once "inc/dbinfo.inc"; 
	if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
		header("Location:login.php"); 
	} 
	include "inc/functions.php"; 
	
	$db = new phpork_functions (); 
	
	if(isset($_POST['subFeed']) ){
		$fid = $_POST['selectFeeds']; 
		$fdate = $_POST['fdate']; 
		$ftime = $_POST['ftime']; 
		$selpig = $_POST['selpig']; 
		$proddate = $_POST['feedtypeDate']; 
		$qty = $_POST['feedQty'];

		$sparray = array();

		if (isset($_POST['pensel'])) {
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				
				
				
			}
			$fqty = $qty/sizeof($sparray);
			
			$feedqty = number_format($fqty, 2, '.', ',');
			foreach ($_POST['pensel'] as $key) {
			$sparray = $db->ddl_perpen($key);
			foreach ($sparray as $a ) {
				
				$db->addFeeds($fid,$fdate,$ftime,$a,$proddate,$feedqty); 
			
			}
			
			
		}

		}
		if (isset($_POST['pigpen'])) {

			$pigsize = sizeof($_POST['pigpen']);
			$fqty = $qty/$pigsize;
			foreach($_POST['pigpen'] as $pid){
				$db->addFeeds($fid,$fdate,$ftime,$pid,$proddate,$fqty); 					
			} 
		}

		echo "<script>alert('Added successfully!');</script>"; 
	} 
	if(isset($_POST['subMed'])){
		$medid = $_POST['selectMeds']; 
		$medDate = $_POST['medDate']; 
		$medTime = $_POST['medTime']; 
		$qty = $_POST['medQty'];
		$unit = $_POST['selUnit'];
		$sparray = array();
		if (isset($_POST['pensel'])) {
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				
				
			}
			$fqty = $qty/sizeof($sparray);
			
			$medqty = number_format($fqty, 2, '.', ',');
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				foreach ($sparray as $a ) {
					
					$db->addMeds($medid,$medDate,$medTime,$a,$medqty,$unit); 
				
				}
				
				
			}

		}
		if (isset($_POST['pigpen'])) {
			$pigsize = sizeof($_POST['pigpen']);
			$fqty = $qty/$pigsize;
			foreach($_POST['pigpen'] as $pid){
				$db->addMeds($medid,$medDate,$medTime,$pid,$fqty,$unit);  					
			} 
		}
		echo "<script>alert('Added successfully!');</script>"; 
	} 
?> 
	<head> 
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Pork Traceability System</title> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.min.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.min.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/styles_navbar1.css"> 
		<script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
	</head> 
	<body> 
		<div class="page-header"> 
			<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/Header1.png"> 
		</div> 
		<div id='cssmenu'> 
			<ul> 
				<li>
					<a href="/phpork/home">Home</a>
				</li> 
				<li>
					<a href="/phpork/view/location/house/pen/pig/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>">View</a>
				</li> 
				<li>
					<a href="/phpork/edit/location/house/pen/pig/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>">Edit</a>
				</li> 
				<li class="active">
					<a href="#">Insert</a>
				</li> 
				<li>
					<a href="/phpork/farm">Change Pig</a>
				</li> 
			</ul> 
		</div> 
		<form id="form-horizontal1" class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/logout.php" style="width:50%;float:right;"> 
			<div class="form-group logout" > 
				<input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
				<div class="col-xs-1 col-sm-1" style="left: -1%;"> 
					<button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
				</div> 
			</div> 
		</form> 
		<div class="insert_tabmenu"> 
			<div id="insert_feeds" class="col-xs-12 col-sm-6 col-lg-6 col-md-6"> 
				<a href="/phpork/insertmenu/location/house/pen/pig/feeds/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>">
					<img class="img-responsive" src="<?php echo HOST;?>/phpork/images/icons/feeds1.png">
				</a> 
			</div> 
			<div id="insert_meds" class="col-xs-12 col-sm-6 col-lg-6 col-md-6"> 
				<a href="/phpork/insertmenu/location/house/pen/pig/meds/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>">
					<img class="img-responsive" src="<?php echo HOST;?>/phpork/images/icons/meds1.png">
				</a> 
			</div> 
		</div> 
		<div class="page-footer"> 
			Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB ||funded by PCAARRD 
		</div> 
	</body> 
</html>