<!DOCTYPE HTML> 
<html lang="en"> 
<?php 
	session_start(); 
	require_once "connect.php"; 
	require_once "inc/dbinfo.inc"; 
	if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
		header("Location: login.php"); 
	} 
	include "/inc/functions.php"; 
	$db = new phpork_functions (); 
	if(isset($_POST['addPigFlag'])){
		$pid = $_POST['new_pid']; 
		$pbdate = $_POST['pbdate']; 
		$pweekfar = $_POST['pweekfar']; 
		$pfarm = $_POST['ploc']; 
		$pstatus = $_POST['selStat']; 
		$phouse = $_POST['selHouse']; 
		$ppen = $_POST['selPen']; 
		$prfid = $_POST['prfid']; 
		$pgender = $_POST['pgender']; 
		$pbreed = $_POST['pbreed']; 
		$pboar = $_POST['pboar']; 
		$psow = $_POST['psow']; 
		$pfoster = $_POST['pfoster'];
		$pweight = $_POST['pweight']; 
		$user = $_SESSION['user_id']; 
		$fid = $_POST['selectFeeds']; 
		$fdate = $_POST['fdate']; 
		$ftime = $_POST['ftime']; 
		$medid = $_POST['selectMeds']; 
		$medDate = $_POST['medDate'];
		$medTime = $_POST['medTime']; 
		$proddate = $_POST['fprodDate']; 
		$remarks = $_POST['pweighttype']; 
		$fqty = $_POST['fqty'];
		$mqty = $_POST['mqty'];
		$unit = $_POST['selUnit'];
		$db->addPig($pid,$pbdate,$pweekfar,$pfarm,$phouse,$ppen,$prfid,$pgender,$pbreed,$pboar,$psow,$pfoster,$pweight,$pstatus,$user); 
		$db->addPigWeight($pid,$pweight,$remarks); 
		$db->addFeeds($fid,$fdate,$ftime,$pid,$proddate,$fqty); 
		$db->addMeds($medid,$medDate,$medTime,$pid,$mqty,$unit);
		$db->updatepigRFID($pid,$prfid); 
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
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style2_nonnavbar.css"> 
		<script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
	</head> 
	<body> 
		<div class="page-header"> 
			<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/Header1.png"> 
		</div> 
		<form class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/out" style="width:50%;float:right;"> 
			<div class="form-group logout" > 
				<input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
				<div class="col-xs-1 col-sm-1" style="left: -1%;"> 
					<button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
				</div> 
			</div> 
		</form> 
		<div class="menu"> 
			<div class="menu_view"> 
				<a href="/phpork/farm">
					<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/View.png">
				</a> 
			</div> 
			<div class="menu_insert"> 
				<a href="/phpork/addpig">
					<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/Insert.png">
				</a> 
			</div> 
		</div> 
	
	<div class="page-footer"> 
		Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB ||funded by PCAARRD 
	</div>
	</body> 
</html>