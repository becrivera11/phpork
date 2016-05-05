<!-- * PROTOTYPE PORK TRACEABILITY SYSTEM * Copyright © 2014 UPLB. --> 
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
	include "inc/pigdet.php"; 
	$pig = new pigdet_functions(); 
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
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style.css"> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/styles_navbar1.css"> <!-- main_css --> 
		<script src="<?php echo HOST;?>/phpork/js/jquery.js"></script> 
		<script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
	</head> 
	<body> 
		<div class="page-header">
			<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/Header1.png"> 
		</div> 
		<div id='cssmenu'> 
			<ul> 
				<li><a href="/phpork/home">Home</a></li> 
				<li><a href="/phpork/view/location/house/pen/pig/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>">View</a></li> 
				<li  class="active"><a href="#">Edit</a></li> 
				<li><a href="/phpork/insertmenu/location/house/pen/pig/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>">Insert</a></li> 
				<li><a href="/phpork/farm">Change Pig</a></li> 
			</ul> 
		</div> 
		<form id="form-horizontal1" class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/out" style="width:50%;float:right;"> 
			<div class="form-group logout" > 
				<input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
				<div class="col-xs-1 col-sm-1" style="left: -1%;"> 
					<button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
				</div> 
			</div> 
		</form> 
		<div class="container"> 
			<div id ="chart_divedit"> 
				<div id="columnchart_edit" style="display:none">
				</div> 
			</div> 
			<div id="linechart_edit" style="display:none;" > </div> 
			<div class="row2"> 
				<?php 
					$h = $_GET['house']; 
					$l = $_GET['location']; 
					$p = $_GET['pen']; 
					echo "<input type = 'hidden' value= '$h' name = 'house' id = 'houseid'/>"; 
					echo "<input type = 'hidden' value= '$l' name = 'loc' id = 'locid'/>"; 
					echo "<input type = 'hidden' value= '$p' name = 'pen' id = 'penid'/>"; 
				?> 
				<div class="pig-det col-xs-12 col-sm-12 col-md-3 col-lg-3"> 
					<div class="pig-image col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
						<img src="<?php echo HOST;?>/phpork/images/pig.jpg" style="padding-top:5%; width:120px; height:120px; max-width:100%;" /> 
					</div> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Farm Location:&nbsp;&nbsp;<?php echo  $pig->getLocation($_GET['pig']);?></b>
					</span> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Pig id:&nbsp;&nbsp;</b><?php echo $pig->getLabel($_GET['pig']);?>
					</span> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Farrowing Date:&nbsp;&nbsp;</b><?php echo $pig->getBirthDate($_GET['pig']);?>
					</span> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Gender:&nbsp;&nbsp;</b> <?php echo $pig->getGender($_GET['pig']);?>
					</span> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Breed:&nbsp;&nbsp;</b> <?php echo $pig->getBreed($_GET['pig']);?>
					</span> 
				</div> 
				<div class="pig-details col-xs-12 col-sm-12 col-md-9 col-lg-9"> <br> 
					<form method="post" action="/phpork/view/location/house/pen/pig/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>"> 
						<span class="pig-det-label col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align:left;">
							<input type="submit" value="Save details" name="subEdit"/>
						</span><br><br> 
						<span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">Status: </span> 
						<span class="pig-det-details col-xs-2 col-sm-2 col-md-2 col-lg-2"> 
							<select name="ed_status" id="ed_status" style="width:100%;"> 
								<?php  
									$stat = $pig->getStatus($_GET['pig']); 
									echo " <option value = '".$stat."' selected>Current: ".$stat."</option>"; 
								?> 
								<option value="Weaning">Weaning</option> 
								<option value="Growing">Growing</option> 
								<option value="Sow">Sow</option> 
								<option value="Boar">Boar</option> 
								<option value="Sick">Sick</option> 
								<option value="Dead">Dead</option> 
								<option value="Slaughtered">Slaughtered</option> 
							</select> 
						</span> 
						<span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1"> RFID:</span> 
						<span class="pig-det-details col-xs-3 col-sm-3 col-md-3 col-lg-3"> 
							<select name="ed_rfid" id="ed_rfid" style="width:100%;"> 
								<?php  
									$rfid = $pig->getRFID($_GET['pig']); 
									echo "<option value = '".$rfid[1]."'  selected>Current: ".$rfid[0]."</option>"; 
									$in_rfid = $pig->ddl_inactiveRFID(); 
									foreach ($in_rfid as $key => $array) {
										echo "<option value='".$array['tag_id']."'>".$array['rfid']."</option>"; 
									} 
								?> 
							</select> 
						</span> 
						<span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">WEIGHT: </span> 
						<span class="pig-det-details col-xs-1 col-sm-1 col-md-1 col-lg-1">
							<input type="number"  step="0.01" min="1" id="ed_weight" name="ed_weight" style="width:60px;" placeholder="<?php $weight = $pig->getWeight($_GET['pig']); echo $weight[0];?>"/>
						</span> 
						<span class="pig-det-label col-xs-2 col-sm-2 col-md-2 col-lg-2">WEIGHT TYPE: </span> 
						<span class="pig-det-details col-xs-1 col-sm-1 col-md-1 col-lg-1">
							<input type="text"  id="ed_weighttype" name="ed_weighttype" style="width:70px;" placeholder="<?php $weight = $pig->getWeight($_GET['pig']); echo $weight[2];?>"/>
						</span> 
						<input type="hidden" name="ed_user" value="<?php echo $_SESSION['user_id']; ?>" /><br> 
						<hr class="details-hr" /> 
						<span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">PARENTS:  
						</span> <br /> <br> 
						<span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">BOAR: </span>
						<span class="pig-det-details col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<?php 
								$boar= $pig->getBoar($_GET['pig']);
								echo $boar[0];
							?>
						</span> 
						<span class="pig-det-label ">SOW: </span>
						<span class="pig-det-details ">
							<?php 
								$sow= $pig->getSow($_GET['pig']); 
								echo $sow[0];

							?>
						</span> 
						<hr class="details-hr" /> 
					</form> 
				</div> 
				<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12"> </div> 
			</div> 
			<div class="row"> 
				<div class="record-container col-xs-12 col-sm-12 col-md-3 col-lg-3"> 
					<hr class="details-hr" /> 
					<div>
						<a id="movementRecord" class=""  href="/phpork/edit/location/house/pen/pig/mvmnt/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/1" onmouseover="pop('mvmnt')" onmouseout="hideprompt()">Movement</a>
					</div> <div><a id="medsRecord" class=""  href="/phpork/edit/location/house/pen/pig/mrecord/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/2" onmouseover="pop('meds')" onmouseout="hideprompt()">Meds</a>
				</div> 
				<div>
					<a id="feedsRecord" class="" href="/phpork/edit/location/house/pen/pig/frecord/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/3" onmouseover="pop('feeds')" onmouseout="hideprompt()">Feeds</a>
				</div> 
				<div>
					<a id="weightRecord" class="" href="/phpork/edit/location/house/pen/pig/weight/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/4" onmouseover="pop('weight')" onmouseout="hideprompt()">Weight</a>
				</div> 
				<div>
					<a id="back"  href="/phpork/view/location/house/pen/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>" style="cursor:pointer;"  onmouseover="pop('back')" onmouseout="hideprompt()">Back</a>
				</div> 
			</div> 
			<div id="record-details" class="record-details col-xs-12 col-sm-12 col-md-9 col-lg-9"> 
				<?php 
					if(!isset($_GET['record']) || $_GET['record']=='2'){
				?> 
				<script> 
					$('#medsRecord').addClass("active-nav"); 
				</script> 
				<div id="meds" class="tab-pane"> 
					<div class ="form-group"> 
						<label class="control-label col-sm-3 col-md-3">Last medication given:</label> 
						<label id = "last_med" class="control-label col-sm-4 label-default" style = "text-align: center;background-color: white;"> 
							<?php 
								$lastmed = $pig->getLastMed($_GET['pig']); 
								$last = split("-","$lastmed"); 
								echo "Name: ".$last[0]."<br>"; 
								echo "Type: ".$last[1]; 
							?> 
						</label> 
						<div id="meds_tbl" style="width:70%; height:150px; overflow:auto;"> 
							<table class="table table-striped table-bordered" > 
								<thead> 
									<tr> 
										<th>Medication Name</th> 
										<th>Medication Type</th> 
										<th>Edit to</th> 
										<th>Action</th> 
									</tr> 
								</thead> 
								<tbody id = "data"> 
									<?php 
										$mRecord_arr =  $pig->ddl_medRecordEdit($_GET['pig']); 
										foreach ($mRecord_arr as $key => $array) {
											echo "<tr> <td>".$array['mname']."</td> <td>".$array['mtype']."</td> <td><select id='ed_medication".$array['mr_id']."' style='color:black;'>"; 
											$marr = $pig->ddl_medications(); 
											foreach ($marr as $key2 => $array2) {
												echo "<option value='".$array2['med_id']."'>".$array2['med_name']."</option>"; 
											} 
											echo "</select></td> <td><button type=button onclick='updateMR(".$array['mr_id'].");' style='color:black;'>Edit</button></td> </tr>"; 
										} 
									?> 
								</tbody> 
							</table> 
						</div> 
					</div> 
				</div> 
				<?php 
					}else if($_GET['record']=='3'){
				?> 
				<script> 
					$('#feedsRecord').addClass("active-nav"); 
				</script> 
				<div id="feeds" class="tab-pane"> 
					<label class="control-label col-sm-3 col-md-3">Last feed type:</label> 
					<label id = "last_feed" class="control-label col-sm-4 label-default" style = "text-align: center;background-color: white;"> 
						<?php
							$lastfeed = $pig->getLastFeed($_GET['pig']); 
							$last = split("-", "$lastfeed"); 
							echo "Feed name: ".$last[0]."<br>"; 
							echo "Feed type: ".$last[1]; 
						?> 
					</label> 
					<div id="feeds_tbl" style="width:70%; height:150px; overflow:auto;"> 
						<table class="table table-striped table-bordered" > 
							<thead> 
								<tr> 
									<th>Feed Name</th> 
									<th>Feed Type</th> 
									<th>Production Date</th> 
									<th>Edit to</th> 
									<th>Action</th> 
								</tr> 
							</thead> 
							<tbody id = "data"> 
								<?php 
								$fRecord_arr =  $pig->ddl_feedRecordEdit($_GET['pig']); 
								foreach ($fRecord_arr as $key => $array) {
									echo "<tr> <td>".$array['fname']."</td> <td>".$array['ftype']."</td> <td>".$array['proddate']."</td> <td><select id='ed_feeds".$array['ft_id']."' style='color:black;'>"; 
									$farr = $db->ddl_feeds(); 
									foreach ($farr as $key2 => $array2) {
										echo "<option value='".$array2['feed_id']."' id='feedname_id'>".$array2['feed_name']."</option>"; 
									} 
									echo "</select></td> <td><button type=button onclick='updateFR(".$array['ft_id'].");' style='color:black;'>Edit</button></td> </tr>"; 
								} 
							?> 
						</tbody> 
					</table> 
				</div> 
			</div> 
			<?php 
				}else if($_GET['record']=='1'){
			?> 
			<script> 
				$('#movementRecord').addClass("active-nav"); 
			</script> 
			<div id="move" class=""> 
				<form class ="" method = "post" action = "/phpork/mgraph"> 
					<input type="hidden" name="pig" value="<?php $_GET['pig'] ?>"/> 
					<div class =""> 
						<div id="again" style="display:none;"> 
						</div> 
						<label class="control-label col-sm-2 col-md-2 col-lg-2" style="text-align:left;">Currently:</label> 
						<label id = "currently" class="control-label col-sm-4 label-default" style = "text-align: center;background-color: white;"> 
							<?php 
								echo "<label id='h' style='cursor:pointer;' onmouseover='pophouse()' onmouseout='hideprompt()'> House ";
								echo $pig->getCurrentHouse($_GET['pig']);
								echo "</label>"; 
								echo "<label id='p' style='cursor:pointer;' onmouseover='poppen()' onmouseout='hideprompt()'> Pen ";
								echo $pig->getCurrentPen($_GET['pig']);
								echo "</label>"; 
							?> 
						</label> 
						<div class="col-sm-4 col-md-4 col-lg-4"> 
							 <?php

                                           
                                             echo"   <pre id='csv' style='display:none;'  >
                                                            Week No,Weight,Label\n";
                                            foreach ($pweight as $key => $array) {
                                                echo "".$array['week'].",".$array['weight'].",".$array['year']."\n";
                                                   
                                                        
                                            }
                                            echo "</pre>";
                                        ?>
							<a href="/phpork/edit/location/house/pen/pig/mg/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/5">
								<button type="button" title="Click this button to view movement details of selected pig." class="btn btn-default btn-sm" id="btnVisualize" onmouseover="pop('movement')" onmouseout="hideprompt()">Visualize</button> 
							</a> 
						</div> 
					</div> 
				</form> 
				<div id="movement_tbl" style="width:60%; height:150px; overflow:auto;float:left;"> 
					<table class="table table-striped table-bordered" > 
						<thead>
							<tr> 
								<th>Date</th> 
								<th>Time</th> 
								<th>Location</th> 
							</tr> 
						</thead> 
						<tbody id = "data"> 
							<?php 
								$locsArr = $pig->ddl_locations($_GET['pig']); 
								foreach ($locsArr as $key => $array) {
									echo "<tr><td>".$array['date_moved']."</td> <td>".$array['time_moved']."</td> <td>Pen ".$array['pen_no']."</td></tr>"; 
								} 
							?> 
						</tbody> 
					</table> 
				</div> 
				<div id="pig_tbl" style="width:35%; height:150px; overflow:auto; float:right; top:0;"> 
					<table class="table table-striped table-bordered" > 
						<thead> 
							<tr> 
								<th>Pig ID</th> 
								<th>Info</th> 
							</tr> 
						</thead> 
						<tbody id = "data"> 
							<?php 
								$ppenArr = $pig->ddl_pigpen($_GET['pig'],$_GET['pen'],$_GET['house'],$_GET['location']); 
								foreach ($ppenArr as $key => $array) {
									echo "
									<form method='post' action='/phpork/view/location/house/pen/pig/".$_GET['location']."/".$_GET['house']."/".$_GET['pen']."/".$array['pid']."' >
										<tr> 
											<td>".$array['label']."<input type='hidden' name = 'piginfo' class='pig' value='".$array['pid']."' /><br> 
												<input type='hidden' name = 'pen' class='pen' value='".$_GET['pen']."'/><br> 
												<input type='hidden' name = 'location' class='location' value='".$_GET['location']."'/><br> 
												<input type='hidden' name = 'house' class='house' value='".$_GET['house']."'/>
											</td> 
											<td>
												<input type='submit' class='infoBtn' value='Info' style='color:black;' onmouseover='popinfo()' onmouseout='hideprompt()'>
											</td> 
										</tr> 
									</form>"; 
								} 
							?> 
						</tbody> 
					</table> 
				</div> 
			</div>
			<?php 
				}else if($_GET['record']=='4'){ 
					$pweight = $db->getPigWeight ($_GET['pig']); 
					echo"   <pre id='csv' style='display:none;'  > Week No,Weight,Label\n"; 
					foreach ($pweight as $key => $array) {
						echo "".$array['week'].",".$array['weight'].",".$array['year']."\n"; 
					} 
					echo "</pre>"; 
			?> 
			<script> 
				$('#weightRecord').addClass("active-nav"); 
				document.getElementById('columnchart_edit').style.display="block"; 
			</script> 
			<?php 
				}else if($_GET['record']=='5'){
					$weekmvmnt =  $db->getWeekDateMvmnt($_GET['pig']); 
					print "<pre id='csv' style='display:none;'  > Date,Week,Label\n"; 
					foreach ($weekmvmnt as $key => $array) {
						print"".$array['date'].",".$array['week'].",".$array['move']."\n"; 
					} 
					print "</pre>"; 
					$db->getPigMvmnt($_GET['pig']); 
			?> 
			<a href="/phpork/view/location/house/pen/pig/mvmnt/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/1">
				<button>Back</button>
			</a> 
			<script> 
				$('#movementRecord').addClass("active-nav"); 
				document.getElementById('linechart_edit').style.display="block";
			</script> 
			<?php
				} 
			?> 
		</div> 
	</div> 
	<div class="page-footer"> 
		Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB || funded by PCAARRD 
	</div> 
