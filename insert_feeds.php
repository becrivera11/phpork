<!DOCTYPE HTML>
 <html lang="en"> 
 <?php 
 	session_start(); 
 	require_once "connect.php"; 
 	require_once "inc/dbinfo.inc"; 
 	if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
 		header("Location: login.php"); 
 	} 
 	include "inc/functions.php"; 
 	include "inc/pigdet.php"; 
 	$db = new phpork_functions(); 
 	$pig = new pigdet_functions(); 
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
 		<div class="h_medicine"> 
 			<div class="h_meds_text"> 
 				<img class="img-responsive" src="<?php echo HOST;?>/phpork/images/h_feeds.PNG"> 
 			</div> 
 		</div> 
 		<div class="meds-content active col-xs-12"> </div> 
 		<div id="feeds_form" class="meds-content2 active col-xs-12" > 
 			<form action = "/phpork/insertmenu/location/house/pen/pig/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>" method="post" id="fform"> 
 				<br>
 				<div style="width:100% !important;">
 					<select name="selChoice"  id="selChoice" style="color:black; border-radius:5px;width:30%;align:center; ">
 						<option value="" disabled selected>Select if per pen or per pig..</option> 
	 					<option value="perpen"> Select per pen</option>
	 					<option value="perpig">Select per pig</option>
	 				</select>
 				</div>
 				<br>
 				<?php
 					$h = $_GET['house']; 
 					$l = $_GET['location']; 
 					$p = $_GET['pen']; 
 					$pigid = $_GET['pig']; 
 					echo "<input type = 'hidden' value= '$h' name = 'house' id = 'houseid'/>"; 
 					echo "<input type = 'hidden' value= '$l' name = 'loc' id = 'locid'/>"; 
 					echo "<input type = 'hidden' value= '$p' name = 'pen' id = 'penid'/>"; 
 					echo "<input type = 'hidden' value= '$pigid' name = 'pig' id = 'pigid'/>"; 
 				?>	

 				<div style="overflow-y:scroll;width:100%;height:145px !important;display:none;" id="perpenid"> 
 					<table class="table table-striped table-bordered"> 
 						<tr> 
 							<td colspan="5"> 
 								<input type='checkbox' onchange='checkAllPen(this)' />Select all pens
 							</td> 
 						</tr> 
 						<?php 
 							$ppenArr = $db->ddl_peninsert($_GET['house']); 
 							$k=0; 
 							for ($i=0; $i < sizeof($ppenArr) ;) {
 								echo "<tr>"; 
 								for ($j=0; $j <5 ; $j++,$i++) {
 									if ($i<sizeof($ppenArr)) {
 										echo"<td> <input type='checkbox' class ='penclass' name='pensel[]' value='".$ppenArr[$i]['pen_id']."'/>".$ppenArr[$i]['pen_no']."</td>"; 
 									}
 								} 
 								echo" </tr>"; 
 							} 
 						?> 
 					</table> 
 					
 				</div> 
 				<div style="overflow-y:scroll;width:100%;height:145px !important;display:none;" id="perpigid"> 
 					<table class="table table-striped table-bordered"> 
 						<tr> 
 							<td colspan="5"> 
 								<input type='checkbox' onchange='checkAllPig(this)' />Select all pigs
 							</td> 
 						</tr> 
 						<?php 
 							$ppenArr = $pig->ddl_pigpenall($_GET['pig'],$_GET['pen'],$_GET['house'],$_GET['location']); 
 							$k=0; 
 							for ($i=0; $i < sizeof($ppenArr) ;) {
 								echo "<tr>"; 
 								for ($j=0; $j <5 ; $j++,$i++) {
 									if ($i<sizeof($ppenArr)) {
 										echo"<td> <input type='checkbox' class = 'pigclass' name='pigpen[]' value='".$ppenArr[$i]['pid']."'/>".$ppenArr[$i]['label']."</td>"; 
 									}
 								} 
 								echo" </tr>"; 
 							} 
 						?> 
 					</table> 
 					
 				</div> 
 				<table class="table table-striped table-bordered" id="insertFeeds"> 
 					<tr> 
 						<td> <b>Last feed given: </b>
 							<select name="selectFeeds" id="selFeed_id" style="color:black; border-radius:5px; display:hidden;" > 
 								<option value="" disabled selected>Select feeds...</option> 
 								<?php 
 									$feeds = $db->ddl_feeds(); 
 									foreach ($feeds as $key => $array) {
 										echo "<option value='".$array['feed_id']."' id='feedname_id' > ".$array['feed_name']." </option>"; 
 									} 
 								?> 
 							</select> 
 						</td> 
 						<td><div id="feedType"></div>
 						</td>
 							
 						
 					</tr> 
 					<tr> 
 						<td><b> Production Date:</b>  
 							<input type="date" id="pdate_id" name="feedtypeDate" style="color:black;border-radius:5px;"/> 
 						</td> 
 						<td>
 							<b>Quantity:</b>
 							<input type="number" id="pqty_id" name="feedQty" min="0"  step="0.01" style="color:black;border-radius:5px;height:25px;"/> &nbsp;&nbsp; kg

 						</td>
 					</tr> 
 					<tr> 
 						<td><b> Date given:</b> 
 							<input type="date"  id="fdate_id" name="fdate" style="color:black; border-radius:5px;"/> 
 							
 						</td>
 						<td>
 							<b>Time given:</b>
 							<input type="time"  id="ftime_id" name="ftime" style="color:black;border-radius:5px;"/> 
 						</td>
 					</tr>
 					
 				</table> 
 				<div id="button-holder" class="text-center col-md-10 col-xs-12"> 
 					<div id="prompt" style="display:none;"></div> 
 					<input type="button" class="btn-cust btn-cust-lg btn-cust-img-left back " id="back" onmouseover="popup('prev')" onmouseout="hide()" value="Back"> 
 					<input type = "submit" class="btn-cust btn-cust-lg btn-cust-img-right insert " name ="subFeed" id="subFeed_id"  value="Insert Feeds"/> 
 					<input type="hidden" name="addMedFlag" /> 
 				</div> 
 				<input type="hidden" name="selpig" id="selpig" value="" /> 
 			</form> 
 		</div> 
 		<div class="page-footer"> 
 			Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB || Funded by PCAARRD 
 		</div> 
 		<script src="<?php echo HOST;?>/phpork/js/jquery-2.1.4.js" type="text/javascript"></script> 
 		<script src="<?php echo HOST;?>/phpork/js/jquery-latest.js" type="text/javascript"></script> 
 		<script src="<?php echo HOST;?>/phpork/js/jquery.min.js" type="text/javascript"></script> 
 		<script src="<?php echo HOST;?>/phpork/js/jquery.js"></script> 
 		<script src="<?php echo HOST;?>/phpork/js/javascript.js"></script> 
 		<script src="<?php echo HOST;?>/phpork/js/jquery.min-1.js"></script> 
 		<script type="text/javascript" src="<?php echo HOST;?>/phpork/js/jsapi.js"></script> 
 		<script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
 		<script type="text/javascript"> 
 			$("document").ready(function() {
 				$("#selFeed_id").on("change", function(e) {
 					e.preventDefault(); 
 					var name = $('#selFeed_id').val(); 
 					$.ajax({
 						type: "POST", 
 						url: "/phpork/checkdata", 
 						data: {
 							feed: name, insertfeedphp: '1'
 						}, 
 						success: function(data) {
 							var data = jQuery.parseJSON(data); 
 							$("#feedType").html($("<input>").attr("type","text") 
 							.attr("disabled",true) 
 							.attr("style","border-radius:5px;color:black;height:25px;") 
 							.attr("name","feedtypeText") 
 							.attr("value","TYPE: " + data[0].ftype)); 
 						} 
 					}); 
 				}); 
 				$("#selChoice").on("change", function(e) {
 					e.preventDefault(); 
 					var name = $('#selChoice').val(); 
 					if (name == 'perpen') {
 						$('#perpenid').css("display","block");
 						$('#perpigid').css("display","none");
 					}else if(name=='perpig'){
 						$('#perpigid').css("display","block");
 						$('#perpenid').css("display","none");
 					} 
 				}); 
 				$('#back').on("click",function() {
 					var location =$("#locid").val(); 
 					var house = $("#houseid").val(); 
 					var pen = $("#penid").val(); 
 					var pig = $("#pigid").val(); 
 					window.location = "/phpork/insertmenu/location/house/pen/pig/"+location+"/"+house+"/"+pen+"/"+pig; 
 				});
 				$('#fform').on('submit', function (e) {
 					if ($("input[type=checkbox]:checked").length === 0) {
 					 e.preventDefault(); 
 					 alert('Choose pig!'); 
 					 return false; 
 					}else{ 
 						return true; 
 					} 
 				}); 
 			}); 
 		</script> 

 		<script> 
 			function checkAllPig(ele) {
 			 var checkboxes = document.getElementsByClassName('pigclass'); 
 			 if (ele.checked) { 
 			 	for (var i = 0; i < checkboxes.length; i++) {
 			 	 if (checkboxes[i].type == 'checkbox') { 
 			 	 	checkboxes[i].checked = true; 
 			 	 } 
 			 	} 
 			 } else {
 			 	for (var i = 0; i < checkboxes.length; i++) {  
 			 		if (checkboxes[i].type == 'checkbox') { 
 			 			checkboxes[i].checked = false; 
 			 		} 
 			 	} 
 			 } 
 			} 
 			function checkAllPen(ele) {
 			 var checkboxes = document.getElementsByClassName('penclass'); 
 			 if (ele.checked) { 
 			 	for (var i = 0; i < checkboxes.length; i++) {
 			 	 if (checkboxes[i].type == 'checkbox') { 
 			 	 	checkboxes[i].checked = true; 
 			 	 } 
 			 	} 
 			 } else {
 			 	for (var i = 0; i < checkboxes.length; i++) {  
 			 		if (checkboxes[i].type == 'checkbox') { 
 			 			checkboxes[i].checked = false; 
 			 		} 
 			 	} 
 			 } 
 			} 
 		</script> 
 		</body> 
 	</html>