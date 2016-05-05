<?php
/* PROTOTYPE PORK TRACEABILITY SYSTEM * Copyright © 2014 UPLB.*/
require_once('dbinfo.inc');
class pigdet_functions
{
    private function connect()
    {
        $link = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE) or die('Could not connect: ' . mysqli_error());
        mysqli_select_db($link, DATABASE) or die('Could not select database' . mysql_error());
        return $link;
    }
    public function getLocation($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT l.loc_name 
                    FROM location l 
                        INNER JOIN house h  
                            ON h.loc_id = l.loc_id 
                        INNER JOIN pen p 
                            ON p.house_id = h.house_id 
                        INNER JOIN pig pi 
                            ON pi.pen_id = p.pen_id 
                    WHERE pi.pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getLabel($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT label FROM rfid_tags WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getRFID($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT tag_rfid,tag_id 
                    FROM rfid_tags
                     WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        $r      = array();
        $arr    = array();
        $r[]    = $row[0];
        $r[]    = $row[1];
        return $r;
    }
    public function getinsertRFID($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT tag_rfid,
                    tag_id 
                    FROM rfid_tags 
                    WHERE pig_id = '" . $pigid . "' and status='inactive'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        $r      = array();
        $arr    = array();
        $r[]    = $row[0];
        $r[]    = $row[1];
        return $r;
    }
    public function getGender($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT gender 
                    FROM pig 
                    WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getBirthDate($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT farrowing_date 
                FROM pig 
                WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        $pd     = date('F d, Y', strtotime($row[0]));
        return $pd;
    }
    public function getAge($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT farrowing_date 
                    FROM pig 
                    WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        $from   = new DateTime($row[0]);
        $to     = new DateTime('today');
        if ($from->diff($to)->y == 0) {
            $diff   = $from->diff(new DateTime());
            $months = $diff->format('%m') + 12 * $diff->format('%y');
            return $months . " months";
        } else {
            return $from->diff($to)->y . " years old";
        }
    }
    public function getBreed($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT pb.breed_name 
                FROM pig p 
                    INNER JOIN pig_breeds pb 
                        ON pb.breed_id = p.breed_id 
                WHERE p.pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getStatus($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT pig_status 
                    FROM pig 
                    WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getPrevRemarks($pigid)
    {
        $link    = $this->connect();
        $query   = "SELECT max(record_date)
                    FROM weight_record 
                    WHERE pig_id = '" . $pigid . "'";
        $result  = mysqli_query($link, $query);
        $row     = mysqli_fetch_row($result);
        $query3   = "SELECT max(record_time)
                    FROM weight_record 
                    WHERE pig_id = '" . $pigid . "' and
                    record_date = '".$row[0]."'";
        $result3  = mysqli_query($link, $query3);
        $row3     = mysqli_fetch_row($result3);
        $query2  = "SELECT weight,
                        record_id,
                        remarks 
                    FROM weight_record 
                    WHERE pig_id = '" . $pigid . "'
                    AND record_date = '" . $row[0] . "'
                     and record_time = '" . $row3[0] . "'";
        $result2 = mysqli_query($link, $query2);
        $row2    = mysqli_fetch_row($result2);
        return array(
            $row2[0],
            $row2[1],
            $row2[2]
        );
    }
    public function getWeight($pigid)
    {
        $link    = $this->connect();
        $query   = "SELECT max(record_date)
                    FROM weight_record 
                    WHERE pig_id = '" . $pigid . "'";
        $result  = mysqli_query($link, $query);
        $row     = mysqli_fetch_row($result);
        $query3   = "SELECT max(record_time)
                    FROM weight_record 
                    WHERE pig_id = '" . $pigid . "' and
                    record_date = '".$row[0]."'";
        $result3  = mysqli_query($link, $query3);
        $row3     = mysqli_fetch_row($result3);
        $query2  = "SELECT weight,
                        record_id,
                        remarks 
                    FROM weight_record 
                    WHERE pig_id = '" . $pigid . "'
                    AND record_date = '" . $row[0] . "' 
                    and record_time = '" . $row3[0] . "'";
        $result2 = mysqli_query($link, $query2);
        $row2    = mysqli_fetch_row($result2);
        return array(
            $row2[0],
            $row2[1],
            $row2[2]
        );
    }
    public function getBoar($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT boar_id 
                    FROM pig 
                    WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return array(
            $row[0]
        );
    }
    public function getSow($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT sow_id 
                    FROM pig 
                    WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return array(
            $row[0]
        );
    }
    public function getFosterSow($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT boar_id 
                    FROM pig 
                    WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getCurrentHouse($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT h.house_no 
                    FROM pig pi 
                        INNER JOIN pen p 
                            ON p.pen_id = pi.pen_id 
                        INNER JOIN house h 
                            ON h.house_id = p.house_id 
                        WHERE pi.pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row2   = mysqli_fetch_row($result);
        echo $row2[0];
    }
    public function getCurrentPen($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT p.pen_no 
                    FROM pig pi 
                        INNER JOIN pen p 
                            ON p.pen_id = pi.pen_id 
                    WHERE pi.pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row2   = mysqli_fetch_row($result);
        echo $row2[0];
    }
    public function getLastFeed($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT f.feed_name, 
                        f.feed_type, 
                        max(ft.date_given) 
                    FROM feeds f 
                        INNER JOIN feed_transaction ft 
                            ON ft.feed_id = f.feed_id 
                    WHERE ft.pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row2   = mysqli_fetch_row($result);
        $last   = $row2[0] . "-" . $row2[1];
        return $last;
    }
    public function getLastMed($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT m.med_name, 
                        m.med_type, 
                        max(mr.date_given) 
                    FROM medication m 
                        INNER JOIN med_record mr 
                            ON mr.med_id = m.med_id 
                    WHERE mr.pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row2   = mysqli_fetch_row($result);
        $last   = $row2[0] . "-" . $row2[1];
        return $last;
    }
    public function ddl_locations($pig)
    {
        $link     = $this->connect();
        $query    = "SELECT m.date_moved, 
                        m.time_moved, 
                        m.pen_id,
                        p.pen_no 
                    FROM movement m 
                        inner join pen p 
                            on p.pen_id = m.pen_id 
                    WHERE m.pig_id = '".$pig."'
                    ORDER BY m.date_moved desc, 
                            m.time_moved desc";
        $result   = mysqli_query($link, $query);
        $locs     = array();
        $arr_locs = array();
        while ($row = mysqli_fetch_row($result)) {
            $pd                 = date('F d, Y', strtotime($row[0]));
            $locs['date_moved'] = $pd;
            $locs['time_moved'] = $row[1];
            $locs['pen_id']     = $row[2];
            $locs['pen_no']     = $row[3];
            $arr_locs[]         = $locs;
        }
        return $arr_locs;
    }
    public function ddl_inactiveRFID()
    {
        $link   = $this->connect();
        $query  = "SELECT tag_rfid, 
                        tag_id 
                    FROM rfid_tags 
                    WHERE status = 'inactive'";
        $result = mysqli_query($link, $query);
        $rfid   = array();
        $arr    = array();
        while ($row = mysqli_fetch_row($result)) {
            $rfid['rfid']   = $row[0];
            $rfid['tag_id'] = $row[1];
            $arr[]          = $rfid;
        }
        return $arr;
    }
    public function ddl_feedRecordEdit($pig)
    {
        $link      = $this->connect();
        $query     = "SELECT f.feed_name, 
                            f.feed_type, 
                            ft.prod_date, 
                            ft.ft_id 
                    FROM feeds f 
                        INNER JOIN feed_transaction ft 
                                ON ft.feed_id = f.feed_id 
                    WHERE ft.pig_id = '" . $pig . "'
                    order by ft.ft_id asc";
        $result    = mysqli_query($link, $query);
        $frcrd     = array();
        $arr_frcrd = array();
        while ($row = mysqli_fetch_row($result)) {
            $frcrd['fname']    = $row[0];
            $frcrd['ftype']    = $row[1];
            $pd                = date('F d, Y', strtotime($row[2]));
            $frcrd['proddate'] = $pd;
            $frcrd['ft_id']    = $row[3];
            $arr_frcrd[]       = $frcrd;
        }
        return $arr_frcrd;
    }
    public function ddl_medRecordEdit($pig)
    {
        $link      = $this->connect();
        $query     = "SELECT m.med_name, 
                        m.med_type, 
                        mr.mr_id 
                    FROM medication m 
                        INNER JOIN med_record mr 
                            ON mr.med_id = m.med_id 
                    WHERE mr.pig_id = '" . $pig . "'";
        $result    = mysqli_query($link, $query);
        $mrcrd     = array();
        $arr_mrcrd = array();
        while ($row = mysqli_fetch_row($result)) {
            $mrcrd['mname'] = $row[0];
            $mrcrd['mtype'] = $row[1];
            $mrcrd['mr_id'] = $row[2];
            $arr_mrcrd[]    = $mrcrd;
        }
        return $arr_mrcrd;
    }
    public function ddl_feedRecord($pig)
    {
        $link      = $this->connect();
        $query     = "SELECT f.feed_name, 
                        f.feed_type, 
                        ft.prod_date, 
                        ft.ft_id,
                        ft.quantity,
                        ft.unit,
                        ft.date_given 
                    FROM feeds f 
                        INNER JOIN feed_transaction ft 
                            ON ft.feed_id = f.feed_id 
                    WHERE ft.pig_id = '" . $pig . "'";
        $result    = mysqli_query($link, $query);
        $frcrd     = array();
        $arr_frcrd = array();
        while ($row = mysqli_fetch_row($result)) {
            $frcrd['fname']      = $row[0];
            $frcrd['ftype']      = $row[1];
            $pd                  = date('F d, Y', strtotime($row[2]));
            $frcrd['proddate']   = $pd;
            $frcrd['ft_id']      = $row[3];
            $date                = date('F d, Y', strtotime($row[4]));
            $frcrd['date_given'] = $date;
            $frcrd['qty'] = $row[4]." ".$row[5];
            $arr_frcrd[]         = $frcrd;
        }
        return $arr_frcrd;
    }
    public function ddl_medRecord($pig)
    {
        $link      = $this->connect();
        $query     = "SELECT m.med_name, 
                            m.med_type, 
                            mr.mr_id, 
                            mr.date_given,
                            mr.quantity,
                            mr.unit
                    FROM medication m 
                        INNER JOIN med_record mr 
                            ON mr.med_id = m.med_id 
                    WHERE mr.pig_id = '" . $pig . "'";
        $result    = mysqli_query($link, $query);
        $mrcrd     = array();
        $arr_mrcrd = array();
        while ($row = mysqli_fetch_row($result)) {
            $mrcrd['mname']      = $row[0];
            $mrcrd['mtype']      = $row[1];
            $mrcrd['mrid']       = $row[2];
            $date                = date('F d, Y', strtotime($row[3]));
            $mrcrd['date_given'] = $date;
            $mrcrd['qty'] = $row[4]." ".$row[5];
            $arr_mrcrd[]         = $mrcrd;
        }
        return $arr_mrcrd;
    }
    public function ddl_pigpen($pig, $pen, $house, $location)
    {
        $link     = $this->connect();
        $query    = "SELECT rt.label, 
                        p.pig_id 
                    FROM  rfid_tags rt 
                        INNER JOIN pig p 
                            ON p.pig_id = rt.pig_id 
                        INNER JOIN pen pe 
                            ON pe.pen_id = p.pen_id 
                        INNER JOIN house h 
                            ON h.house_id = pe.house_id 
                    WHERE p.pen_id  = '" . $pen . "'
                    AND p.pig_id != $pig 
                    AND h.house_id = $house";
        $result   = mysqli_query($link, $query);
        $info     = "info";
        $ppen     = array();
        $arr_ppen = array();
        while ($row = mysqli_fetch_row($result)) {
            $ppen['label'] = $row[0];
            $ppen['pid']   = $row[1];
            $arr_ppen[]    = $ppen;
        }
        return $arr_ppen;
    }
   
    public function ddl_pigpenall($pig, $pen, $house, $location)
    {
        $link     = $this->connect();
        $query    = "SELECT rt.label, 
                            p.pig_id 
                    FROM  rfid_tags rt 
                        INNER JOIN pig p 
                            ON p.pig_id = rt.pig_id 
                        INNER JOIN pen pe 
                            ON pe.pen_id = p.pen_id 
                        INNER JOIN house h 
                            ON h.house_id = pe.house_id 
                    WHERE p.pen_id  = '" . $pen . "'
                    AND h.house_id = $house";
        $result   = mysqli_query($link, $query);
        $info     = "info";
        $ppen     = array();
        $arr_ppen = array();
        while ($row = mysqli_fetch_row($result)) {
            $ppen['label'] = $row[0];
            $ppen['pid']   = $row[1];
            $arr_ppen[]    = $ppen;
        }
        return $arr_ppen;
    }
    public function ddl_medications()
    {
        $link    = $this->connect();
        $query   = "SELECT med_id, med_name, med_type FROM medication";
        $result  = mysqli_query($link, $query);
        $meds    = array();
        $med_arr = array();
        while ($row = mysqli_fetch_row($result)) {
            $meds['med_id']   = $row[0];
            $meds['med_name'] = $row[1];
            $meds['med_type'] = $row[2];
            $med_arr[]        = $meds;
        }
        return $med_arr;
    }
    public function ddl_nextPig()
    {
        $link     = $this->connect();
        $search   = "SELECT max(p.pig_id) FROM pig p ";
        $resultq  = mysqli_query($link, $search);
        $npig     = array();
        $npig_arr = array();
        while ($row = mysqli_fetch_row($resultq)) {
            $pid        = $row[0];
            $nextPig    = $pid + 1;
            $lenNextPig = strlen($nextPig);
            $new        = "0";
            $totLen     = 4 - $lenNextPig;
            for ($a = 0; $a < $totLen - 1; $a++) {
                $new = $new . "0";
            }
            $new            = $new . "$nextPig";
            $npig['newpid'] = $new;
            $npig['nxtpig'] = $nextPig;
            $npig_arr[]     = $npig;
        }
        return $npig_arr;
    }
    public function ddl_newRFID()
    {
        $link    = $this->connect();
        $search  = "SELECT tag_rfid,tag_id FROM rfid_tags WHERE status = 'inactive' ";
        $resultq = mysqli_query($link, $search);
        $rfid    = array();
        $newrfid = array();
        while ($row = mysqli_fetch_row($resultq)) {
            $rfid['tag_id']   = $row[1];
            $rfid['tag_rfid'] = $row[0];
            $newrfid[]        = $rfid;
        }
        return $newrfid;
    }
    public function ddl_breeds()
    {
        $link     = $this->connect();
        $search   = "SELECT breed_id,breed_name FROM pig_breeds";
        $resultq  = mysqli_query($link, $search);
        $breed    = array();
        $breedArr = array();
        while ($row = mysqli_fetch_row($resultq)) {
            $breed['brid']   = $row[0];
            $breed['brname'] = $row[1];
            $breedArr[]      = $breed;
        }
        return $breedArr;
    }
    public function getUserEdited($pigid)
    {
        $link   = $this->connect();
        $query  = "SELECT user FROM pig WHERE pig_id = '" . $pigid . "'";
        $result = mysqli_query($link, $query);
        $row    = mysqli_fetch_row($result);
        return $row[0];
    }
}