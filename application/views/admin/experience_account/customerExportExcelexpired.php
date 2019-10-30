<?php
header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$title."_list_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('order_model');




?>
<?php
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">'. date('Y-m-d'). '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">'.$this->config->item('site_title').' Account '.$status.' List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';	
		
$XML .= '<table border="1">
	<tr>
    	<th>S No</th>
		<th>Booking No</th>
        <th>Date Added</th> 
		<th>Currency Type(Host)</th>		
		<th>Amount(Host)</th>
		<th>Amount(Admin)</th>
		<th>Guest Email-ID</th>
		<th>Host Email-ID</th>
		<th>Booking Status</th>
        
        
    </tr>';
$sno = 1;
foreach($getCustomerDetails as $myrow) {	if($myrow['currency_cron_id']==0){ $currencyCronId = '';} else { $currencyCronId=$myrow['currency_cron_id']; }
            
    
	if($myrow['booking_status']=='Pending')
		$bookedstatus = 'Pending & Expired';
	elseif($myrow['booking_status']=='Booked')
		$bookedstatus = 'Booked & Expired';
	else 
		$bookedstatus = 'Expired';
	$currencyPerUnitSeller=$myrow[currencyPerUnitSeller];		if($myrow[user_currencycode]!=$myrow[currencycode])		{			$host_price = number_format(ceil(currency_conversion($myrow[user_currencycode], $myrow[currencycode], $myrow[totalAmt],$currencyCronId)),2);		}		else		{			$host_price =  $myrow[totalAmt];		}
		if($admin_currency_code!=$myrow[user_currencycode])
		{
			$admin_price = $admin_currency_symbol.' '.currency_conversion($myrow[user_currencycode], $admin_currency_code, $myrow[totalAmt],$currencyCronId);
		}else		{
			$admin_price =  $admin_currency_symbol.' '.$myrow[totalAmt];		}

	$guestdetail = $this->experience_account_model->get_all_details(USERS,array('id'=>$myrow[renter_id])); 		
	$XML .='<tr>
    	<td style="text-align:left">'.$sno.'</td>
		<td style="text-align:left">'.ucfirst($myrow[Bookingno]).'</td>
        <td style="text-align:left">'.date('d-m-Y',strtotime($myrow[dateAdded])).'</td>
        <td style="text-align:left">'.ucfirst($myrow[currencycode]).'</td>
		<td style="text-align:left">'.$host_price.'</td>
		<td style="text-align:left">'.$admin_price.'</td>
        <td style="text-align:left">'.$myrow['email'].'</td>
		<td style="text-align:left">'.$guestdetail->row()->email.'</td>
        <td style="text-align:left">'.$bookedstatus.'</td>
    </tr>';
	$sno=$sno+1;

}
	$XML .='</table>';	
echo $XML;


?>
                                                               