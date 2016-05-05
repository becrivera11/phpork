<!DOCTYPE HTML> 
<html lang = "en">
   <?php session_start(); if(isset($_SESSION['username']) && isset($_SESSION['password'])) {header("Location: index.php"); } require_once "connect.php"; require_once "inc/dbinfo.inc"; require_once "inc/dbinfo.inc"; if(count($_POST)>0) {$result = mysqli_query($con, "SELECT user_id,user_name,password FROM user WHERE user_name='" . $_POST["username"]."' and password = '". $_POST["password"]."'") or die ( mysqli_error ( $con ) ); $row = mysqli_fetch_row($result); if($row != null) {$_SESSION["user_id"] = $row[0]; $_SESSION["username"] = $row[1]; $_SESSION["password"] = $row[2]; header("Location: index.php"); } else {echo "<script> alert('Invalid username/password!'); </script>"; } mysqli_free_result($result); mysqli_close($con); } ?> 
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Pork Traceability System</title>
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.css">
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.css">
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.min.css">
      <script src="<?php echo HOST;?>/phpork/js/jquery-2.1.4.js" type="text/javascript"></script> 
      <script src="<?php echo HOST;?>/phpork/js/jquery-latest.js" type="text/javascript"></script> 
      <script src="<?php echo HOST;?>/phpork/js/jquery.min.js" type="text/javascript"></script> 
      <script src="<?php echo HOST;?>/phpork/js/bootstrap.js" type="text/javascript"></script> 
      <script src="<?php echo HOST;?>/phpork/js/bootstrap.min.js" type="text/javascript"></script> 
      <script src="<?php echo HOST;?>/phpork/js/jquery.min.js"></script> 
      <script src="<?php echo HOST;?>/phpork/js/bootstrap.min.js"></script> 
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/reset.css">
      <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style.css">
   </head>
   <body style="background-color:white;">
      <div id="qr_code"> <img src="<?php echo HOST;?>/phpork/css/images/qrcode.png"  class="img-responsive"> </div>
      <div id="login_header" style="margin-bottom: 1%;"> <img src="<?php echo HOST;?>/phpork/css/images/log2.png" class="img-responsive"> </div>
      <form class = "form-horizontal login" style="align:center" method = "post"  autocomplete = "off">
         <fieldset>
            <div class="input" style=""> <input type="text" placeholder="Username" class="user_name" name="username" required /> <img src="<?php echo HOST;?>/phpork/css/images/user.png" id="input_img"> <span><i class="fa fa-envelope-o"></i></span> </div>
            <div class="input"> <input type="password" placeholder="Password" class="password" name="password" required /> <img src="<?php echo HOST;?>/phpork/css/images/lock.png" id="input_img"> <span><i class="fa fa-lock"></i></span> </div>
            <button type="submit" class="submit"><i class="fa fa-long-arrow-right"><img src="<?php echo HOST;?>/phpork/css/images/arrow.png" id="arrow_img"></i></button> 
         </fieldset>
      </form>
      <br> <script src="<?php echo HOST;?>/phpork/js/javascript.js"></script> <script src='http://localhost/phpork/js/jquery.min.js'></script> 
   </body>
</html>