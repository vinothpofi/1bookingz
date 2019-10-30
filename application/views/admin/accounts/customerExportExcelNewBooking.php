<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$title."_list_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('order_model');
?>
<?php
$XML .= '<table>
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

$XML .= '	<table border="1">
		<tr>
		<th>S No</th>
		<th>Booking No</th>
		<th>Date Added</th> ';
		if($status=='Completed')
		{
		$XML .='<th>Currency Type (Host)</th>
		<th>Amount (Host)</th>
		<th>Amount (Admin)</th>';
		} 	
		$XML .='<th>Guest Email-ID</th>
		<th>Host Email-ID</th>
		<th>Booking Status</th>


	</tr>';
	$sno = 1;

	foreach($getCustomerDetails as $myrow) 
	{	if($myrow[currency_cron_id]==0){ $currencyCronId = '';} else { $currencyCronId=$myrow[currency_cron_id]; }
	if($myrow[approval]=="Pending") 
	{
	$status_new ="Pending Confirmation";
	} 
	else if($myrow[approval]=="Accept") 
	{
	$status_new ="Pending Payment";
	} 
	elseif($myrow[approval]=="Decline") 
	{
	$status_new ="Decline";
	}
	$unitPerCurrencyUser=$myrow[unitPerCurrencyUser];	
	if($admin_currency_code!=$myrow[user_currencycode])
	{			
	$admin_price = $admin_currency_symbol.' '.currency_conversion($myrow[user_currencycode], $admin_currency_code, $myrow[totalAmt],$currencyCronId);//customised_currency_conversion($unitPerCurrencyUser,$myrow[totalAmt]);		
	}else
	$admin_price = $admin_currency_symbol.' '.$myrow[totalAmt];
	$guestdetail = $this->order_model->get_all_details(USERS,array('id'=>$myrow[renter_id])); 		
	$XML .='<tr>
	<td style="text-align:left">'.$sno.'</td>
	<td style="text-align:left">'.ucfirst($myrow[Bookingno]).'</td>
	<td style="text-align:left">'.date('d-m-Y',strtotime($myrow[dateAdded])).'</td> ';
	if($status=='Completed')
	{		$hostCurrency=$myrow['currency_symbols'];		if($myrow['user_currencycode']!=$myrow['currencycode'])		{			$hostAmount =  /*$hostCurrency. */number_format(ceil(currency_conversion($myrow['user_currencycode'], $myrow['currencycode'], $myrow['totalAmt'],$currencyCronId)),2) . "<br>";		}		else		{			$hostAmount =  /*$hostCurrency. */$myrow['totalAmt'] . "<br>";		}
	$XML .='
		<td style="text-align:left">'.ucfirst($myrow[currencycode]).'</td>

		<td style="text-align:left">'.$hostAmount .'</td>

		<td style="text-align:left">'.$admin_price.'</td> ';	
	}
	$XML .='<td style="text-align:left">'.$myrow['email'].'</td>
	<td style="text-align:left">'.$guestdetail->row()->email.'</td>';
	if($status=='Completed')
	{
	$XML .='<td style="text-align:left">'.$status.'</td> </tr>';
	}
	else
	{
	$XML .='<td style="text-align:left">'.$status_new.'</td> </tr>';
	}

	$sno=$sno+1;

	}
$XML .='</table>';	
echo $XML;


?>
								   