</div> 
<script src="<?php echo HOST;?>/phpork/js/jquery-2.1.4.js" type="text/javascript"></script> 
<script src="<?php echo HOST;?>/phpork/js/jquery-latest.js" type="text/javascript"></script> 
<script src="<?php echo HOST;?>/phpork/js/jquery.min.js" type="text/javascript"></script> 
<script src="<?php echo HOST;?>/phpork/js/javascript.js"></script> 
<script src="<?php echo HOST;?>/phpork/js/jquery.min-1.js"></script> 
<script type="text/javascript" src="<?php echo HOST;?>/phpork/js/jsapi.js"></script> 
<script src="<?php echo HOST;?>/phpork/js/highcharts/js/highcharts.js"></script> 
<script src="<?php echo HOST;?>/phpork/js/highcharts/js/modules/data.js"></script> 
<script src="<?php echo HOST;?>/phpork/js/highcharts/js/modules/exporting.js"></script> 
<script> 
	$(function () {
		$('#columnchart_edit').highcharts({
			data: {
				csv: document.getElementById('csv').innerHTML, 
				itemDelimiter: ',', lineDelimiter: '\n', 
				seriesMapping: [{
					y: 1, 
					label: 2 
				}] 
			}, 
			chart: {
				type: 'column'
			}, 
			title: {
				text: 'Weight record'
			}, 
			yAxis: {
				title: {
					text: 'Weight'
				}, 
				labels: {
					format: '{value} kg'
				}, 
				tickInterval: 5 
			}, 
			xAxis: {
				type: 'category', 
				title: {
					text: 'Week'
				}, 
				labels: {
					format: '{value}'
				}, 
			}, 
			legend: {
				enabled: false 
			}, 
			plotOptions: {
				series: {
					dataLabels: {
						enabled: true, 
						format: '{point.label}'
					}, 
					tooltip: {
						valueSuffix: ' kg'
					} 
				} 
			} 
		}); 
	}); 
	$(function () {$('#linechart_edit').highcharts({
		data: {
			csv: document.getElementById('csv').innerHTML, 
			itemDelimiter: ',', 
			lineDelimiter: '\n', 
			seriesMapping: [{
				y: 1, 
				label: 2 
			}] 
		}, 
		chart: {
			type: 'line'
		}, 
		title: {
			text: 'Movement record'
		}, 
		yAxis: {
			title: {
				text: 'Weeks'
			}, 
			labels: {
				format: '{value}'
			}, 
			tickInterval: 5 
		}, 
		legend: {
			enabled: true 
		}, 
		plotOptions: {
			series: {
				dataLabels: {
					enabled: true, 
					format: '{point.label}'
				}, 
				tooltip: {
					valuePrefix: 'Week '
				} 
			} 
		} 
	}); 
}); 
</script> 
<script type="text/javascript"> 
	$(document).ready(function () {
		$('#h').on("click",function() {
			var location =$("#locid").val();
			window.location = "/phpork/view/location/"+location; 
		}); 
		$('#p').on("click",function() {
			var location =$("#locid").val(); 
			var house = $("#houseid").val(); 
			window.location = "/phpork/view/location/house/"+location+"/"+house; 
		}); 
		$('#previous').on("click",function() {
			var location = $("#locid").val(); 
			window.location = "/phpork/view/location/"+location; 
		}); 
		$('#back').on("click",function() {
			var location =$("#locid").val(); 
			var house = $("#houseid").val(); 
			var pen = $("#penid").val(); 
			window.location = "/phpork/view/location/house/pen/"+location+"/"+house+"/"+pen; 
		}); 
	}); 
