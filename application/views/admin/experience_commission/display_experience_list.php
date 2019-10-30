<?php
   $this->load->view('admin/templates/header.php');
   
   extract($privileges);
   
   ?>
<div id="content">
   <div class="grid_container">
      <?php 
         $attributes = array('id' => 'display_form');
         
         echo form_open('admin/order/change_order_status_global',$attributes) 
         
         ?>
      <div class="grid_12">
         <div class="widget_wrap">
            <div class="widget_top">
               <span class="h_icon blocks_images"></span>
               <h6><?php echo $heading?></h6>
            </div>
            <div class="widget_content">
               <table class="display display_tbl" id="subadmin_tbl">
                  <thead>
                     <tr>
                        <th class="center">
                           <input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
                        </th>
                        <th class="tip_top" title="Click to sort">
                           <span style="padding:10px"> S No</span>
                        </th>
                        <th class="tip_top" title="Click to sort">
                           <span style="padding:5px 10px 5px 5px">Booking No</span>
                        </th>
                        <th class="tip_top" title="Click to sort">
                           Guest Email ID
                        </th>
                        <th class="tip_top" title="Click to sort">
                           Product Title
                        </th>
                        <th class="tip_top" title="Click to sort">
                           Date Added		
                        </th>
                        <th class="tip_top" title="Total Booking Amount">Total Amount <i class="fa fa-info-circle"></i></th>
                        <th>
                           Guest Service Amount
                        </th>
                        <th>
                           Cancellation Amount
                        </th>
                        <th class="tip_top" title="Sum of host fee and guest fee">
                           Actual Profit <i class="fa fa-info-circle"></i>
                        </th>
                        <!--<th class="tip_top" title="Wallet amount used in orders">Used Wallet Amt <i class="fa fa-info-circle"></i></th>-->
                        <th>
                           paid
                        </th>
                        <th>
                           Balance
                        </th>
                        <th>
                           <span style="padding:10px">Product Title</span>
                        </th>
                        <th>
                           Booking Status
                        </th>
                        <!-- <th>
                           Action
                           
                           </th> -->
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
					// print_r($product);
                        if (count($product) > 0){
                        
                        $i=1;
                        
                        	foreach ($product as $value){
                        
                        		
                        
                        		foreach($value as $pro)
                        
                        		{
                        
									$minus_checkin = strtotime($pro->checkin);
									$checkinBeforeDay = date('Y-m-d', $minus_checkin);
									$current_date = date('Y-m-d');
									$currencyPerUnitSeller=$pro->currencyPerUnitSeller;
									//echo $checkinBeforeDay.' <= '.$current_date.'<br>';
									if($checkinBeforeDay <= $current_date){	
                        
                        ?>
                     <tr>
                        <td class="center tr_select ">
                           <input name="checkbox_id[]" type="checkbox" value="<?php echo $pro->id;?>">
                        </td>
                        <td class="center">
                           <?php echo $i;?>
                        </td>
                        <td class="center">
                           <?php echo $pro->Bookingno;?>
                        </td>
                        <td class="center">
                           <?php echo $pro->email;?>
                        </td>
                        <td class="center">
                           <?php echo $pro->experience_title;?>
                        </td>
                        <td class="center">
                           <?php echo date('d-m-Y',strtotime($pro->dateAdded));?>
                        </td>
                        <td class="center">
                           <?php 
							$tot_amount = $pro->total_amount;
							$createdDate = date('Y-m-d',strtotime($pro->dateAdded));
							$getCurrencyId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
							if($getCurrencyId=='') { $getCurrencyId=''; }
                              if($pro->user_currencycode != $admin_currency_code){
                              
                              	$totAmount=currency_conversion($pro->user_currencycode, $admin_currency_code, $tot_amount,$getCurrencyId);//customised_currency_conversion($currencyPerUnitSeller,$pro->total_amount);
                              
                              }else{
                              
                              	$totAmount=$tot_amount; 
                              
                              }
                              
                              echo $admin_currency_symbol.' '.$totAmount;
                              
                              
                              
                              //echo $admin_currency_symbol.' '.$pro->total_amount; ?>
                        </td>
                        <td class="center">
                           <?php
							$GuestFee = $pro->guest_fee;
                              if($pro->user_currencycode != $admin_currency_code){
                              
                              	$GuestFee=currency_conversion($pro->user_currencycode, $admin_currency_code, $GuestFee,$getCurrencyId);//customised_currency_conversion($currencyPerUnitSeller,$pro->guest_fee);
                              
                              }/*else{
                              
                              	$GuestFee=$pro->guest_fee; 
                              
                              }*/
                              
                              
                              
                              echo $admin_currency_symbol.' '.$GuestFee;
                              
                              
                              
                              //echo $admin_currency_symbol.' '.$pro->guest_fee;
                              
                              
                              
                              
                              
                              ?>
                        </td>
                        <td class="center">
                           <?php
                                         if ($pro->cancelled=='Yes'){
                              if($pro->cancelled_by !='Host'){
                              	if($pro->user_currencycode != $admin_currency_code){
                              
                              		$canAmount=currency_conversion($pro->user_currencycode, $admin_currency_code, $cancel_amountWithSecDeposit,$getCurrencyId);//customised_currency_conversion($currencyPerUnitSeller,$cancel_amount);
                              
                              	}else{
                              
                              		$canAmount=$cancel_amountWithSecDeposit; 
                              
                              	}
                              
                              	
                              }else{
                                 if($pro->user_currencycode != $admin_currency_code){
                              
                              	$canAmount=currency_conversion($pro->user_currencycode, $admin_currency_code, $tot_amount,$getCurrencyId);//customised_currency_conversion($currencyPerUnitSeller,$pro->total_amount);
                              
                              }else{
                              
                              	$canAmount=$tot_amount; 
                              
                              }
                              
                             
                              }
                              }else{
                              
                              	$canAmount='0.00'; 
                              
                              }
                              
                              echo $admin_currency_symbol.' '.$canAmount;
                              
                              	 ?>
                        </td>
                        <td class="center">
                           <?php 
                              $act_pro = ($pro->guest_fee + $pro->host_fee);
                              
                              
                              
                              if($pro->user_currencycode != $admin_currency_code){
                              
                              	$profit=currency_conversion($pro->user_currencycode, $admin_currency_code, $act_pro,$getCurrencyId);//customised_currency_conversion($currencyPerUnitSeller,$act_pro);
                              
                              }else{
                              
                              	$profit=$act_pro; 
                              
                              }
                              
                              
                              
                              echo $admin_currency_symbol.' '.$profit;
                              
                              
                              
                              
                              
                              
                              
                              /*  $act_pro = ($pro->guest_fee + $pro->host_fee) - $pro->coupon_discount;
                              
                              echo $admin_currency_symbol.' '.number_format($act_pro); */
                              
                              
                              
                              ?>
                        </td>
                        <?php /*<td class="center">
                           <?php
                              if($pro->booking_walletUse != '')
                              
                              {	

                              		if ($admin_currency_code != $pro->user_currencycode)
									{
										$WalletAmount = currency_conversion($pro->user_currencycode, $admin_currency_code, $pro->booking_walletUse,$getCurrencyId);
										//$WalletAmount = customised_currency_conversion($currencyPerUnitSeller, $pro->booking_walletUse);
									}
									else
									{
										$WalletAmount = $pro->booking_walletUse;
									}
									//echo  $admin_currency_symbol.' '.number_format($pro->booking_walletUse);
									echo $admin_currency_symbol . '' . $WalletAmount;

                              }else
                              
                              {
                              
                              	echo  $admin_currency_symbol.''."0.00";
                              
                              }
                              
                              ?>
                        </td>*/ ?>
                        <td class="center">
                           <?php if($pro->paid_status == 'yes')
                              {	
								  if($pro->cancelled=='Yes'){
								  
									$paid_is=$pro->payable_amount-$pro->paid_cancel_amount;

								  }else{
								  
									$paid_is=$pro->payable_amount;
								  
								  }

								  if($pro->user_currencycode != $admin_currency_code){
								  
									$ActPaid=currency_conversion($pro->user_currencycode, $admin_currency_code, $paid_is,$getCurrencyId);//customised_currency_conversion($currencyPerUnitSeller,$paid_is);
								  
								  }else{
								  
									$ActPaid=$paid_is; 
								  
								  }

								  echo $admin_currency_symbol.''.$ActPaid;
                              

                              }else
                              
                              {
                              
                              	echo $admin_currency_symbol.''."0.00";
                              
                              }?>
                        </td>
                        <td class="center">
                           <?php if($pro->paid_status == 'no')
                              {

                              $cancel_amount = $pro->subTotal/100 * $pro->exp_cancel_percentage; 
                              
                              if($pro->cancelled=='Yes'){
								  
                              	$Balene=$pro->payable_amount-$pro->paid_cancel_amount;

                              }else{
                              
                              	$Balene=$pro->payable_amount;
                              
                              }
  
                              if($pro->user_currencycode != $admin_currency_code){
                              
                              	$ActBalence=currency_conversion($pro->user_currencycode, $admin_currency_code, $Balene,$getCurrencyId);//customised_currency_conversion($currencyPerUnitSeller,$Balene);
                              
                              }else{
                              
                              	$ActBalence=$Balene; 
                              
                              }
                             
                              echo $admin_currency_symbol.''.$ActBalence;
                              
                              }else
                              
                              {
                              	echo $admin_currency_symbol.''."0.00";
                              
                              }
                              
                              ?>
                        </td>
                        <td class="center">
                           <?php echo $pro->experience_title;?>
                        </td>
                        <td class="center">
                           <?php echo $pro->booking_status;?>
                        </td>
                     </tr>
                     <?php 
                        }	
                        }
                        $i++;
                        
                        }
                        }
                        
                        ?>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th class="center">
                           <input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
                        </th>
                        <th class="tip_top" title="Click to sort">
                           S No
                        </th>
                        <th class="tip_top" title="Click to sort">
                           Booking No
                        </th>
                        <th class="tip_top" title="Click to sort">
                           Guest Email ID
                        </th>
                        <th>
                           Product Title
                        </th>
                        <th class="tip_top" title="Click to sort">
                           Date Added
                        </th>
                        <th>
                           Total Amount
                        </th>
                        <th>
                           Guest Service Amount
                        </th>
                        <th>
                           Cancellation Amount
                        </th>
                        <th>
                           Actual Profit
                        </th>
                        <!--<th>Used Wallet Amt</th>-->
                        <th>
                           paid
                        </th>
                        <th>
                           Balance
                        </th>
                        <th>
                           Product Title
                        </th>
                        <th class="tip_top" title="Click to sort">
                           Booking Status
                        </th>
                        <!--	<th>
                           Action
                           
                           </th> -->
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
      <input type="hidden" name="statusMode" id="statusMode"/>
      <input type="hidden" name="SubAdminEmail" id="SubAdminEmail"/>
      </form>	
   </div>
   <span class="clear"></span>
</div>
</div>
<?php 
   $this->load->view('admin/templates/footer.php');
   
   ?>