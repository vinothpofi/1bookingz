<?php

$this->load->view('admin/templates/header.php');

extract($privileges);

//print_r($privileges);

//echo $this->data['subAdminMail'];

//echo '</br>';

//echo $this->data['allPrev'];
$ttlnum=0;
?>

<?php 

	 /*$orderIndex1 = 0;

	 foreach($getOrderDetails as $orderdetails) { 

	

	$orderDetails .='['.date('Y', strtotime($orderdetails['created'])).', '.$orderdetails['price'].'],'; 

	

	$orderIndex1++;

	}*/ ?>

<script>

/*=================

CHART 6

===================*/

$(function () {

   // var s1 = [<?php echo $orderDetails; ?>];

  //  var s2 = [<?php echo $orderDetails; ?>];

 var s1 = [[2004, 104000], [2005, 99000], [2006, 121000],

    [2007, 148000], [2008, 114000], [2009, 133000], [2010, 161000],[2011, 112000], [2012, 122000], [2013, 173000]];

    var s2 = [[2004, 11200], [2005, 11800], [2006, 12400],

    [2007, 12800], [2008, 13200], [2009, 12600], [2010, 10200], [2011, 10800], [2012, 13100]];







    plot1 = $.jqplot("chart6", [s2, s1], {

        // Turns on animatino for all series in this plot.

        animate: true,

        // Will animate plot on calls to plot1.replot({resetAxes:true})

        animateReplot: true,

        cursor: {

            show: true,

            zoom: false,

            looseZoom: true,

            showTooltip: false

        },

        series:[

            {

                pointLabels: {

                    show: true

                },

                renderer: $.jqplot.BarRenderer,

                showHighlight: false,

                yaxis: 'y2axis',

                rendererOptions: {

                    // Speed up the animation a little bit.

                    // This is a number of milliseconds. 

                    // Default for bar series is 3000. 

                    animation: {

                        speed: 2500

                    },

                    barWidth: 15,

                    barPadding: -15,

                    barMargin: 0,

                    highlightMouseOver: false

                }

            },

            {

                rendererOptions: {

                    // speed up the animation a little bit.

                    // This is a number of milliseconds.

                    // Default for a line series is 2500.

                    animation: {

                        speed: 2000

                    }

                }

            }

        ],

        axesDefaults: {

            pad: 0

        },

        axes: {

            // These options will set up the x axis like a category axis.

            xaxis: {

                tickInterval: 1,

                drawMajorGridlines: false,

                drawMinorGridlines: true,

                drawMajorTickMarks: false,

                rendererOptions: {

                tickInset: 0.5,

                minorTicks: 1

            }

            },

            yaxis: {

                tickOptions: {

                    formatString: "$%'d"

                },

                rendererOptions: {

                    forceTickAt0: true

                }

            },

            y2axis: {

                tickOptions: {

                    formatString: "$%'d"

                },

                rendererOptions: {

                    // align the ticks on the y2 axis with the y axis.

                    alignTicks: true,

                    forceTickAt0: true

                }

            }

        },

        highlighter: {

            show: true,

            showLabel: true,

            tooltipAxes: 'y',

            sizeAdjust: 7.5 , tooltipLocation : 'ne'

        },

		grid: {

         borderColor: '#ccc',     // CSS color spec for border around grid.

        borderWidth: 2.0,           // pixel width of border around grid.

        shadow: false               // draw a shadow for grid.

    },

	seriesDefaults: {

        lineWidth: 2, // Width of the line in pixels.

        shadow: false,   // show shadow or not.

		 markerOptions: {

            show: true,             // wether to show data point markers.

            style: 'filledCircle',  // circle, diamond, square, filledCircle.

                                    // filledDiamond or filledSquare.

            lineWidth: 2,       // width of the stroke drawing the marker.

            size: 14,            // size (diameter, edge length, etc.) of the marker.

            color: '#ff8a00',    // color of marker, set to color of line by default.

            shadow: true,       // wether to draw shadow on marker or not.

            shadowAngle: 45,    // angle of the shadow.  Clockwise from x axis.

            shadowOffset: 1,    // offset from the line of the shadow,

            shadowDepth: 3,     // Number of strokes to make when drawing shadow.  Each stroke

                                // offset by shadowOffset from the last.

            shadowAlpha: 0.07   // Opacity of the shadow

        }

	}

    });

});	</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
        ['Hosts', 'Total'],
        ['Active Hosts', <?php echo intval($activeHostCounts); ?>],
        ['Inactive Hosts',<?php echo intval($InactiveHostCounts); ?>]
    ]);
      var options = {
          height: 350,width: 525,pieSliceText: 'value-and-percentage',
      };
    var chart = new google.visualization.PieChart(document.getElementById('chart_host'));
    chart.draw(data, options);
  }
