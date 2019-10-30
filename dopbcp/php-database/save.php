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
 if ($_POST['service_calender_id']==1){
		
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
	
	if (isset($_POST['dopbcp_calendar_id'])){ // If calendar ID is received.
        require_once 'opendb.php';
    
// Test if calendar is added to the database.        
        $query = mysqli_query($conn, 'SELECT * FROM schedule WHERE id="'.$_POST['dopbcp_calendar_id'].'"');

			
			$propId = $_POST['dopbcp_calendar_id'];
			$values = json_decode($_POST['dopbcp_schedule']);
			$dat_arr = get_object_vars($values);
			
			
        $count=mysqli_num_rows($query);
        if ($count>0){
// Update if calendar already in the database.            
            mysqli_query($conn, "UPDATE schedule SET data='".$_POST['dopbcp_schedule']."' WHERE id=".$_POST['dopbcp_calendar_id']);
			
			foreach($dat_arr as $key=>$val)
				{
					if($val->status == 'booked')
						{  
						  $query1 = mysqli_query($conn, 'SELECT * FROM bookings WHERE PropId="'.$propId.'" and the_date ="'.$key.'" ');
						  $num_rows = mysqli_num_rows($query1);
						  if($num_rows == 0)
						  	{
							$query = "INSERT INTO  `bookings` (  `PropId` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$propId.", '".$key."',1,1)";
							mysqli_query($conn, $query);
							}else{
								$query = "delete from `bookings` where  `PropId`=".$propId." and `the_date`='".$key."'";
								mysqli_query($conn, $query);
								
								$query = "INSERT INTO  `bookings` (  `PropId` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$propId.", '".$key."',1,1)";
								mysqli_query($conn, $query);
							}
						}else if($val->status == 'available'){
							$query = "delete from `bookings` where  `PropId`=".$propId." and `the_date`='".$key."'";
							mysqli_query($conn, $query);
						}else if ($val->status == 'unavailable'){
							$query = "delete from `bookings` where  `PropId`=".$propId." and `the_date`='".$key."'";
							mysqli_query($conn, $query);
							
							$query = "INSERT INTO  `bookings` (  `PropId` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$propId.", '".$key."',4,1)";
							mysqli_query($conn, $query);
						}
				}
        }
        else{
// Insert calendar in the database if it doesn't exist.   

            mysqli_query($conn, "INSERT INTO  `schedule` (  `id` ,  `data` ) VALUES (".$_POST['dopbcp_calendar_id'].", '".$_POST['dopbcp_schedule']."')");
			
			foreach($dat_arr as $key=>$val)
				{
					//echo $key.'<br/>'; die;
						if($val->status == 'booked')
						{
							$query = "delete from `bookings` where  `PropId`=".$propId." and `the_date`='".$key."'";
							mysqli_query($conn, $query);
							
							$query = "INSERT INTO  `bookings` (  `PropId` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$propId.", '".$key."',1,1)";
							mysqli_query($conn, $query);
						}else if ($val->status == 'unavailable'){
						
							$query = "delete from `bookings` where  `PropId`=".$propId." and `the_date`='".$key."'";
							mysqli_query($conn, $query);
							
							$query = "INSERT INTO  `bookings` (  `PropId` ,  `the_date` , `id_state` ,`id_item` ) VALUES (".$propId.", '".$key."',4,1)";
							mysqli_query($conn, $query);
						}
					//echo $query;die;
				}
				
        }
    }
	
	
}
    
?>