<!-- * PROTOTYPE PORK TRACEABILITY SYSTEM * Copyright © 2014 UPLB. --> <?php session_start(); require_once "connect.php"; require_once "inc/dbinfo.inc"; if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {header("Location: login.php"); } include "inc/functions.php"; $db  = new phpork_functions(); if(isset($_POST['pig_id'])){$var = $_POST['pig_id']; }else{$var = $db->getNextPigID(); } if (file_exists("images/" . $var)) {echo "It exists."; } else {mkdir("images/" . $var); } $uploaddir   = "images/" . $var . '/'; $file        = $_POST['value']; $name        = $_POST['name']; $getMime     = explode('.', $name); $mime        = end($getMime); $data        = explode(',', $file); $encodedData = str_replace(' ', '+', $data[1]); $decodedData = base64_decode($encodedData); $i           = 1; while (file_exists($uploaddir . '/' . $i . '.' . $mime)) {$i++; } $randomName = $i . '.' . $mime; if (file_put_contents($uploaddir . $randomName, $decodedData)) {echo $randomName . ":uploaded successfully"; } else {echo "Something went wrong. Check that the file isn't corrupted"; } ?>