</script>
<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Guests','Total'],
        ['Active Guests', <?php echo intval($activeUserCounts); ?>],
        ['Inactive Guests',<?php echo intval($InactiveUserCounts); ?>]
    ]);

    var options = {
      height: 350,width: 525,pieSliceText: 'value-and-percentage',
    };

    var chart = new google.visualization.PieChart(document.getElementById('chart_user'));
    chart.draw(data, options);
  }
</script>


	<div id="content">

		<div class="grid_container">			

			<span class="clear"></span>

            <div class="grid_12">
				<div class="social_activities">                                            
	                <div class="views_s" style="background: #c93e4f;">                            
	                    <h6 class="block_label">Total Hosts</h6>
	                    <h3 class="counter"><?php echo $getTotalSellerCount;?></h3>
	                    <span class="activitiesimg"><img src="images/people.svg" alt="" width="60" height="60" class="stats__icon"></span>
	                    <p class="countdtls">Today- <strong><?php echo $getTodaySellerCount; ?></strong></p>
	                    <p class="countdtls">This Month- <strong><?php echo $thismonthsellerCounts; ?></strong></p>
	                    <p class="countdtls">This Year- <strong><?php echo $thisyearsellerCounts; ?></strong></p>
					</div>
	           		<?php
	           		if($rep_type!='Representative')
					{ ?>
	                <div class="activities_s" style="background: #d97059;">
	                    <h6 class="block_label">Total Guests</h6>
	                    <h3 class="counter" ><?php echo $totalUserCounts;?></h3>
	                    <span class="activitiesimg"><img src="images/people.svg" alt="" width="60" height="60" class="stats__icon"></span>
	                    <p class="countdtls">Today- <strong><?php echo $todayUserCounts; ?></strong></p>
	                    <p class="countdtls">This Month- <strong><?php echo $thismonthUserCounts; ?></strong></p>
	                    <p class="countdtls">This Year- <strong><?php echo $thisyearUserCounts; ?></strong></p>
					</div>
					<?php } ?>
	                                
	                <div class="comments_s" style="background: #24a690;">
	                    <h6 class="block_label">Total Property List</h6>
	                    <h3 class="counter"><?php echo $getTotalProductCount;?></h3>
	                    <span class="activitiesimg"><img src="images/stats_icon_4.svg" alt="" width="60" height="60" class="stats__icon"></span>
	                    <p class="countdtls">Today- <strong><?php echo $getTodayProductCount; ?></strong></p>
	                    <p class="countdtls">This Month- <strong><?php echo $thismonthpropertyCounts; ?></strong></p>
	                    <p class="countdtls">This Year- <strong><?php echo $thisyearpropertyCounts; ?></strong></p>
					</div>

					<div class="user_s" style="background: #42628c;">
	                    <h6 class="block_label">Total Experience List</h6>
	                    <h3 class="counter" ><?php echo $getTotalexperienceCount;?></h3>
	                    <span class="activitiesimg"><img src="images/moneyicon.svg" alt="" width="60" height="60" class="stats__icon"></span>
	                    <p class="countdtls">Today- <strong><?php echo $getTodayexperienceCount; ?></strong></p>
	                    <p class="countdtls">This Month- <strong><?php echo $thismonthexperienceCounts; ?></strong></p>
	                    <p class="countdtls">This Year- <strong><?php echo $thisyearexperienceCounts; ?></strong></p>                                    
	                </div>
				</div>