</script> 
<script> 
	function pophouse(){
		var div = document.getElementById('again'); 
		div.style.display ="block"; 
		div.style.position ="absolute"; 
		div.style.marginLeft = "10%"; 
		div.style.marginTop = "4%"; 
		div.style.width = "30%"; 
		div.innerHTML = "Click here to select new house."; 
	} 
	function poppen(){
		var div = document.getElementById('again'); 
		div.style.display ="block"; 
		div.style.position ="absolute"; 
		div.style.marginLeft = "10%"; 
		div.style.marginTop = "4%"; 
		div.style.width = "30%"; 
		div.innerHTML = "Click here to select new pen."; 
	} 
	function popinfo(){
		var div = document.getElementById('again'); 
		div.style.display ="block"; 
		div.style.position ="absolute"; 
		div.style.marginLeft = "80%"; 
		div.style.marginTop = "4%"; 
		div.style.width = "30%"; 
		div.innerHTML = "Click here to view information details of this pig."; 
	} 
	function pop(name){
		var div = document.getElementById('again'); 
		if(name=='movement'){
			div.style.display ="block"; 
			div.style.position ="absolute"; 
			div.style.marginLeft = "40%"; 
			div.style.marginTop = "4%"; 
			div.style.width = "30%"; 
			div.innerHTML = "Click here to view movement graph."; 
		}else if(name=='mvmnt'){
			div.style.display ="block"; 
			div.style.position ="absolute"; 
			div.style.marginLeft = "0%"; 
			div.style.marginTop = "4%"; 
			div.style.width = "30%"; 
			div.innerHTML = "Click here to view movement details."; 
		}else if(name=='meds'){
			div.style.display ="block"; 
			div.style.position ="absolute"; 
			div.style.marginLeft = "0%"; 
			div.style.marginTop = "4%"; 
			div.style.width = "30%"; 
			div.innerHTML = "Click here to edit medication details."; 
		}else if(name=='feeds'){
			div.style.display ="block"; 
			div.style.position ="absolute"; 
			div.style.marginLeft = "0%"; 
			div.style.marginTop = "4%"; 
			div.style.width = "30%"; 
			div.innerHTML = "Click here to edit feeds details."; 
		}else if(name=='weight'){
			div.style.display ="block"; 
			div.style.position ="absolute"; 
			div.style.marginLeft = "0%"; 
			div.style.marginTop = "4%"; 
			div.style.width = "30%"; 
			div.innerHTML = "Click here to view weight details.";
		}else if(name=='back'){
			div.style.display ="block"; 
			div.style.position ="absolute"; 
			div.style.marginLeft = "0%"; 
			div.style.marginTop = "4%"; 
			div.style.width = "30%"; 
			div.innerHTML = "Click here to go back to step 1(select a house)."; 
		}else if(name=='save_det'){
			div.style.display ="block"; 
			div.style.position ="absolute"; 
			div.style.marginLeft = "0";
			div.style.marginTop = "-25%"; 
			div.style.width = "30%"; 
			div.innerHTML = "Click here to save pig details."; 
		} 
	} 
	function hideprompt(){
		document.getElementById('again').style.display = 'none'; 
	} 
	function updateMR(mrid){
		$.ajax({
			url: '/phpork/updateMRGateway.php?medid='+$('#ed_medication'+mrid).val()+'&mrid='+mrid, 
			dataType: "json", 
			succcess: function(data){
				alert("Successfully updated"); 
			} 
		}); 
		location.reload(); 
	} 
	function updateFR(frid){
		$.ajax({
			url: '/phpork/updateFRGateway.php?fid='+$('#ed_feeds'+frid).val()+'&frid='+frid, 
			dataType: "json", 
			succcess: function(data){
				alert("Successfully updated"); 
			} 
		}); 
		location.reload(); 
	} 
</script>
</body>
</html>	