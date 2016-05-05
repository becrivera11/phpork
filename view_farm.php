<!DOCTYPE HTML> 
<html lang="en">
   <?php session_start(); require_once "connect.php"; require_once "inc/dbinfo.inc"; if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {header("Location: login.php"); } include "inc/functions.php"; $db = new phpork_functions (); ?> 
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Pork Traceability System</title>
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.css">
      <!-- bootstrap_css --> 
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.css">
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.min.css">
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style2_nonnavbar.css">
      <!-- main_css --> 
   </head>
   <body>
      <div class="page-header">
         <!-- banner --> 
         <a href="/phpork/home" onmouseover="pop('header')" onmouseout="hideprompt()">
         	<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/Header1.png">
         </a> 
      </div>
      <div id="again2" style="display:none;"> </div>
      <form class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/logout.php" style="width:50%;float:right;">
         <!-- form|upper right|user-logout --> 
         <div class="form-group logout" >
            <input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
            <div class="col-xs-1 col-sm-1" style="left: -1%;"> 
            	<button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
            </div>
         </div>
      </form>
      <div class="view_farm">
        <div id="view_farm_left" class="col-xs-12 col-sm-4 col-lg-4 col-md-4"> 
         	<a href="view/location/1">
         		<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/1.png">
         	</a> 
        </div>
        <div id="view_farm_middle" class="col-xs-12 col-sm-4 col-lg-4 col-md-4"> 
         	<a href="view/location/2">
         		<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/2.png">
         	</a> 
        </div>
         <div id="view_farm_right" class="col-xs-12 col-sm-4 col-lg-4 col-md-4"> 
         	<a href="view/location/3">
         		<img class="img-responsive" src="<?php echo HOST;?>/phpork/css/images/3.png">
         	</a> 
        </div>
      </div>
      <div class="page-footer"> Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB ||funded by PCAARRD </div>
      <script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
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