<!-- 				<div class="widget_wrap collapsible_widget">

					<div class="widget_top active">

						<span class="h_icon"></span>

						<h6>Dashboard</h6>

					</div>

					<div class="widget_content">

			</div>

				</div> -->

			</div>
            <span class="clear"></span>
            <div class="grid_12" style="margin-bottom: 10px;">
                <!-- <div class="widget_wrap collapsible_widget"> -->
                <!-- 				<div class="widget_top active">
                                    <span class="h_icon"></span>
                                        <h6>Dashboard</h6>
                                </div> -->
                <!-- <div class="widget_content"> -->
                <!-- added by vishnu -->
                <div class="social_medias">

                    <div class="box--social-tw">
                        <img src="images/social_4.png" alt="" class="box__icon">
                        <?php
                        $ttlnum = $totaluserscount;
                        $nusernum = $getnormaluserscount;
                        if ($ttlnum > 0) {
                            $percnt =  ($nusernum / $ttlnum) * 100;
                        }
                        ?>
                        <h3><?php echo sprintf("%.2f", $percnt); ?>%</h3>
                        <p><?php echo $getnormaluserscount; ?> Users</p>
                    </div>


                    <div class="box--social-fb">
                        <img src="images/social_1fb.svg" alt="" class="box__icon">
                        <?php
                        $ttlnum = $totaluserscount;
                        $nusernum = $getfacebookuserscount;
                        if ($ttlnum > 0) {
                            $percnt =  ($nusernum / $ttlnum) * 100;
                        }
                        ?>
                        <h3><?php echo sprintf("%.2f", $percnt); ?>%</h3>
                        <p><?php echo $getfacebookuserscount; ?> Users</p>
                    </div>

                    <div class="box--social-gp">
                        <img src="images/social_3g+.svg" alt="" class="box__icon">
                        <?php
                        $ttlnum = $totaluserscount;
                        $nusernum = $getgoogleuserscount;
                        if ($ttlnum > 0) {

                            $percnt =  ($nusernum / $ttlnum) * 100;
                        }
                        ?>
                        <h3><?php echo sprintf("%.2f", $percnt); ?>%</h3>
                        <p><?php echo $getgoogleuserscount; ?> Users</p>
                    </div>

                    <div class="box--social-li">
                        <img src="images/social_4lnk.svg" alt="" class="box__icon">
                        <?php
                        $ttlnum = $totaluserscount;
                        $nusernum = $getlinkedinuserscount;
                        if ($ttlnum > 0) {
                            $percnt =  ($nusernum / $ttlnum) * 100;
                        }
                        ?>
                        <h3><?php echo sprintf("%.2f", $percnt); ?>%</h3>
                        <p><?php echo $getlinkedinuserscount; ?> Users</p>
                    </div>


                </div>
                <!-- </div> -->
                <!-- </div> -->
            </div>


            <span class="clear"></span>
            <!--<div class="grid_12 full_block">

				<div class="widget_wrap">

					<div class="widget_content">

						<div id="chart6" class="chart_block">

						</div>

					</div>

				</div>

			</div>-->
<div class="grid_6 chartDiv">
	<div class="widget_wrap">
		<div class="widget_top">
			<span class="h_icon chart_8"></span>
			<h6>Guests</h6>
		</div>	
		<div class="widget_content">
			<div id="chart_user"></div>
		</div>
	</div>
</div>
<div class="grid_6 chartDiv">
	<div class="widget_wrap">
		<div class="widget_top">
			<span class="h_icon chart_8"></span>
			<h6>Hosts</h6>
		</div>	
		<div class="widget_content">
			<div id="chart_host"></div>
		</div>
	</div>
