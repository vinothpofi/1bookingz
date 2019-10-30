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
   //  date_default_timezone_set ("Europe/Amsterdam");
   
	if (isset($_POST['dopbcp_calendar_id'])){ // If calendar ID is received.
		require_once 'opendb.php';

		// Select and show the data from the database.    

		//$query = mysqli_query($conn, "SELECT * FROM `schedule` WHERE id=".$_POST['dopbcp_calendar_id']); 
		//$result = mysqli_fetch_array($query);
		//$result=array();
		//print_r($result);

		$pro_id=$_POST['dopbcp_calendar_id'];

		$query2 = mysqli_query($conn, "SELECT * FROM `fc_vehicle_bookings_dates` WHERE vehicle_id=".$pro_id." AND tot_checked_in <> ''"); 
		//echo "SELECT * FROM `fc_vehicle_bookings_dates` WHERE vehicle_id=".$pro_id." AND tot_checked_in <> ''"; exit;
		// $res = mysqli_fetch_array($query2);
		//print_r($res);
		$rows_res = resultToArray($query2);
		//print_r($rows);
		//$res=$this->product_model->get_all_details(CALENDARBOOKING,array('PropId'=>$pro_id));
		$dateeee=array();
		if(!empty($rows_res)) {
			$datee = '';
			$stime = '';
			$etime = '';
			$timee = '';
			$wholedt = '';
			$dayArr1=array();
			$dayArr2=array();

			//print_r($rows_res);

			foreach($rows_res  as $date){
				//print_r($date);

				$start=$date['tot_checked_in'];
				$startDate=date('Y-m-d',strtotime($start));
				$startTime=date('H:i',strtotime($start));
				$end=$date['tot_checked_out'];
				$endDate=date('Y-m-d',strtotime($end));
				$endTime=date('H:i',strtotime($end));
				//echo "<pre>"; echo "endTime"; print_r($endTime);
				
				$datesbetween=createRange($startDate, $endDate, $format = 'Y-m-d');

				//print_r($datesbetween);exit;

				foreach($datesbetween as $day){

					if(count($datesbetween) == 1 ){	
						$datee=$day;
						$timee= $startTime.'' . '-' . ''.$endTime;
					}else{

						if ($day==$startDate){

							$datee = $day;
							$timee= $startTime.'' .  '-' . ''.'23:00' ;
						}else if ($day==$endDate){

							$datee =$day;
							$timee='00:00'.'' .  '-' . ''.$endTime ;
						}
						else{
							$datee = $day;	
							$timee='00:00'.'' .  '-' . ''.'23:00';
						}	
					} 

					$value=array();

					if(in_array($datee, array_column($dateeee, 'date'))) { // search value in the array
						$key = array_search($datee, array_column($dateeee, 'date'));
						//$value = $dateeee[$key]['time'];//
						//echo $value;
						$value[]=$timee;
						$dateeee[$key]=array('date'=>$datee,'time'=>$value);	
					}else{
						$dateeee[]=array('date'=>$datee,'time'=>array($timee));
					}
				}

			}

		}


		$final=array('data_s'=>array(),'time_schedule'=>json_encode($dateeee));

		$final2=json_encode($final);
		//echo $result['data'];
		//$array_final = preg_replace('/"([a-zA-Z]+[a-zA-Z0-9_]*)":/','$1:',$final2);
		echo $final2;

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