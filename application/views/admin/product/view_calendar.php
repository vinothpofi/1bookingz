<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/admin/jquery.dop.BackendBookingCalendarPRO.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css" />

<script type="text/JavaScript" src="<?php echo base_url();?>js/jquery-latest.js"></script>

<script type="text/JavaScript" src="<?php echo base_url();?>js/admin/jquery.dop.BackendBookingCalendarPRO.js"></script>



<script type="text/JavaScript">

	$(document).ready(function(){

		localStorage.setItem("room_type",'null');

		localStorage.setItem("home_type",'null');

		localStorage.setItem("accommodates",'null');



		localStorage.setItem("location",'');

		$("#backend").DOPBackendBookingCalendarPRO({

		"ID": '<?php echo $ViewList['rental_id']; ?>',

		"DataURL": "<?php echo base_url();?>dopbcp/php-database/load.php",

		"SaveURL": "<?php echo base_url();?>dopbcp/php-database/save.php"

		});





		$("#backend").DOPBackendBookingCalendarPRO({"DataURL": "dopbcp/php-database/load.php",

		"SaveURL": "dopbcp/php-database/save.php"});



		$("#backend-refresh").click(function(){

		$("#backend").DOPBackendBookingCalendarPRO({"Reinitialize": true});



		$("#backend").DOPBackendBookingCalendarPRO({"Reinitialize": true,

		"DataURL": "dopbcp/php-database/load.php",

		"SaveURL": "dopbcp/php-database/save.php"});

		});

	});

	

	

</script>

        <input type="hidden" value="<?php echo $ViewList['price']; ?>" name="comprice" id="comprice">



        <input type="hidden" value="<?php echo $ViewList['currency']; ?>" name="currency" id="currency">

</head>

<body>

<div class="calender-top">

					<div class="col-xs-12 calender-top-left">

						<div class="calender-left-arrow"></div>

						

						<div class="calender-month" id="selected_month_year">

						

						

						<?php echo date('F Y');?>

						

						</div>

						

						<div class="calender-right-arrow" style="cursor:pointer;"></div>

					</div>

					

					<div class="col-xs-12 calender-top-right">

						<ul>

							<li><span class="green-circle"></span>Speacial Price</li>

							<li><span class="white-circle"></span>Booked</li>

							<li><span class="gray-circle"></span>UnAvailable</li>

						</ul>

					</div>

					

				</div>

<div id="wrapper">



<div id="backend-container">

<div id="backend"></div>

</div>

</div>

</body>

<script>

$(function(){

	$('.calender-left-arrow').css('opacity',0.1);

	setTimeout(function() {

       available_status();

    }, 2000);

	

})

	

function available_status()

	{

		

       /** available status **/

	  

		

		$('.avail-middle').each(function(){

		var available_status=$(this).parent().next().attr('class');

		available_status1=available_status.split(' ');

		if(available_status1[2]!='available')

		{

		

		$(this).parent().next().addClass('avail-last');
		//rgb(102, 102, 102)
		//$('.avail-first').css('background','url("<?php echo base_url().'images/available-1st.png';?>")');
		$('.avail-first').css('background-color','#E99C00');

		$('.avail-first').css('background-position','right');

		$('.avail-middle').css('background-color','#E99C00');

		

		//$('.avail-last').css('background-color','rgb(102, 102, 102)');

		//$('.avail-last').css('height','72px');

		} 

		})

		/** available status **/

		

		/** booked status **/

		

		

		$('.booked-middle').each(function(){

		var available_status=$(this).parent().next().attr('class');

		available_status1=available_status.split(' ');

		if(available_status1[2]!='booked')

		{

		

		$(this).parent().next().addClass('booked-last');

		$('.booked-first').css('background-color','#048b90');

		$('.booked-first').css('background-position','right');

		$('.booked-middle').css('background-color','#048b90');

		

		//$('.booked-last').css('background-color','rgb(102, 102, 102)');

		//$('.booked-last').css('height','72px');

		} 

		})

		/** booked status **/

		

		

		/** unavailable status **/

		

		$('.unavail-middle').each(function(){

		var available_status=$(this).parent().next().attr('class');

		available_status1=available_status.split(' ');

		if(available_status1[2]!='unavailable')

		{

		

		$(this).parent().next().addClass('unavail-last');

		$('.unavail-first').css('background-color','#ff5a60');

		$('.unavail-first').css('background-position','right');

		$('.unavail-middle').css('background-color','#ff5a60');

		

		// $('.unavail-last').css('background-color','rgb(102, 102, 102)');

		// $('.unavail-last').css('height','72px');

		} 

		})

		/** unavailable status **/

   

	}



