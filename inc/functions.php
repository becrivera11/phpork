<?php /* PROTOTYPE PORK TRACEABILITY SYSTEM * Copyright © 2014 UPLB.*/
require_once ('dbinfo.inc');

class phpork_functions

{
		private function connect()
		{
				$link = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE) or die('Could not connect: ' . mysqli_error());
				mysqli_select_db($link, DATABASE) or die('Could not select database' . mysql_error());
				return $link;
		}

		public function ddl_mainlocation()
		{
				$link = $this->connect();
				$query = "SELECT loc_name, 
							loc_id 
						FROM location";
				$result = mysqli_query($link, $query) or die(mysqli_error($link));
				$loc = array();
				$arr_loc = array();
				while ($row = mysqli_fetch_row($result)) {
						$loc['loc_name'] = $row[0];
						$loc['loc_id'] = $row[1];
						$arr_loc[] = $loc;
				}

				return $arr_loc;
		}

		public function ddl_house($loc)
		{
			
				$link = $this->connect();
				$hquery = "SELECT house_id, 
								house_no, 
								house_name 
							FROM house 
							WHERE loc_id = '" . $loc . "'
							ORDER BY house_no ASC";
				$hresult = mysqli_query($link, $hquery);
				$house = array();
				$arr_house = array();
				while ($row = mysqli_fetch_row($hresult)) {
						$house['house_id'] = $row[0];
						$house['house_no'] = $row[1];
						$house['house_name'] = $row[2];
						$arr_house[] = $house;
				}

				return $arr_house;
		}

		public function ddl_pen($house)
		{
				$link = $this->connect();
				$pquery = "SELECT pen_no, 
							pen_id 
						FROM pen 
						WHERE house_id = '" . $house . "'
						ORDER BY pen_no ASC";
				$presult = mysqli_query($link, $pquery);
				$pen = array();
				$arr_pen = array();
				while ($row = mysqli_fetch_row($presult)) {
						$pen['pen_no'] = $row[0];
						$pen['pen_id'] = $row[1];
						$arr_pen[] = $pen;
				}

				return $arr_pen;
		}
		public function ddl_peninsert($house)
		{
				$link = $this->connect();
				$pquery = "SELECT pen_no, 
							pen_id 
						FROM pen 
						WHERE house_id = '" . $house . "' and 
						function != 'mortality'
						ORDER BY pen_no ASC";
				$presult = mysqli_query($link, $pquery);
				$pen = array();
				$arr_pen = array();
				while ($row = mysqli_fetch_row($presult)) {
						$pen['pen_no'] = $row[0];
						$pen['pen_id'] = $row[1];
						$arr_pen[] = $pen;
				}

				return $arr_pen;
		}
		public function ddl_pig($house, $pen)
		{
				$link = $this->connect();
				$pquery = "SELECT p.pig_id, 
							rt.label 
						FROM pig p 
						INNER JOIN rfid_tags rt ON rt.pig_id = p.pig_id 
						WHERE p.pen_id = '" . $pen . "'
						ORDER BY p.pig_id ASC";
				$presult = mysqli_query($link, $pquery);
				$pig = array();
				$arr_pig = array();
				while ($row = mysqli_fetch_row($presult)) {
						$pig['pig_id'] = $row[0];
						$pig['lbl'] = $row[1];
						$arr_pig[] = $pig;
				}

				return $arr_pig;
		}

		public function ddl_HousePen($loc)
		{
				$link = $this->connect();
				$search = "SELECT a.pen_id, 
								a.pen_no, 
								b.house_no,
								b.house_id 
							FROM pen a 
								INNER JOIN house b 
									ON a.house_id = b.house_id 
								INNER JOIN location l 
									ON l.loc_id = b.loc_id 
							WHERE l.loc_id = '" . $loc . "'";
				$resultq = mysqli_query($link, $search);
				$houpen = array();
				$hp_arr = array();
				while ($row = mysqli_fetch_row($resultq)) {
						$houpen['pen_id'] = $row[0];
						$houpen['pen_no'] = $row[1];
						$houpen['house_no'] = $row[2];
						$houpen['house_id'] = $row[3];
						$hp_arr[] = $houpen;
				}

				return $hp_arr;
		}

		public function ddl_meds()
		{
				$link = $this->connect();
				$search = "SELECT med_id,
							med_name,
							med_type 
						FROM medication ";
				$resultq = mysqli_query($link, $search);
				$med_name = array();
				$meds = array();
				while ($row = mysqli_fetch_row($resultq)) {
						$med_name['med_id'] = $row[0];
						$med_name['med_name'] = $row[1];
						$med_name['med_type'] = $row[2];
						$meds[] = $med_name;
				}

				return $meds;
		}

		public function ddl_feeds()
		{
				$link = $this->connect();
				$search = "SELECT feed_id,
							feed_name,
							feed_type 
						FROM feeds ";
				$resultq = mysqli_query($link, $search);
				$fname = array();
				$feeds = array();
				while ($row = mysqli_fetch_row($resultq)) {
						$fname['feed_id'] = $row[0];
						$fname['feed_name'] = $row[1];
						$fname['feed_type'] = $row[2];
						$feeds[] = $fname;
				}

				return $feeds;
		}

		public function ddl_sow()
		{
				$link = $this->connect();
				$search = "SELECT DISTINCT sow_id 
							FROM pig";
				$resultq = mysqli_query($link, $search);
				$sow = array();
				$sow_arr = array();
				while ($row = mysqli_fetch_row($resultq)) {
						if ($row[0] != null) {
								$sowid = $row[0];
								$lensow = strlen($sowid);
								$new = "0";
								$totLen = 4 - $lensow;
								for ($a = 0; $a < $totLen - 1; $a++) {
										$new = $new . "0";
								}

								$new = $new . "$sowid";
								$sow['sow_lbl'] = $new;
								$sow['sow_id'] = $sowid;
								$sow_arr[] = $sow;
						}
				}

				return $sow_arr;
		}

		public function ddl_boar()
		{
				$link = $this->connect();
				$search = "SELECT DISTINCT boar_id 
						FROM pig";
				$resultq = mysqli_query($link, $search);
				$boar = array();
				$boar_arr = array();
				while ($row = mysqli_fetch_row($resultq)) {
						if ($row[0] != null) {
								$boarid = $row[0];
								$lenboar = strlen($boarid);
								$new = "0";
								$totLen = 4 - $lenboar;
								for ($a = 0; $a < $totLen - 1; $a++) {
										$new = $new . "0";
								}

								$new = $new . "$boarid";
								$boar['boar_lbl'] = $new;
								$boar['boar_id'] = $boarid;
								$boar_arr[] = $boar;
						}
				}

				return $boar_arr;
		}

		public function ddl_foster()
		{
				$link = $this->connect();
				$search = "SELECT DISTINCT foster_sow 
						FROM pig";
				$resultq = mysqli_query($link, $search);
				$foster = array();
				$foster_arr = array();
				while ($row = mysqli_fetch_row($resultq)) {
						if ($row[0] != null) {
								$fosid = $row[0];
								$lenfos = strlen($fosid);
								$new = "0";
								$totLen = 4 - $lensfos;
								for ($a = 0; $a < $totLen - 1; $a++) {
										$new = $new . "0";
								}

								$new = $new . "$fosid";
								$foster['fos_id'] = $fosid;
								$foster['fos_lbl'] = $new;
								$foster_arr[] = $foster;
						}
				}

				return $foster_arr;
		}

		public function getNextPigID()
		{
				$link = $this->connect();
				$search = "SELECT max(p.pig_id) FROM pig p ";
				$resultq = mysqli_query($link, $search);
				$row2 = mysqli_fetch_row($resultq);
				return $row2[0] + 1;
		}

		

		
		public function getPigWeight($pig)
		{
				$link = $this->connect();
				$query = "SELECT DISTINCT record_date, 
							weight, 
							WEEK(record_date) 
						FROM weight_record 
						WHERE pig_id = '" . $pig . " '
						ORDER BY record_date ASC";
				$result = mysqli_query($link, $query);
				$dates = "";
				$weeks = "";
				$weights = "";
				$data = "";
				$data2 = "";
				$arr = array();
				$ar_data = array();
				while ($row = mysqli_fetch_row($result)) {
						$ddate = $row[0];
						$wt = $row[1];
						$weekno = $row[2];
						$year = strtotime($ddate);
						$arr['year'] = date('Y', $year);
						$dates = $ddate;
						$arr['week'] = $weekno;
						$arr['weight'] = $wt;
						$ar_data[] = $arr;
				}

				return $ar_data;
		}

		public function getWeekDateMvmnt($pig)
		{
				$link = $this->connect();
				$query = "SELECT DISTINCT date_moved,WEEK(date_moved),pen_id
							
						from movement 
						where pig_id = '".$pig."'
						ORDER BY date_moved ASC";
				$result = mysqli_query($link, $query);
				$data = array();
				$arr = array();
				$i = 0;
				$mvmnt = $this->getPigMvmnt($pig);
				while ($row = mysqli_fetch_row($result)) {
						$years = strtotime($row[0]);
						$data['date'] = date('d/m/Y', $years);
						$data['week'] = $row[1];
						$data['move'] = $mvmnt[$i];
						$arr[] = $data;
						$i++;
				}

				return $arr;
		}

		

		public function getPigMvmnt($pig)
		{
				$link = $this->connect();
				$query = "SELECT distinct m.date_moved, 
							m.pen_id, 
							p.pen_no, 
							h.house_no, 
							h.house_name,
							l.loc_name
						from movement m 
						INNER JOIN pen p 
							ON p.pen_id = m.pen_id 
						INNER JOIN house h 
							ON h.house_id = p.house_id 
						inner join location l on
							l.loc_id = h.loc_id
						where m.pig_id = '".$pig."'
						ORDER BY m.date_moved ASC,m.time_moved asc
							";
				$result = mysqli_query($link, $query);
				$data = "";
				$data2 = array();
				$housepen = "";
				while ($row = mysqli_fetch_row($result)) {
						if ($housepen == "") {
								$data2[] =$row[5]."-H" . $row[3] . "P" . $row[2];
						}
						else {
								$data2[] = $row[5]."-H" . $row[3] . "P" . $row[2];
						}
				}

				return $data2;
		}

		public function getFeedProdDate($var)
		{
				$link = $this->connect();
				$query = "SELECT prod_date 
						FROM feeds 
						WHERE feed_id = '" . $var . "'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				$date = date_create($row[0]);
				$d = $date->format('F j,Y');
				return $row[0];
		}

		public function getFeedType($var)
		{
				$link = $this->connect();
				$query = " SELECT DISTINCT feed_type 
							FROM feeds 
							WHERE feed_id = '" . $var . "'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				return $row[0];
		}

		public function getMedType($var)
		{
				$link = $this->connect();
				$query = " SELECT DISTINCT med_type 
							FROM medication 
							WHERE med_id = '" . $var . "'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				return $row[0];
		}

		public function updatePigDetails($pig_id, $user, $stat)
		{
				$link = $this->connect();
				if ($stat == 'Dead') {
						$q = "SELECT h.house_id 
							FROM pig pi 
								INNER JOIN pen p 
									ON p.pen_id = pi.pen_id 
								INNER JOIN house h 
									ON h.house_id = p.house_id 
							WHERE pi.pig_id = '" . $pig_id . "'";
						$r = mysqli_query($link, $q);
						$row = mysqli_fetch_row($r);
						$q2 = "SELECT pen_id 
								from pen 
								where house_id=" . $row[0] . " 
								and function='mortality'";
						$r2 = mysqli_query($link, $q2);
						$row2 = mysqli_fetch_row($r2);
						$query = "UPDATE pig 
									set pig_status = '" . $stat . "', 
									pen_id = '" . $row2[0] . "', 
									user = '" . $user . "'
								WHERE pig_id = '" . $pig_id . "'";
				}
				else {
						$query = "UPDATE pig 
									set pig_status = '" . $stat . "', 
									user = '" . $user . "'
								WHERE pig_id = '" . $pig_id . "'";
				}

				$result = mysqli_query($link, $query);
		}

		public function updatePigWeight($pig_id, $weight, $record_id, $remarks)
		{
				$link = $this->connect();
				date_default_timezone_set("Asia/Manila");
				$d = date("Y-m-d");
				$t = date("h:i:s");
				$query = "INSERT INTO  weight_record(record_date,record_time,weight,pig_id,remarks) 
						VALUES ('" . $d . "','" . $t . "','" . $weight . "','" . $pig_id . "','" . $remarks . "')";
				$result = mysqli_query($link, $query);
		}

		public function updateRFIDdetails($pig_id, $rfid, $prevrfid, $plabel)
		{
				$link = $this->connect();
				$query = "UPDATE rfid_tags 
						set status = 'lost', 
						pig_id = NULL, 
						label = '0'
						WHERE tag_id = '" . $prevrfid . "'";
				$result = mysqli_query($link, $query);
				$query = "UPDATE rfid_tags 
						set status = 'active', 
							pig_id = " . $pig_id . ", 
							label = '" . $plabel . "'
						WHERE tag_id = '" . $rfid . "'";
				$result = mysqli_query($link, $query);
		}

		public function updatepigRFID($pig_id, $rfid)
		{
				$link = $this->connect();
				$query = "UPDATE rfid_tags set status = 'active', pig_id = " . $pig_id . ", label = '" . $pig_id . "'WHERE tag_id = '" . $rfid . "'";
				$result = mysqli_query($link, $query);
		}

		public function insertEditHistory($weight, $user, $pig_id, $prevstat, $prevrfid)
		{
				$link = $this->connect();
				$query = "INSERT INTO edit_history(pig_id,weight,status,rfid,user) 
							values('" . $pig_id . "','" . $weight . "','" . $prevstat . "','" . $prevrfid . "','" . $user . "');";
				$result = mysqli_query($link, $query);
		}

		public function insertMedEditHistory($medid, $user, $mrid)
		{
				$link = $this->connect();
				$query = "INSERT INTO med_edit_history(mr_id,med_id,user) values('" . $mrid . "','" . $medid . "','" . $user . "');";
				$result = mysqli_query($link, $query);
		}

		public function insertFeedsEditHistory($medid, $user, $mrid)
		{
				$link = $this->connect();
				$query = "INSERT INTO feeds_edit_history(fr_id,feed_id,user) values('" . $mrid . "','" . $medid . "','" . $user . "');";
				$result = mysqli_query($link, $query);
		}

		public function updateMeds($med_id, $mrid, $user)
		{
				$link = $this->connect();
				$query2 = "SELECT med_id FROM med_record WHERE mr_id='" . $mrid . "'";
				$result2 = mysqli_query($link, $query2);
				$row = mysqli_fetch_row($result2);
				$query = "UPDATE med_record set med_id = '" . $med_id . "'WHERE mr_id = '" . $mrid . "'";
				$result = mysqli_query($link, $query);
				if ($result) {
						$this->insertMedEditHistory($row[0], $user, $mrid);
						return array(
								'success' => '1'
						);
				}
				else {
						return array(
								'success' => '0'
						);
				}

				echo "<script>alert('Successfully updated!');</script>";
		}

		public function updateFeeds($fid, $ftid, $user)
		{
				$link = $this->connect();
				$query2 = "SELECT feed_id FROM feed_transaction WHERE ft_id='" . $ftid . "'";
				$result2 = mysqli_query($link, $query2);
				$row = mysqli_fetch_row($result2);
				$query = "UPDATE feed_transaction set feed_id = '" . $fid . "'WHERE ft_id = '" . $ftid . "'";
				$result = mysqli_query($link, $query);
				if ($result) {
						$this->insertFeedsEditHistory($row[0], $user, $ftid);
						return array(
								'success' => '1'
						);
				}
				else {
						return array(
								'success' => '0'
						);
				}

				echo "<script>alert('Successfully updated!');</script>";
		}
		 public function ddl_perpen($pen)
    {
        $link     = $this->connect();
        $query    = "SELECT 
                        p.pig_id 
                    FROM  pig p
                        INNER JOIN pen pe 
                            ON pe.pen_id = p.pen_id 
                    WHERE p.pen_id  = '" . $pen . "' ";
        $result   = mysqli_query($link, $query);
        $ppen     = array();
        $arr_ppen = array();
        while ($row = mysqli_fetch_row($result)) {
            $arr_ppen[]    = $row[0];

        }
        return $arr_ppen;
    }
		public function addMeds($mid, $mdate, $mtime, $pig,$qty,$unit)
		{
				$link = $this->connect();
				$query = "INSERT INTO med_record(date_given,time_given,quantity,unit,pig_id,med_id) VALUES('" . $mdate . "','" . $mtime . "','" . $qty . "','" . $unit . "','" . $pig . "','" . $mid . "');";
				$result = mysqli_query($link, $query);
		}

		public function addFeeds($fid, $fdate, $ftime, $pig, $proddate,$qty)
		{
				$link = $this->connect();
				$query = "INSERT INTO feed_transaction(quantity,unit,date_given,time_given,pig_id,feed_id,prod_date) VALUES('" . $qty . "','kg','" . $fdate . "','" . $ftime . "','" . $pig . "','" . $fid . "','" . $proddate . "');";
				$result = mysqli_query($link, $query);
		}

		public function addPig($pid, $pbdate, $pweekfar, $pfarm, $phouse, $ppen, $prfid, $pgender, $pbreed, $pboar, $psow, $pfoster, $pweight, $pstatus, $user)
		{
				$handler = "";
				$valHandler = "";
				$link = $this->connect();
				if ($pboar != "null") {
						$handler = "boar_id,";
						$valHandler = "'" . $pboar . "',";
				}

				if ($psow != "null") {
						$handler = $handler . "sow_id,";
						$valHandler = $valHandler . "'" . $psow . "',";
				}

				if ($pfoster != "null") {
						$handler = $handler . "foster_sow,";
						$valHandler = $valHandler . "'" . $pfoster . "',";
				}

				$query = "INSERT INTO pig(pig_id," . $handler . "week_farrowed,gender,farrowing_date,pig_status,pen_id,breed_id,user,pig_batch) 
						VALUES('" . $pid . "'," . $valHandler . "'" . $pweekfar . "','" . $pgender . "','" . $pbdate . "','" . $pstatus . "','" . $ppen . "','" . $pbreed . "','" . $user . "','-');";
				$result = mysqli_query($link, $query);
		}

		public function addPigWeight($pid, $pweight, $remarks)
		{
				$link = $this->connect();
				date_default_timezone_set("Asia/Manila");
				$d = date("Y-m-d");
				$t = date("h:i:s");
				$query = "INSERT INTO  weight_record(record_date,record_time,weight,pig_id,remarks) 
						VALUES ('" . $d . "','" . $t . "','" . $pweight . "','" . $pid . "','" . $remarks . "')";
				$result = mysqli_query($link, $query);
		}
}

