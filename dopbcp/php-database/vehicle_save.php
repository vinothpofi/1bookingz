<?php

/*
* Title                   : Booking Calendar PRO (jQuery Plugin)
* Version                 : 1.2
* File                    : save.php
* File Version            : 1.0
* Created / Last Modified : 20 May 2013
* Author                  : Dot on Paper
* Copyright               : © 2011 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Save booking data in database.
*/

	require_once 'opendb.php';
	$propId = $_POST['dopbcp_calendar_id'];
	$values = json_decode($_POST['dopbcp_schedule']);
	$blocking_type = $_POST['blocking_type'];
	$vehicle_type = $_POST['vehicle_type'];
	$user_id = $_POST['user_id'];
	$dat_arr = get_object_vars($values);
	if($blocking_type=='daily')
	{
		foreach($dat_arr as $key=>$val)
		{
			$dateIs=$key;
			$insertDate = date('Y-m-d H:i:s',strtotime($dateIs));
			$availalbeStatus = $val->available;
			$checkedOut = date('Y-m-d 23:00:00',strtotime($insertDate));
			$tot = $insertDate.'-'.$checkedOut;
			if($availalbeStatus==0 || $availalbeStatus==2)
			{
				if($availalbeStatus==0) { $id_state = '4'; } if($availalbeStatus==2) { $id_state = '1'; } 
				$query = "INSERT INTO  `fc_vehicle_bookings_dates` (  `vehicle_type`,`vehicle_id` ,  `the_date` , `id_state` ,`id_item`,`checked_in`,`checked_out`,`tot_checked_in`,`tot_checked_out`,`tot_time`,`added_by`,`added_userid` ) VALUES (".$vehicle_type.",".$propId.", '".$key."',".$id_state.",1,'00:00','23:00','".$insertDate."','".$checkedOut."','".$tot."','host',".$user_id.")";
				mysqli_query($conn, $query);
			}

			else
			{
				$query = "delete from `fc_vehicle_bookings_dates` where `vehicle_id`=".$propId." and `the_date`='".$key."' AND (id_state = '1' OR id_state = '4') AND id_booking = '0'";
				mysqli_query($conn, $query);
			}
			
		}
		//exit;
	}
	else
	{
		$startTime = '';
		foreach($dat_arr as $key=>$val)
		{
			$dateIs=$key;
			$availalbeStatus = $val->available;
			if($availalbeStatus==0 || $availalbeStatus==2)
			{
				if($availalbeStatus==0) { $id_state = '4'; } if($availalbeStatus==2) { $id_state = '1'; } 
				foreach($val as $key1=>$res)
				{
					if($key1!='available' && $key1!='bind' && $key1!='info' && $key1!='notes' && $key1!='price' && $key1!='promo' && $key1!='status')
					{
						//echo $key1.'==';
						//echo $res->time_status.'<br>';
						if($res->time_status=='unavailable' || $res->time_status=='booked')
						{
							if($startTime=='')
							{
								$startTime = $key1;
							}
							$endTime = $key1;
						}
					}
				}
				$insertDate = $dateIs." ".$startTime;
				$insertDate = date('Y-m-d H:i:s',strtotime($insertDate));
				$checkedOut = $dateIs." ".$endTime;
				$checkedOut = date('Y-m-d H:i:s',strtotime($checkedOut));
				$tot = $insertDate.'-'.$checkedOut;
				$query = "INSERT INTO  `fc_vehicle_bookings_dates` (  `vehicle_type`,`vehicle_id` ,  `the_date` , `id_state` ,`id_item`,`checked_in`,`checked_out`,`tot_checked_in`,`tot_checked_out`,`tot_time`,`added_by`,`added_userid` ) VALUES (".$vehicle_type.",".$propId.", '".$key."',".$id_state.",1,'".$startTime."','".$endTime."','".$insertDate."','".$checkedOut."','".$tot."','host',".$user_id.")";
				//echo $query;
				mysqli_query($conn, $query);
			}
			else
			{
				$query = "delete from `fc_vehicle_bookings_dates` where `vehicle_id`=".$propId." and `the_date`='".$key."' AND (id_state = '1' OR id_state = '4') AND id_booking = '0'";
				mysqli_query($conn, $query);
			}
		}
	}
	echo '1';
	//exit;
  
?>