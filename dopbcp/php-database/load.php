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
    if (isset($_POST['dopbcp_calendar_id'])){ // If calendar ID is received.
        require_once 'opendb.php';
//$_POST['dopbcp_calendar_id']=23; // need to remove
// Select and show the data from the database.    
    
        $query = mysqli_query($conn, "SELECT * FROM `schedule` WHERE id=".$_POST['dopbcp_calendar_id']); 
        $result = mysqli_fetch_array($query);
        echo $result['data'];
    } } else {
		
		if (isset($_POST['dopbcp_calendar_id'])){ // If calendar ID is received.
        require_once 'opendb.php';

// Select and show the data from the database.    
    
        $query = mysqli_query($conn, "SELECT * FROM `schedule` WHERE id=".$_POST['dopbcp_calendar_id']); 
        $result = mysqli_fetch_array($query);
        echo $result['data'];
    }
		
	}
    
?> 