</script>	

<style>

/*-------------Calender-page------------*/

#wrapper

{

	float:left;

}

.calender-top

{

	width:100%;

	float:left;

	clear:both;

	margin-bottom: 15px;

}

.calender-top-left, .calender-top-right

{

	padding:0;

}

.calender-left-arrow

{

	width:35px;

	height:35px;

	background:url(../../../../../images/calender-left-arrow.png) no-repeat scroll 54% 67% #fff;

	border:1px solid #ccc;

	padding:10px;

	float:left;

}

.calender-right-arrow

{

	width:35px;

	height:35px;

	background:url(../../../../../images/calender-right-arrow.png) no-repeat scroll 54% 67% #fff;

	border:1px solid #ccc;

	padding:10px;

	float:left;

}

.calender-month

{

	width:180px;

	float:left;

	background:#fff;

	height:35px;

	padding:2px;

	font-family: "Conv_DaxLight";

	color:#333;

	border:1px solid #ccc;

	margin:0 10px;

}

.calender-top-right ul

{

	float:right;

}

.calender-top-right ul li

{

	font-family: "Conv_DaxLight";

	color:#333;

	font-size:14px;

	float:left;

	margin-right:30px;

}

.calender-top-right ul li:last-child

{

	margin-right:0;

}

.green-circle

{

	width:10px;

	height:10px;

	float:left;

	background:#E99C00;

	display:block;

	border-radius:100%;

	margin-top:5px;

	margin-right:10px;

	border:1px solid #E99C00;

}

.white-circle

{

	width:10px;

	height:10px;

	float:left;

	background:#048b90;

	display:block;

	border-radius:100%;

	margin-top:5px;

	margin-right:10px;

	border:1px solid #048b90;

}

.gray-circle

{

	width:10px;

	height:10px;

	float:left;

	background:#ff5a60;

	display:block;

	border-radius:100%;

	margin-top:5px;

	margin-right:10px;

	border:1px solid #ccc;

}



.DOPBackendBookingCalendarPRO_Day .bind-content .header, .DOPBackendBookingCalendarPRO_Day .bind-content .content

{

	border:0 !important;

}

.DOPBackendBookingCalendarPRO_Day.curr_month, .DOPBackendBookingCalendarPRO_Day.past_day, .DOPBackendBookingCalendarPRO_Day.next_month

{

	border: 1px solid #cccccc !important;

	/*width:74.9px !important;*/

	width:65px !important;

	width:calc(100% / 7 ) !important;

/*	width: -webkit-calc(100% / 7 ) !important;

	width: -moz-calc(100% / 7 ) !important;*/

}



.DOPBackendBookingCalendarPRO_Day .bind-content .header .day

{

	font-family: "Conv_DaxBold" !important;

	color:#000 !important;

	font-size:14px !important;

	float:none !important;

}

.DOPBackendBookingCalendarPRO_Month

{

	width:100%; !important;

}

.DOPBackendBookingCalendarPRO_Day .bind-content .header

{

	/*text-align:right;*/

}

/*.DOPBackendBookingCalendarPRO_Day.selected .header

{

	background:none !important;

	border:0 !important;

}*/



.DOPBackendBookingCalendarPRO_Day .bind-content .content .price

{

	  display: inline-block;

	  float:none !important;

}

.DOPBackendBookingCalendarPRO_Day.available .content

{

text-align:center !important;

font-size: 24px !important;

line-height: 20px !important;

}





.DOPBackendBookingCalendarPRO_Day.available .avail-first

{

	/* background:url(images/available-1st.png); */

	float:right;

	width:67px;

	height:72px;

	background-repeat: no-repeat !important;

	background-position: right !important;

	z-index: 9999;

	position: absolute;

}



