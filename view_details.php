<!-- * PROTOTYPE PORK TRACEABILITY SYSTEM * Copyright © 2014 UPLB. --> 
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
	include "/inc/pigdet.php"; 
	$pig = new pigdet_functions();
	$db = new phpork_functions (); 
	$w = "";
	$w1="";
	if(isset($_POST['subEdit'])){
		$newweight = $_POST['ed_weight']; 
		$newuser = $_SESSION['user_id']; 
		$newrfid = $_POST['ed_rfid']; 
		$newstat = $_POST['ed_status']; 
		$prevweight = $pig->getWeight($_GET['pig']); 
		$prevuser = $pig->getUserEdited($_GET['pig']); 
		$prevstat = $pig->getStatus($_GET['pig']); 
		$prevrfid = $pig->getRFID($_GET['pig']); 
		$plabel = $pig->getLabel($_GET['pig']); 
		$remarks = $_POST['ed_weighttype']; 
		$prevremarks = $pig->getPrevRemarks($_GET['pig']); 
		if(isset($_POST['ed_weight'])){
			if ($_POST['ed_weight']!= "") {

				$db->updatePigWeight($_GET['pig'],$newweight,$prevweight[1],$prevremarks[2]);  
				$w1 = $newweight;
				
			}elseif ( $_POST['ed_weighttype']!= "") {
				$db->updatePigWeight($_GET['pig'],$prevweight[0],$prevweight[1],$remarks);  
				$w = $prevweight[0];
				
			}else{
				$db->updatePigWeight($_GET['pig'],$prevweight[0],$prevweight[1],$prevremarks[2]);  
				$w = $prevweight[0];
				
			} 
			
		} 
		$db->updatePigDetails($_GET['pig'],$newuser,$newstat); 
		$db->updateRFIDdetails($_GET['pig'],$newrfid,$prevrfid[1],$plabel); 
		$db->insertEditHistory($w,$prevuser,$_GET['pig'],$prevstat,$prevrfid[0]); 
		echo "<script>alert('Successfully updated!');</script>"; 
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
		<script src="<?php echo HOST;?>/phpork/js/jquery.js"></script> 
		<link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/styles_navbar1.css"> <!-- main_css --> 
		<script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
	</head> 
	<body> 
		<div class="page-header"> <!-- banner --> 
			<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/Header1.png"> 
		</div> 
		<div id='cssmenu'> 
			<ul> <!-- navbar --> 
				<li>
					<a href="/phpork/home">Home</a>
				</li> 
				<li  class="active">
					<a href="#">View</a>
				</li> 
				<li>
					<a href="/phpork/edit/location/house/pen/pig/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>">Edit</a>
				</li> 
				<li>
					<a href="/phpork/insertmenu/location/house/pen/pig/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>">Insert</a>
				</li> 
				<li>
					<a href="/phpork/farm">Change Pig</a>
				</li> 
			</ul> 
		</div> 
		<form id="form-horizontal1" class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/out" style="width:50%;float:right;"> <!-- form|upper right|user-logout --> 
			<div class="form-group logout" > 
				<input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
				<div class="col-xs-1 col-sm-1" style="left: -1%;"> 
					<button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
				</div> 
			</div> 
		</form> 
		<div class="container"> 
			<div id ="chart_div"> 
				<div id="columnchart_values" style="display:none"> </div> 
			</div> 
			<div id="linechart_values" style="display:none;" > </div> 
			<div class="row2"> 
				<?php 
					$h = $_GET['house']; 
					$l = $_GET['location']; 
					$p = $_GET['pen']; 
					echo "<input type = 'hidden' value= '$h' name = 'houseno' id = 'houseid'/>"; 
					echo "<input type = 'hidden' value= '$l' name = 'loc' id = 'locid'/>"; 
					echo "<input type = 'hidden' value= '$p' name = 'penno' id = 'penid'/>"; 
				?> 
				<div class="pig-det col-xs-12 col-sm-12 col-md-3 col-lg-3"> 
					<div class="pig-image col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
						<img src="<?php echo HOST;?>/phpork/images/pig.jpg" style="padding-top:5%; width:120px; height:120px; max-width:100%;" /> 
					</div> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Pig id: <?php echo $pig->getLabel($_GET['pig']);?></b>
					</span> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>RFID:</b> 
						<?php  
							$r = $pig->getRFID($_GET['pig']); 
							echo $r[0];
						?>
					</span> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Gender:</b> 
						<?php 
							echo $pig->getGender($_GET['pig']);
						?>
					</span> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Breed:</b> 
						<?php 
							echo $pig->getBreed($_GET['pig']);
						?>
					</span> 
					<span class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<b>Status:</b>
						<?php 
							echo $pig->getStatus($_GET['pig']);
						?>
					</span> 
				</div> 
				<div class="pig-details col-xs-12 col-sm-12 col-md-9 col-lg-9"> <br/>
					<span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">FARM: </span> 
					<span class="pig-det-details col-xs-2 col-sm-2 col-md-2 col-lg-2">
						<?php 
							echo  $pig->getLocation($_GET['pig']);
						?>
					</span> 
					<span class="pig-det-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Farrowing Date: </span> 
					<span class="pig-det-details col-xs-2 col-sm-2 col-md-2 col-lg-2">
						<?php
							echo $pig->getBirthDate($_GET['pig']);
						?>
					</span> 
					<span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">WEIGHT: </span> 
					<span class="pig-det-details col-xs-3 col-sm-3 col-md-3 col-lg-3">
						<?php  
							$weight = $pig->getWeight($_GET['pig']); 
							echo $weight[0]." - ".$weight[2]." weight";
						?>
					</span> <br/> <br>
					<hr class="details-hr" /> 
					<span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-12">PARENTS:    </span> <br /> <br> 
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
				</div> 
				<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12"> </div> 
			</div> 
			<div class="row"> 
				<div class="record-container col-xs-12 col-sm-12 col-md-3 col-lg-3"> 
					<hr class="details-hr" /> 
					<div>
						<a id="movementRecord" class=""  href="/phpork/view/location/house/pen/pig/mvmnt/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/1" onmouseover="pop('mvmnt')" onmouseout="hideprompt()">Movement</a>
					</div> 
					<div>
						<a id="medsRecord" class=""  href="/phpork/view/location/house/pen/pig/mrecord/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/2" onmouseover="pop('meds')" onmouseout="hideprompt()">Meds</a>
					</div> 
					<div>
						<a id="feedsRecord" class="" href="/phpork/view/location/house/pen/pig/frecord/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/3" onmouseover="pop('feeds')" onmouseout="hideprompt()">Feeds</a>
					</div> 
					<div>
						<a id="weightRecord" class="" href="/phpork/view/location/house/pen/pig/weight/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/4" onmouseover="pop('weight')" onmouseout="hideprompt()">Weight</a>
					</div> 
					<div>
						<a id="back"  href="/phpork/view/location/house/pen/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>" style="cursor:pointer;"  onmouseover="pop('back')" onmouseout="hideprompt()">Back</a>
					</div> 
				</div> 
				<div id="record-details" class="record-details col-xs-12 col-sm-12 col-md-9 col-lg-9"> 
					<?php 
						if(!isset($_GET['record']) || $_GET['record']=='1'){
					?> 
					<script> 
						$('#movementRecord').addClass("active-nav"); 
					</script> 
					<div id="move" class=""> 
						<form class ="" method = "post" action = "/phpork/mgraph"> 
							<input type="hidden" name="pig" value= "<?php $_GET['pig'] ?>"/> 
                                <div class =""> 
                                    <div id="again" style="display:none;">

                                    </div>
                                    <label class="control-label col-sm-2 col-md-2 col-lg-2" style="text-align:left;">Currently:</label> 
                                    <label id = "currently" class="control-label col-sm-4 label-default" style = "text-align: center;background-color: white;"> 
                                        <?php 
                                        $house = "house";
                                        $pen = "pen";
                                            echo "<label id='h' style='cursor:pointer;' onmouseover='pophouse()' onmouseout='hideprompt()'> House ";
                                            echo $pig->getCurrentHouse($_GET['pig']);
                                            echo "</label>"; 
                                            echo "<label id='p' style='cursor:pointer;' onmouseover='poppen()' onmouseout='hideprompt()'> Pen ";
                                            echo $pig->getCurrentPen($_GET['pig']);
                                            echo "</label>";
                                        ?>
                        
                                    </label> 

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
								<a href="/phpork/view/location/house/pen/pig/mg/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/5">
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
							<tbody id = "data" > 
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
					}else if($_GET['record']=='2'){
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
								$last = split("-", "$lastmed"); 
								echo "Name: ".$last[0]."<br>"; 
								echo "Type: ".$last[1]; ?> 
							</label> 
							<div id="meds_tbl" style="width:70%; height:150px; overflow:auto;"> 
								<table class="table table-striped table-bordered" > 
									<thead> 
										<tr> 
											<th>Medication Name</th> 
											<th>Medication Type</th> 
											<th>Quantity</th>
											<th>Date given</th> 
										</tr> 
									</thead> 
									<tbody id = "data"> 
										<?php 
											$mr =  $pig->ddl_medRecord($_GET['pig']); 
											foreach ($mr as $key => $array) {
												echo "<tr> <td>".$array['mname']."</td> <td>".$array['mtype']."</td> <td>".$array['qty']."</td> <td>".$array['date_given']."</td> </tr>"; 
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
										<th>Quantity</th>
										<th>Production Date</th> 
										<th>Date Given</th> 
									</tr> 
								</thead> 
								<tbody id = "data"> 
									<?php 
										$fr = $pig->ddl_feedRecord($_GET['pig']); 
										foreach ($fr as $key => $array) {
											echo "<tr> 
												<td>".$array['fname']."</td> 
												<td>".$array['ftype']."</td> 
												<td>".$array['qty']."</td> 
												<td>".$array['proddate']."</td> 
												<td>".$array['date_given']."</td> 
											</tr>"; 
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
							document.getElementById('columnchart_values').style.display="block"; 
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
						<a href="/phpork/view/location/house/pen/pig/mvmnt/<?php echo $_GET['location'];?>/<?php echo $_GET['house'];?>/<?php echo $_GET['pen'];?>/<?php echo $_GET['pig'];?>/1" >
							<img style="height:25px;width:25px;" src="<?php echo HOST;?>/phpork/css/images/LEFT.png">
						</a> 
						<script> 
							$('#movementRecord').addClass("active-nav"); 
							document.getElementById('linechart_values').style.display="block"; 
						</script> 
						
					<?php 
						} 
					?> 
				</div> 
			</div> 
		</div> 
		<div class="page-footer"> 
			Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB || funded by PCAARRD 
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
				$('#columnchart_values').highcharts({
					data: {
						csv: document.getElementById('csv').innerHTML, 
						itemDelimiter: ',', 
						lineDelimiter: '\n', 
						seriesMapping: [{
							y: 1, label: 2 
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
					}, plotOptions: {
						series: {
							dataLabels: {
								enabled: true, 
								format: '{point.label}'
							}, 
							tooltip: {
								valueSuffix: ' kg'
							},
							color: '#bb1d24' 
						} 
					}

				}); 
			}); 
			$(function () {
				$('#linechart_values').highcharts({
					data: {
						csv: document.getElementById('csv').innerHTML, 
						itemDelimiter: ',', 
						lineDelimiter: '\n', 
						seriesMapping: [{
							y: 1, label: 2 
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
					xAxis: {
						type: 'category', 
						title: {
							text: 'Date'
						}
					}, 
					legend: {
						enabled: true 
					}, 
					plotOptions: {
						series: {
							dataLabels: {
								enabled: true, 
								format: '{point.label}',
			                    align: 'left',
                    			x: -30,
                    			y: 20,
                    			rotation: -45,
                    			style: {
			                        fontWeight: 'bold'
			                    }
							}, 
							tooltip: {
								valuePrefix: 'Week '
							},
							color: '#bb1d24'
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
				$("#selectsearch").change(function() {
					var action = $(this).val() == "people" ? "user" : "content"; 
					$("#search-form").attr("action", "/search/" + action); 
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
				div.style.marginLeft = "85%"; 
				div.style.marginTop = "4%"; 
				div.style.width = "20%"; 
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
					div.innerHTML = "Click here to view medication details."; 
				}else if(name=='feeds'){
					div.style.display ="block"; 
					div.style.position ="absolute"; 
					div.style.marginLeft = "0%"; 
					div.style.marginTop = "4%"; 
					div.style.width = "30%"; 
					div.innerHTML = "Click here to view feeds details."; 
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
				}else if(name=='header'){
					div.style.display ="block"; 
					div.style.position ="absolute"; 
					div.style.marginLeft = "0%"; 
					div.style.marginTop = "10%"; 
					div.style.width = "30%"; 
					div.innerHTML = "Click here to go back to home page."; 
				} 
			} 
			function hideprompt(){
				document.getElementById('again').style.display = 'none'; 
			} 
		</script> 
	</body> 
</html>