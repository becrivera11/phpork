<!DOCTYPE HTML> 
<html lang="en"> 
<?php 
	session_start(); 
	require_once "connect.php"; 
	require_once "inc/dbinfo.inc"; 
	require_once "inc/dbinfo.inc"; 
	if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
		header("Location: login.php"); 
	} 
	include "inc/functions.php"; 
	$db = new phpork_functions (); 
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
	</head> 
	<body> 
		<div class="page-header"> 
			<a href="/phpork/home" onmouseover="pop('header')" onmouseout="hideprompt()">
				<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/Header1.png">
			</a>
		</div> 
		<div id="again2" style="display:none;"> </div> 
		<form class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/logout.php" style="width:50%;float:right;"> 
			<div class="form-group logout" > 
				<input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
				<div class="col-xs-1 col-sm-1" style="left: -1%;"> 
					<button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
				</div> 
			</div> 
		</form> 
		<div class="row2"> 
			<div class="content" > 
				<ul class="step-indicator"> 
					<li class="each-step active">Select house</li> 
					<li class="each-step active">Select pen</li> 
					<li class="each-step active">Select pig</li> 
				</ul> 
			</div> 
			<div class="step-content active"> 
				<?php 
					$h = $_GET['house']; 
					$l = $_GET['location']; 
					$p = $_GET['pen']; 
					echo "<input type = 'hidden' value= '$h' name = 'house' id = 'houseid'/>"; 
					echo "<input type = 'hidden' value= '$l' name = 'loc' id = 'locid'/><input type = 'hidden' value= '$p' name = 'pen' id = 'penid'/>"; 
				?> 
			</div> 
			<div class="step-content2 active col-xs-12"> 
				<span class="custom-dropdown2"> 
					<select id="dropdown"> 
						<?php 
							$arr_pig= $db->ddl_pig($_GET['house'],$_GET['pen']); 
							foreach ($arr_pig as $key => $array) {
								echo "<option value='".$array['pig_id']."' id='p_id' >Pig ".$array['lbl']." </option>"; 
							} 
						?>
					</select>
				</span>
				<div id="button-holder" class="text-center col-md-10 col-xs-12"> 
					<div id="prompt" style="display:none;"></div> 
					<button class="btn-cust btn-cust-lg btn-cust-img-left previous " id="previous" onmouseover="popup('prev')" onmouseout="hide()"> 
						<span class="stepBtn">Previous</span> 
					</button> 
					<button class="btn-cust btn-cust-lg btn-cust-img-right next " id="next" onmouseover="popup('next')" onmouseout="hide()"> 
						<span class="stepBtn">Next</span> 
					</button> 
				</div> 
			</div> 
		</div> 
		<div class="page-footer"> 
			Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB ||funded by PCAARRD 
		</div> 
		<script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
		<script type="text/javascript"> 
			$(document).ready(function () {
				$('#next').on("click",function() {
					var house = $("#houseid").val(); 
					var location = $("#locid").val(); 
					var pen = $("#penid").val(); 
					var pigno = $("#dropdown").val(); 
					window.location = "/phpork/view/location/house/pen/pig/"+location+"/"+house+"/"+pen+"/"+pigno; }); 
				$('#previous').on("click",function() {
					var house = $("#houseid").val(); 
					var location = $("#locid").val(); 
					window.location = "/phpork/view/location/house/"+location+"/"+house; 
				}); 
			}); 
		</script> 
		<script> 
			function pop(name){
				var div = document.getElementById('again2'); 
				if(name=='header'){
					div.style.display ="block"; 
					div.style.position ="absolute"; 
					div.style.marginLeft = "40%"; 
					div.style.marginTop = "-2%"; 
					div.style.width = "20%"; 
					div.innerHTML = "Click here to go back to home page."; 
				} 
			} 
			function hideprompt(){
				document.getElementById('again2').style.display = 'none'; 
			} 
		</script> 
	</body> 
</html>