.booked-first,.booked-last,.unavail-first,.unavail-last

{

	background-repeat: no-repeat !important;

}

.booked-first,.unavail-first

{

	background-position: right !important;

}



.DOPBackendBookingCalendarPRO_Day.available .avail-first .day, .DOPBackendBookingCalendarPRO_Day .bind-content .content .price, .DOPBackendBookingCalendarPRO_Day .bind-content .content .available, .DOPBackendBookingCalendarPRO_Day .avail-middle .header .day

{

	color:#000 !important;

	font-size: 14px !important;

}

.DOPBackendBookingCalendarPRO_Day

{

	/* min-height:73px; */

	height:73px !important;

	overflow:hidden;

}

.DOPBackendBookingCalendarPRO_Day

{

	border:1px solid #CCC;

}

.DOPBackendBookingCalendarPRO_Day .bind-content

{

	position:absolute;

}

.DOPBackendBookingCalendarPRO_Day

{

	/*width:74.9px !important;*/

	width:65px !important;

}





.DOPBackendBookingCalendarPRO_Day.available .avail-middle

{

	/* background-color:#37a86c; */

	height:72px;

	float:left;

	position: absolute;

	color:#000;

}

.DOPBackendBookingCalendarPRO_Day:last-child .avail-middle ~ div.DOPBackendBookingCalendarPRO_Day

{

	background:url(images/available-1st.png);

	float:right;

	width:67px;

	height:72px;

	background-repeat: no-repeat;

	background-position: right;

	z-index: 9999;

	position: absolute;

	transform:rotate(180deg);

}





#get_calendar

{

	float: left;

	border:0;

    width: 100%;

}





.DOPBackendBookingCalendarPRO_Day.curr_month.available +.DOPBackendBookingCalendarPRO_Day.curr_month.available

{

/* background:url(images/available-last.png); */

background-repeat: no-repeat; 

}





.DOPBackendBookingCalendarPRO_Month .DOPBackendBookingCalendarPRO_Day.available:last-child  .avail-middle

{

	background-color:none !important;

}

.DOPBackendBookingCalendarPRO_Day .bind-content .header

{

	background:none !important;

}

.DOPBackendBookingCalendarPRO_Day.last_month {

    opacity: 1 !important;

}

.DOPBackendBookingCalendarPRO_Day.past_day,.DOPBackendBookingCalendarPRO_Day.next_month

{

    opacity: 0.4 !important;

}

input#selected_month_year

{

	border:0;

	width: 100%;

	height: 30px;

	text-align:center;

	box-shadow:none;

}

.month_year,.add_btn, .remove_btn, .previous_btn, .next_btn,.DOPBackendBookingCalendarPRO_Navigation .previous_btn

{

	display:none !important;

}

.DOPBackendBookingCalendarPRO_Month 

{

    padding: 0px 0 !important;

    background: none repeat scroll 0% 0% #FFF;

    float: left;

    width: 99.5% !important;

}

.calender-month

{

	text-align:center !important;

	padding-top:7px !important;

	background:url("images/small-arrow.png") no-repeat scroll 95% 57% #FFF;

	top: -14px;

	position: relative;

}



.DOPBackendBookingCalendarPRO_Day.selected .header,.DOPBackendBookingCalendarPRO_Day.selected .header,.DOPBackendBookingCalendarPRO_Day.selected .header,.DOPBackendBookingCalendarPRO_Day.special .header,.DOPBackendBookingCalendarPRO_Day.booked .header

{

background-color: none !important;

border-color: 0 !important;

}

.publish-btn {

    background: none repeat scroll 0px 0px #38A86A;

    border-radius: 5px;

    color: #FFF !important;

    font-family: "Conv_DaxLight";

    font-size: 16px;

    font-weight: normal;

    margin: 3px 0 0 24px;

    padding: 0px 20px;

	float:right;

	cursor: pointer;

}

.publish-btn:hover{

	color: #FFF !important;

}



.DOPBackendBookingCalendarPRO_FormContainer

{

	background:#FFF !important;

	border-radius:5px !important;

	border:1px solid #999;

}

.section-item lable.left

{

	font-family: "Conv_DaxLight";

	font-size:14px;

}