</div>
            <?php
			if($rep_type!='Representative')
			{ ?>		

			<div class="grid_6">

				<div class="widget_wrap">

					<div class="widget_top">

						<span class="h_icon users"></span>

						<h6>Recent Guest List</h6>

					</div>

					<div class="widget_content">

						<div class="user_list">

							<?php if(count($getRecentUsersList)>0) { ?>

                            <?php foreach($getRecentUsersList as $userList) { ?>

							

							<div class="user_block">

								<div class="info_block">

									<div class="widget_thumb">

                                    <?php if($userList['loginUserType'] == 'google') {?>

										<img src="<?php echo $userList['image'];?> " width="40" height="40" alt="user">

                                    <?php } else if($userList['image'] != '') {?>

                                   		 <img src="images/users/<?php echo $userList['image'];?> " width="40" height="40" alt="user">

                                      <?php } else { ?>

										<img src="images/user-thumb1.png" width="40" height="40" alt="user">

                                      <?php } ?>

									</div>

									<ul class="list_info">

										<li><span><a href="admin/users/view_user/<?php echo $userList['id'];?>"><?php echo stripslashes($userList['firstname']); ?></a></span></li>

										<li><span>IP: <?php echo $userList['last_login_ip']; ?> Date: <?php echo $userList['created']; ?></span></li>

										<!-- <li><span>User Type: Paid, <i>Package Name:</i><b>Gold</b></span></li> -->

									</ul>

								</div>

								<ul class="action_list">

									<li><a class="p_edit" href="admin/users/edit_user_form/<?php echo $userList['id'];?>";>Edit</a></li>

									<li><a class="p_del" href="javascript:confirm_delete('admin/users/delete_user/<?php echo $userList['id'];?>')">Delete</a></li>

									<!-- <li><a class="p_reject" href="#">Suspend</a></li>-->

									<li class="right"><a class="p_approve" href="javascript:confirm_status('admin/users/change_user_status/0/<?php echo $userList['id'];?>');"><?php echo $userList['status']; ?></a></li>

								</ul>

							</div>

                            <?php } }else{?>

                            <p>No recent guest found</p>

                            <?php } ?>

                            

                            

						</div>

					</div>

				</div>

			</div>
 			
 						<div class="grid_6">

				<div class="widget_wrap tabby" >

					<div class="widget_top">

						<span class="h_icon h_icon users"></span>

						<h6>Recent Renters List</h6>

						<div id="widget_tab" class="widget_tab">

							<ul>							

								<li><a href="#tab1">Renters<span class="alert_notify blue"><?php echo $getTotalSellerCount;?></span></a></li>

							</ul>

						</div>

					</div>

					<div class="widget_content">

						

						<div id="tab1">

                        

                        <div class="user_list">

								<?php if(count($getRecentSellerList)>0){?>

								 <?php foreach($getRecentSellerList as $userList) { ?>

							

							<div class="user_block">

								<div class="info_block">

									<div class="widget_thumb">

                                    <?php if($userList['image'] != '') {?>

                                   		 <img src="images/users/<?php echo $userList['image'];?> " width="40" height="40" alt="user">

                                      <?php } else { ?>

										<img src="images/user-thumb1.png" width="40" height="40" alt="user">

                                      <?php } ?>

									</div>

									<ul class="list_info">

										<li><span><a href="admin/users/view_user/<?php echo $userList['id'];?>"><?php echo stripslashes($userList['firstname']); ?></a></span></li>

										<li><span>IP: <?php echo $userList['last_login_ip']; ?> Date: <?php echo $userList['created']; ?></span></li>

										<!-- <li><span>User Type: Paid, <i>Package Name:</i><b>Gold</b></span></li> -->

									</ul>

								</div>

								<ul class="action_list">

									<li><a class="p_edit" href="admin/seller/edit_seller_form/<?php echo $userList['id'];?>";>Edit</a></li>

									<li><a class="p_del" href="javascript:confirm_delete('admin/seller/delete_seller/<?php echo $userList['id'];?>')">Delete</a></li>

									<!-- <li><a class="p_reject" href="#">Suspend</a></li>-->

									<li class="right"><a class="p_approve" href="javascript:confirm_status('admin/dashboard/change_seller_status/0/<?php echo $userList['id'];?>');"><?php echo $userList['status']; ?></a></li>

								</ul>

							</div>

                           <?php } }else{?>

							<tr><td><p>No recent booking found</p></td></tr>

                            <?php } ?>	

							</div>							

						</div>

					</div>

				</div>

			</div>

			<span class="clear"></span>
			
			<div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon shopping_cart_3"></span>
						<h6>Recent Rentals Bookings</h6>
					</div>
					<div class="widget_content table-responsive1">
						<table class="wtbl_list">
						<thead>
						<tr>
							<th>
								 Booking ID
							</th>
							<th>
								 Titile
							</th>
							<th>
								 Status
							</th>
							<th>
								 Date
							</th>
							<th>
								 Amount
							</th>
						</tr>
						</thead>
						<tbody>
                         <?php 
						 if(count($getrentalOrderDetails) >0)
						 {

						 $orderIndex = 0;

						 foreach($getrentalOrderDetails as $orderdetails) 
						 { 
						 	$curtyp = $orderdetails['user_currencycode'];
						 	$tocurr = USD;						 	
						 ?>
						<tr class="<?php if($orderIndex == 0 || $orderIndex==2) echo 'tr_even';else echo 'tr_odd'; ?>">
							<td class="noborder_b round_l">
								 <?php echo $orderdetails['Bookingno']; ?>
							</td>
							<td class="noborder_b">
								<span><?php echo $orderdetails['product_title']; ?></span>
							</td>
							<td class="noborder_b">
								<span class="badge_style <?php if($orderdetails['paymentStatus'] =='Pending')echo 'b_pending'; else echo 'b_confirmed'; ?>"><?php echo $orderdetails['paymentStatus']; ?></span>
							</td>
							<td class="noborder_b ">
								<?php echo $orderdetails['created']; ?>
							</td>
							<td class="noborder_b round_r">
								 <?php 
								 $createdDate = date('Y-m-d',strtotime($orderdetails['created']));
								 $getCurrencyId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
								 if($getCurrencyId=='') { $getCurrencyId=''; }
								echo '$ '.currency_conversion($curtyp, $tocurr,$orderdetails['total'],$getCurrencyId);  ?>
							</td>
						</tr>                        

                        <?php $orderIndex++;

						 } }  else {?>

                        <p>No recent booking found</p>

                            <?php } ?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- <span class="clear"></span> -->
			<div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top ">
						<span class="h_icon shopping_cart_3"></span>
						<h6>Recent Experience Bookings</h6>
					</div>
					<div class="widget_content table-responsive1">
						<table class="wtbl_list">
						<thead>
						<tr>
							<th>
								 Booking ID
							</th>
							<th>
								 Titile
							</th>
							<th>
								 Status
							</th>
							<th>
								 Date
							</th>
							<th>
								 Amount
							</th>
						</tr>
						</thead>
						<tbody>
                         <?php 
						 if(count($getexperienceOrderDetails) >0)
						 {

						 $orderIndex = 0;

						 foreach($getexperienceOrderDetails as $orderdetails) 
						 { 
						 	$curtyp = $orderdetails['currency_code'];
						 	$tocurr = USD;						 	
						 ?>

						<tr class="<?php if($orderIndex == 0 || $orderIndex==2) echo 'tr_even';else echo 'tr_odd'; ?>">

							<td class="noborder_b round_l">

								 <?php echo $orderdetails['Bookingno']; ?>

							</td>

							<td class="noborder_b">

								<span><?php echo $orderdetails['experience_title']; ?></span>

							</td>

							<td class="noborder_b">

								<span class="badge_style <?php if($orderdetails['paymentStatus'] =='Pending')echo 'b_pending'; else echo 'b_confirmed'; ?>"><?php echo $orderdetails['paymentStatus']; ?></span>

							</td>
							<td class="noborder_b ">

								<?php echo $orderdetails['created']; ?>

							</td>

							<td class="noborder_b round_r">

								 <?php 
								 if($curtyp == 'USD')
								 {
								 	echo '$'.$orderdetails['total'];
								 }
								 else
								 {
								 	//echo  '$'.$Paidamt = convertCurrency($curtyp,$tocurr,$orderdetails['paymentPrice']);
									$createdDate = date('Y-m-d',strtotime($orderdetails['created']));
									$getCurrencyId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
									if($getCurrencyId=='') { $getCurrencyId=''; }
									echo '$ '.currency_conversion($curtyp, $tocurr,$orderdetails['total'],$getCurrencyId);
								 }
								
								 ?>


							</td>

						</tr>

                        

                        <?php $orderIndex++;

						 } }  else {?>

                        <p>No recent booking found</p>

                            <?php } ?>

						</tbody>

						</table>

					</div>

				</div>
			</div>
			

				<?php } else {} ?>

<!-- --Renter-- -->

			<span class="clear"></span>

		</div>

		<span class="clear"></span>


	</div>

</div>

<?php 

$this->load->view('admin/templates/footer.php');

?>


