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
//print_r($_POST); exit;

/*PLEASE NOTE, NO POST['service_calender_id'] IS AVAILABLE WHEN BOOK FROM ADMIN PANEL. IF ADMIN BLOCKED IT WILL DIRECTLY GO TO ELSE PART */
 if ($_POST['service_calender_id']==1){
		//echo 'if'; exit;
		if (isset($_POST['dopbcp_calendar_id'])){ // If calendar ID is received.
        require_once 'opendb.php';
    
// Test if calendar is added to the database.        
        $query = mysqli_query($conn, 'SELECT * FROM schedule WHERE service_id="'.$_POST['dopbcp_calendar_id'].'"');

			
			$serviceId = $_POST['dopbcp_calendar_id'];
			$values = json_decode($_POST['dopbcp_schedule']);
			$dat_arr = get_object_vars($values);
			
			$count=mysqli_num_rows($query);
        if ($count>0){
// Update if calendar already in the database.            
            mysqli_query($conn, "UPDATE schedule SET data='".$_POST['dopbcp_schedule']."' WHERE service_id=".$serviceId);
			mysqli_query($conn, "UPDATE fc_product SET calendar_checked='sometimes' WHERE id=".$serviceId);
			echo "UPDATE schedule SET data='".$_POST['dopbcp_schedule']."' WHERE service_id=".$serviceId;
			
			foreach($dat_arr as $key=>$val)
				{
					if($val->status == 'booked')
						{  
						  $query1 = mysqli_query($conn, 'SELECT * FROM bookings WHERE service_id="'.$serviceId.'" and the_date ="'.$key.'" ');
						  $num_rows = mysqli_num_rows($query1);
						  if($num_rows == 0)
						  	{
							$query = "INSERT INTO  `bookings` (  `service_id` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$serviceId.", '".$key."',1,1)";
							mysqli_query($conn, $query);
							}else{
								$query = "delete from `bookings` where  `service_id`=".$serviceId." and `the_date`='".$key."'";
								mysqli_query($conn, $query);
								
								$query = "INSERT INTO  `bookings` (  `service_id` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$serviceId.", '".$key."',1,1)";
								mysqli_query($conn, $query);
							}
						}else if($val->status == 'available'){
							$query = "delete from `bookings` where  `service_id`=".$serviceId." and `the_date`='".$key."'";
							mysqli_query($conn, $query);
						}else if ($val->status == 'unavailable'){
							$query = "delete from `bookings` where  `service_id`=".$serviceId." and `the_date`='".$key."'";
							mysqli_query($conn, $query);
							
							$query = "INSERT INTO  `bookings` (  `service_id` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$serviceId.", '".$key."',4,1)";
							mysqli_query($conn, $query);
						}
				}
        }
        else{
// Insert calendar in the database if it doesn't exist.   

            mysqli_query($conn, "INSERT INTO  `schedule` (  `service_id` ,  `data` ) VALUES (".$_POST['dopbcp_calendar_id'].", '".$_POST['dopbcp_schedule']."')");
			
			echo "INSERT INTO  `schedule` (  `service_id` ,  `data` ) VALUES (".$_POST['dopbcp_calendar_id'].", '".$_POST['dopbcp_schedule']."')";
			
			foreach($dat_arr as $key=>$val)
				{
					//echo $key.'<br/>'; die;
						if($val->status == 'booked')
						{
							$query = "delete from `bookings` where  `service_id`=".$serviceId." and `the_date`='".$key."'";
							mysqli_query($conn, $query);
							
							$query = "INSERT INTO  `bookings` (  `service_id` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$serviceId.", '".$key."',1,1)";
							mysqli_query($conn, $query);
						}else if ($val->status == 'unavailable'){
						
							$query = "delete from `bookings` where  `service_id`=".$serviceId." and `the_date`='".$key."'";
							mysqli_query($conn, $query);
							
							$query = "INSERT INTO  `bookings` (  `service_id` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$serviceId.", '".$key."',4,1)";
							mysqli_query($conn, $query);
						}
					//echo $query;die;
				}
				
        }
    }
    
}else {
	/* AVAILABLE = Array([dopbcp_calendar_id] => 3 [dopbcp_schedule] =>{"2018-08-30":{"available":"1","bind":0,"info":"","notes":"","price":"100","promo":"","selectedTiming":["16:00-18:00","18:00-23:00"],"status":"available"},"2018-08-31":{"available":"1","bind":0,"info":"","notes":"","price":"100","promo":"","selectedTiming":["16:00-18:00","18:00-23:00"],"status":"available"}})
	BOOKED = Array ( [dopbcp_calendar_id] => 3 [dopbcp_schedule]  =>{"2018-08-30":{"available":"1","bind":0,"info":"","notes":"","price":"100","promo":"","selectedTiming":["16:00-18:00","18:00-23:00"],"status":"booked"},"2018-08-31":{"available":"1","bind":0,"info":"","notes":"","price":"100","promo":"","selectedTiming":["16:00-18:00","18:00-23:00"],"status":"booked"}} ) 
	Array ( [dopbcp_calendar_id] => 3 [dopbcp_schedule] => {"2018-08-30":{"available":"","bind":0,"info":"","notes":"","price":"","promo":"","selectedTiming":["16:00-18:00","18:00-23:00"],"status":"unavailable"},"2018-08-31":{"available":"","bind":0,"info":"","notes":"","price":"","promo":"","selectedTiming":["16:00-18:00","18:00-23:00"],"status":"unavailable"}} ) 
	
	WHEN USE $dat_arr = get_object_vars($values); FOLLOWING OUT PUT WILL DISPLAY
	Array ( [2018-08-30] => stdClass Object ( [available] => 1 [bind] => 0 [info] => [notes] => [price] => 100 [promo] => [selectedTiming] => Array ( [0] => 2018-08-30~3~16:00~18:00 ) [status] => available ) )  
	
	id_state==1 ==> booked  id_state ==> unavailable
	*/
	//echo 'else';exit;
	if (isset($_POST['dopbcp_calendar_id'])){ 
		require_once 'opendb.php';
		$propId = $_POST['dopbcp_calendar_id'];
		$values = json_decode($_POST['dopbcp_schedule']);
		$dat_arr = get_object_vars($values);
		///print_r($dat_arr); echo '<hr>'; print_r($this->input->post());exit;
		foreach($dat_arr as $key=>$val)
		{
			foreach($val->selectedTiming as $sel_time)
			{
				$selected_time=$sel_time;
				$explode_selected_time=explode('~',$selected_time);
				$got_hall_id = $explode_selected_time[0];
				$hall_query= mysqli_query($conn, 'SELECT hall_id FROM fc_rest_hall_timing WHERE id="'.$got_hall_id.'" ');
				$num_rows = mysqli_num_rows($hall_query);
				$row=mysqli_fetch_array($hall_query,MYSQLI_NUM);
				//printf ("%s (%s)\n",$row[0],$row[1]);
				$hall_id = $row[0];
				$checked_in = $explode_selected_time[1];
				$checked_out = $explode_selected_time[2];
				$tot_checked_in = $key.' '.date('H:i:s',strtotime($checked_in));
				$tot_checked_out = $key.' '.date('H:i:s',strtotime($checked_out));
				$tot_time = $tot_checked_in.'-'.$tot_checked_out;
				if($val->status == 'booked'){ $id_stateIs = '1'; } 
				elseif($val->status == 'available'){ $id_stateIs = '2'; } 
				elseif($val->status == 'unavailable'){ $id_stateIs = '4'; } 
				$query1 = mysqli_query($conn, 'SELECT * FROM fc_rest_bookings_dates WHERE rest_id="'.$propId.'" AND hall_id="'.$hall_id.'" AND the_date ="'.$key.'" AND checked_in="'.$checked_in.'"');
				$num_rows = mysqli_num_rows($query1);
				if($num_rows == 0)
				{
					$query = "INSERT INTO  fc_rest_bookings_dates (id_item, the_date, id_state, rest_type, rest_id, hall_id, price, checked_in, checked_out, tot_checked_in, tot_checked_out, tot_time, added_by) VALUES ('1','".$key."', '".$id_stateIs."', '6', '".$propId."', '".$hall_id."', '".$val->price."', '".$checked_in."', '".$checked_out."', '".$tot_checked_in."', '".$tot_checked_out."', '".$tot_time."','admin')";
					echo $query;
					mysqli_query($conn, $query);
				}
				else
				{
					$query = "UPDATE fc_rest_bookings_dates SET price='".$val->price."',id_state='".$id_stateIs."' WHERE the_date='".$key."' AND rest_id='".$propId."' AND hall_id='".$hall_id."' AND checked_in='".$checked_in."' ";
					//echo $query; exit;
					mysqli_query($conn, $query);
				}
					
				
			}
		}
	}
	
	
}
    
?>