input#DOPBCP_submit

{

	background: none repeat scroll 0px 0px #38A86A !important;

	border-radius: 5px !Important;

	color: #FFF !important;

	font-family: "Conv_DaxLight";

	font-size: 15px;

	font-weight: normal;

	margin: 3px 15px 0px 0 !important;

	padding: 3px 15px !important;

	float: left !important;

}



input#DOPBCP_reset{

  background: #7d7d7d !important;

  padding: 3px 15px !important;

  font-family: "Conv_DaxLight";

  margin: 3px 15px 0px 0 !important;

  border-radius: 5px !Important;

  font-size: 15px;

}



input#DOPBCP_close

{

	background: #000 !important;

	padding: 3px 15px !important;

	font-family: "Conv_DaxLight";

	margin: 3px 0 0px 0 !important;

	border-radius: 5px !Important;

	font-size: 15px;

}



.DOPBackendBookingCalendarPRO_Form .section-item select

{

	line-height:20px !important;

}



.DOPBackendBookingCalendarPRO_Form .section-item .date

{

	color: #37a86c !important;

}



.register_popup_main 

{

    background: none repeat scroll 0px 0px rgba(0, 0, 0, 0.4);

    height: 1770px;

    position: absolute;

    width: 100%;

    z-index: 9999;

}

.DOPBackendBookingCalendarPRO_Day .bind-content .header

{

	padding:0 !important;

}



.DOPBackendBookingCalendarPRO_Day.booked .content

{

	text-align:center !important;

}

.table-condensed .prev

{

	-webkit-transform: -webkit-rotateY(180deg);

}









.DOPBackendBookingCalendarPRO_Navigation, .DOPBackendBookingCalendarPRO_Form .container, .DOPBackendBookingCalendarPRO_Form .section input[type="button"] , .DOPBackendBookingCalendarPRO_Day.selected .header,.DOPBackendBookingCalendarPRO_Container

{

	background:none !important;

}

.DOPBackendBookingCalendarPRO_Navigation .month_year

{

	color:#FFF !important;

	font-family: "Conv_DaxBold";

}

.DOPBackendBookingCalendarPRO_Navigation .week .day

{

	color:#333 !important;

	font-family: "Conv_DaxLight" !important;

	font-size:12px !important;

}

.DOPBackendBookingCalendarPRO_Day .bind-content .header

{

	background:none !important;

}

/*.DOPBackendBookingCalendarPRO_Day.booked .header

{

	background:#fbd597 !important;

}*/

.DOPBackendBookingCalendarPRO_Day .bind-content .content .price

{

	font-family: "Conv_DaxLight" !important;

	font-weight: normal !important;

	font-size: 17px !important;

	padding-top: 12px !important;

}

#wrapper 

{

    width: 100%;

    z-index: -999 !important;

}

input#DOPBCP_close

{

	background:#7d7d7d  !important;

}

input#DOPBCP_close:hover

{

	background:#333 !important;

}



.DOPBackendBookingCalendarPRO_FormWrapper {

    position: absolute;

}

.DOPBackendBookingCalendarPRO_Navigation, .DOPBackendBookingCalendarPRO_Calendar

{

	z-index:0 !important;

	position:inherit !important;

}

.calender-month

{

	top: 0px !important;

}



.DOPBackendBookingCalendarPRO_Day.past_day, .DOPBackendBookingCalendarPRO_Day.next_month, .DOPBackendBookingCalendarPRO_Day, .DOPBackendBookingCalendarPRO_Day.curr_month.available, .DOPBackendBookingCalendarPRO_Day.curr_month.avail-last, .DOPBackendBookingCalendarPRO_Day.curr_month

{

	width:14% !important;

}

.calender-right-arrow

{

	height:24px !important;

	width:24px !important;

	  background: url(../../../../../images/calender-right-arrow.png) no-repeat scroll 54% 67% #fff !important;

}


.calender-left-arrow{width: 24px !important; height: 24px !important;}

#cboxLoadedContent

{

	  height: 650px !important;

	  overflow:visible !important;

}

.calender-top-right ul 

{

  float: right;

  margin-left: 0;

  padding-left: 0;

  margin-right: 30px;

}

</style>