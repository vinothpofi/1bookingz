<?php

/*
* Title                   : Booking Calendar PRO (jQuery Plugin)
* Version                 : 1.2
* File                    : load.php
* File Version            : 1.0
* Created / Last Modified : 20 May 2013
* Author                  : Dot on Paper
* Copyright               : © 2011 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Load booking data from database.
*/ 

	if ($_POST['dopbcp_calendar_id']!=0){
		//print_r($_POST); exit;Array ( [dopbcp_calendar_id] => 3 ) 
		if (isset($_POST['dopbcp_calendar_id'])){ // If calendar ID is received.
			require_once 'opendb.php';
			
		$pro_id=$_POST['dopbcp_calendar_id'];
		$json_array = array();
		$query2 = mysqli_query($conn, "SELECT * FROM `fc_rest_bookings_dates` WHERE rest_id=".$pro_id." AND checked_in <> '' GROUP BY the_date");
		$num_rows = mysqli_num_rows($query2);
		if($num_rows > 0 )
		{
			$rows_res = resultToArray($query2);
			foreach($rows_res  as $s){
				$value=array();
				$datee = $s['the_date'];
				$query3 = mysqli_query($conn, "SELECT * FROM `fc_rest_bookings_dates` WHERE rest_id=".$pro_id." AND the_date = '".$s['the_date']."' ");
				$rows_res3 = resultToArray($query3);
				$notes_array = array();
				foreach($rows_res3 as $rs3)
				{
					if($rs3['id_state']==1) { $status='booked'; } elseif($rs3['id_state']==2) { $status='available'; } elseif($rs3['id_state']==4) { $status='unavailable'; } else { $status=''; } 
					array_push($notes_array,$status);
				}
				
				if($s['id_state']==1) { $status='booked'; } elseif($s['id_state']==2) { $status='available'; } elseif($s['id_state']==4) { $status='unavailable'; } else { $status=''; } 
				$json_array[$s['the_date']] = array('available' => 1, 'bind' => 0, 'info' => '','notes'=> implode(",",array_unique($notes_array)),'price' => $s['price'], 'promo' =>'','status'=>$status);
			}
			$rest_hall_query = mysqli_query($conn, "SELECT * FROM `fc_rest_hall_timing` WHERE rest_id=".$pro_id."");
			$num_rows_hall = mysqli_num_rows($rest_hall_query);
			//echo $num_rows_hall.'<bR>';
			
			$booked_query = mysqli_query($conn, "SELECT count(*) as NumRows,the_date FROM `fc_rest_bookings_dates` WHERE rest_id=".$pro_id." AND id_state=1 AND added_by='user' GROUP BY `the_date`");
			$num_rows_booked = mysqli_num_rows($booked_query);
			$rows_booked_res = resultToArray($booked_query);
			//print_r($rows_booked_res);
			foreach($rows_booked_res  as $buked_res){
				if($buked_res['NumRows']==$num_rows_hall)
				{
					$json_array[$buked_res['the_date']] = array('available' => 1, 'bind' => 0, 'info' => '','notes'=> '','price' => '', 'promo' =>'','status'=>'all_booked');
				}
			}
			
		}
		echo json_encode($json_array);
		//echo '{"2018-08-28":{"available":"1","bind":0,"info":"","notes":"","price":"10","promo":"","status":"available"},"2018-08-29":{"available":"1","bind":0,"info":"","notes":"","price":"10","promo":"","status":"available"},"2018-09-03":{"available":"1","bind":0,"info":"","notes":"","price":"10","promo":"","status":"available"},"2018-08-26":{"available":"1","bind":0,"info":"","notes":"","price":"10","promo":"","status":"available"},"2018-08-30":{"available":"1","bind":0,"info":"","notes":"","price":"70","promo":"","status":"booked"},"2018-08-31":{"available":"1","bind":0,"info":"","notes":"","price":"70","promo":"","status":"booked"}}';
		} 
	} else {
		//echo 'else';exit;
		if (isset($_POST['dopbcp_calendar_id'])){ // If calendar ID is received.
			require_once 'opendb.php';

			// Select and show the data from the database.    

			$query = mysqli_query($conn, "SELECT * FROM `schedule` WHERE id=".$_POST['dopbcp_calendar_id']); 
			$result = mysqli_fetch_array($query);
			
			echo $result['data'];
		}

	}
	function createRange($start, $end, $format = 'Y-m-d') {
		$start  = new DateTime($start);
		$end    = new DateTime($end);
		$invert = $start > $end;

		$dates = array();
		$dates[] = $start->format($format);
		while ($start != $end) {
			$start->modify(($invert ? '-' : '+') . '1 day');
			$dates[] = $start->format($format);
		}
		//print_r($dates); exit;
		return $dates;
	}
	function resultToArray($result_1) {
		$row_r = array();
		while($row5 = mysqli_fetch_assoc($result_1)) {
			//print_r($row);
			$row_r[] = $row5;
		}
		return $row_r;
	}
    
?> 