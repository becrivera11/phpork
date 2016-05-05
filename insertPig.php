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
	include "inc/pigdet.php"; $db = new phpork_functions (); 
	$pig = new pigdet_functions (); ?> 
	<head>
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Pork Traceability System</title> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.min.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.min.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style.css"> 
		<script src="<?php echo HOST;?>/phpork/js/jquery.js"></script> 
		<script src="<?php echo HOST;?>/phpork/js/javascript.js"></script> 
 	</head> 
 	<body> 
 		<div class="page-header"> 
 			<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/Header1.png"/> 
 		</div> 
 		<div id="pig_form"> 
 			<form action = "/phpork/home" method="post"> 
 			<div class="col-sm-6" id="left_insert"> 
 				<table class="table table-striped table-bordered" id="insertTbl"> 
 					<tbody> 
 						<tr> 
 							<td> Pig id: 
 							</td> 
 							<td> 
 								<input type='text' style='text-align:right;color:black;border-radius:5px;' name="new_pid" id="new_pid"  value ="" required/> 
 							</td> 
 						</tr> 
 						<tr> 
 							<td> Farrowing Date: </td> 
	 						<td> 
	 							<input type="date" class="form-control" name="pbdate" id="birth_id" required> 
	 						</td> 
 						</tr> 
 							<tr> 
 								<td> Week farrowed: </td> 
 								<td> 
 									<input type="number" min = "1" max = "52" style="color:black;border-radius:5px;" name="pweekfar" id = "pweekfar" /> 
 								</td> 
 							</tr> 
							<tr> 
								<td> Status: </td> 
								<td> 
									<div id="stat_id"> 
										<select  class="form-control" id="selStat_id" name="selStat" style="color:black;" required> 
											<option value="" disabled selected>Select pig status..</option> 
											<option value="Weaning">Weaning</option> 
											<option value="Growing">Growing</option> 
											<option value="Sow">Sow</option> 
											<option value="Boar">Boar</option> 
										</select> 
									</div> 
								</td> 
							</tr> 
							<tr> 
								<td> Farm: </td> 
								<td> 
									<select class="form-control" name="ploc" id="selLoc_id" style="color:black;" required> 
										<option value="" disabled selected>Select farm location...</option> 
										<?php 
											$arr_loc = $db->ddl_mainlocation(); 
											foreach ($arr_loc as $key => $array) {
												echo "<option value='".$array['loc_id']."' id='loc_id' > ".$array['loc_name']." </option>"; 
											} 
										?> 
									</select> 
								</td> 
							</tr> 
							<tr> 
								<td> House: </td> 
								<td> 
									<div id="div_house"> 
										<select class='form-control' name='selHouse' id='selhouse_id' style='color:black;' required> 
											<option value='' disabled selected>Select house...</option> 
										</select> 
									</div> 
								</td> 
							</tr> 
							<tr> 
								<td> Pen: </td> 
								<td> 
									<div id="div_pen"> 
										<select class='form-control' name='selPen' id='selpen_id' style='color:black;' required> 
											<option value='' disabled selected>Select pen...</option> 
										</select> 
									</div> 
								</td> 
							</tr> 
							<tr> 
								<td> RFID: </td> 
								<td> 
									<input type="text"  id="selRFID"  readonly style="color:black;border-radius:5px;" value="" required> 
									<input type="hidden" name ="prfid" id="hidRFID" value=""/> 
								</td> 
							</tr> 
							<tr> 
								<td> Gender: </td> 
								<td> 
									<input type="radio" name="pgender" value = "M"/>Male 
									<input type="radio" name="pgender" value = "F"/>Female 
								</td>
							</tr> 
							<tr> 
								<td> Breed: </td> 
								<td> 
									<select class="form-control" name="pbreed" id="selBreed_id" style="color:black;" required> 
										<option value="" disabled selected>Select breed...</option> 
										<?php 
											$breedArr = $pig->ddl_breeds(); 
											foreach ($breedArr as $key => $array) {
												echo "<option value='".$array['brid']."' id='breed_id' > ".$array['brname']." </option>"; 
											} 
										?> 
									</select> 
								</td> 
							</tr> 
							<tr> 
								<td> Parents: </td> 
								<td> 
									<select  name="pboar" id="selBoar_id" style="color:black;border-radius:5px;" required> 
										<option value="" disabled selected>Select boar...</option> 
										<option value="null">N/A</option> 
										<?php 
											$boar_arr = $db->ddl_boar(); 
											foreach ($boar_arr as $key => $array) {
												echo "<option value='".$array['boar_id']."' id='boar_id' > ".$array['boar_lbl']." </option>"; 
											} 
										?> 
									</select> 
									<select  name="psow" id="selSow_id" style="color:black;border-radius:5px;" required> 
										<option value="" disabled selected>Select sow...</option> 
										<option value="null">N/A</option> 
										<?php 
											$sow_arr = $db->ddl_sow(); 
											foreach ($sow_arr as $key => $array) {
												echo "<option value='".$array['sow_id']."' id='sow_id' > ".$array['sow_lbl']." </option>"; 
											} 
										?> 
									</select> 
									<select name="pfoster" id="selFoster_id" style="color:black;border-radius:5px;" required> 
										<option value="" disabled selected>Select foster sow...</option> 
										<option value="null">N/A</option> 
										<?php 
											$foster_arr = $db->ddl_foster(); 
											foreach ($foster_arr as $key => $array) {
												echo "<option value='".$array['fos_id']."' id='fos_id' > ".$array['fos_lbl']." </option>"; 
											} 
										?> 
									</select> 
								</td> 
							</tr> 
							<tr> 
								<td> Weight: <br> Weight Type: </td> 
								<td> 
									<input type="number" min="1"  step="0.01" class="form-control" id="weidght_id" name="pweight" style="color:black;" required/> 
									<input type="text" class="form-control" id="weidght_name" name="pweighttype" style="color:black;" required/> 
								</td> 
							</tr> 
						</tbody> 
					</table> 
				</div> 
				<div class="col-sm-6" id="right_insert"> 
					<table class="table table-striped table-bordered" id="feedTbl"> 
						<tbody> 
							<tr> 
								<td colspan="2" style="font-weight:bold;font-size:1.2em;text-align:center;">FEED DETAILS</td> 
							</tr> 
							<tr> 
								<td> 
									<label class = "control-label col-sm-10"> Last feed: </label> 
								</td> 
								<td> 
									<div class = "col-sm-12"> 
										<select class = "form-control" name="selectFeeds" id="selFeed_id" style="color:black;" required> 
											<option value="" disabled selected>Select feeds...</option> 
											<?php 
												$feeds = $db->ddl_feeds(); 
												foreach ($feeds as $key => $array) {
													echo "<option value='".$array['feed_id']."' id='feedname_id' > ".$array['feed_name']." </option>"; 
												} 
											?> 
										</select> 
									</div> 
								</td> 
							</tr> 
							<tr> 
								<td> 
									<label class = "control-label col-sm-12"> Feed Type: </label> 
									<label class = "control-label col-sm-12">Production date of feed: </label> 
								</td> 
								<td> 
									<div class = "col-sm-12" id="feedType"> </div> 
									<input type="date" id="prodid" name="fprodDate" style="color:black;border-radius:5px;"/> 
								</td> 
							</tr> 
							<tr> 
								<td> 
									<label class = "control-label col-sm-12">  Date and time given: </label> 
								</td> 
								<td> 
									<input type="date"  id="fdate_id" name="fdate" style="color:black;border-radius:5px;" required/> 
									<input type="time"  id="ftime_id" name="ftime" style="color:black;border-radius:5px;" required/> 
								</td> 
							</tr> 
							<tr> 
								<td> 
									<label class = "control-label col-sm-12"> Quantity: </label> 
								</td> 
								<td> 
									<input type="number" min="1" step="0.01"  id="fqty_id" name="fqty" style="color:black;border-radius:5px;" required/> &nbsp;&nbsp; kg
								</td> 
							</tr> 
						</tbody> 
					</table>
					<table class="table table-striped table-bordered" id="medTbl"> 
						<tbody> 
							<tr> 
								<td colspan="2" style="font-weight:bold;font-size:1.2em;text-align:center;">MEDICATION DETAILS</td> 
							</tr> 
							<tr> 
								<td> 
									<label class = "control-label col-sm-12"> Last medication given: </label> 
								</td> 
								<td> 
									<div class = "col-sm-12"> 
										<select name="selectMeds" id="selMed_id" style="color:black;" required> 
											<option value="" disabled selected>Select medication...</option> 
											<?php 
												$meds = $db->ddl_meds(); 
												foreach ($meds as $key => $array) {
													echo "<option value='".$array['med_id']."' id='medname_id' > ".$array['med_name']." </option>"; 
												} 
											?> 
										</select> 
									</div> 
								</td> 
							</tr> 
							<tr> 
								<td> 
									<label class = "control-label col-sm-12" > Medication Type: </label> 
								</td> 
								<td> 
									<div class = "col-sm-12" id="medType"> </div> 
								</td> 
							</tr> 
							<tr> 
								<td> 
									<label class = "control-label col-sm-12">  Date and time given: </label> 
								</td> 
								<td> 
									<input type="date" id="medDate_id" name="medDate" style="color:black;border-radius:5px;" required/> 
									<input type="time" id="medTime_id" name="medTime" style="color:black;border-radius:5px;" required/> 
								</td> 
							</tr> 
							<tr>
								<td>
									Quantity: <input type="number" id="mqty_id" name="mqty" min="0"  step="0.01" style="color:black;border-radius:5px;height:25px;"/> &nbsp;&nbsp; 
									<select style="color:black;border-radius:5px;" name="selUnit">
										<option value = "cc"> cc</option>
										<option value="ml">ml</option>
										<option value="kg">kg</option>
									</select>
								</td>
							</tr>
							<tbody> 
							</table> 
						</div> 
						<div id="button-holder" class="text-center col-md-10 col-xs-12"> 
							<div id="prompt" style="display:none;"></div>
							<input type="button" class="btn-cust btn-cust-lg btn-cust-img-left back " id="back" onmouseover="popup('prev')" onmouseout="hide()" value="Back"> 
							<input type = "submit"  class="btn-cust btn-cust-lg btn-cust-img-right insert " id ="insertSub" title="Click this button to submit and insert new pig details." value="Insert"> 
							<input type="hidden" name="addPigFlag" /> 
						</div> 
					</form> 

				</div> 
				<div class="page-footer"> 
					Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB ||funded by PCAARRD 
				</div> 
			</body> 
			<script src="<?php echo HOST;?>/phpork/js/jquery-2.1.4.js" type="text/javascript"></script> 
			<script src="<?php echo HOST;?>/phpork/js/jquery-latest.js" type="text/javascript"></script> 
			<script src="<?php echo HOST;?>/phpork/js/jquery.min.js" type="text/javascript"></script> 
			<script src="<?php echo HOST;?>/phpork/js/jquery.js"></script> 
			<script src="<?php echo HOST;?>/phpork/js/jquery.min-1.js"></script> 
			<script type="text/javascript" src="<?php echo HOST;?>/phpork/js/jsapi.js"></script> 
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
								.attr("class","form-control") 
								.attr("name","feedtypeText") 
								.attr("value",data[0].ftype)); 
							} 
						}); 
					}); 
					$("#selMed_id").on("change", function(e) {
						e.preventDefault(); 
						var name = $('#selMed_id').val(); 
						$.ajax({
							type: "POST", 
							url: "/phpork/checkdata", 
							data: {
								med: name, insertmedphp: '1'
							}, success: function(data) {
								var data = jQuery.parseJSON(data); 
								$("#medType").html($("<input>").attr("type","text")
								.attr("disabled",true)
								.attr("class","form-control")
								.attr("name","medtypeText")
								.attr("value",data[0])); 
							} 
						}); 
					}); 
					$("#selLoc_id").on("change", function(e) {
						e.preventDefault(); 
						var name = $('#selLoc_id').val(); 
						
						$.ajax({type: "POST", 
							url: "/phpork/checkdata", 
							data: {
								loc: name, insertpigphp: '1'
							}, 
							success: function(data) {
								var data = jQuery.parseJSON(data); 
								for(i=0;i<data.length;i++){
									$("#selhouse_id").append($("<option></option>").attr("value",data[i].house_id)
									.attr("name","phouse")
									.text("House "+data[i].house_no)); 
								} 
							} 
						}); 
					}); 
					$("#selhouse_id").on("change", function(e) {
						e.preventDefault();
						var name = $('#selhouse_id').val();
						$.ajax({
							type: "POST", 
							url: "/phpork/checkdata", 
							data: {
								house: name, insertpigphp: '1'
							}, 
							success: function(data) {
								var data = jQuery.parseJSON(data); 
								for(i=0;i<data.length;i++){
									$("#selpen_id").append($("<option></option>").attr("value",data[i].pen_id)
										.attr("name","ppen")
										.text("Pen "+data[i].pen_no)); 
								}	 
							} 
						}); 
					}); 
				
				$('#back').on("click",function() {
					var location =$("#locid").val(); 
					var house = $("#houseid").val(); 
					var pen = $("#penid").val(); 
					var pig = $("#pigid").val(); 
					window.location = "/phpork/home"; 
				}); 
				$('#new_pid').on("focusout",function() {
					var name = $('#new_pid').val(); 
					$.ajax({
						type: "GET", 
						url: "/phpork/checkdata", 
						data: {
							npig: name, 
							insertnewpid: '1'
						}, 
						success: function(data) {
							var data = jQuery.parseJSON(data); 
							$('#selRFID').val(data[0][0]); 
							$('#hidRFID').val(data[0][1]); 
						} 
					}); 
				}); 
			}); 
		</script> 
</html>