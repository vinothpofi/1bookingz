<?php
header("Content-type: application/octet-stream");
//header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Finance_paid_list_" . date('m-d-Y') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('user_model');


/*
<th>Transaction ID</th>		 
<td style="text-align:left">'.ucfirst($myrow[paypal_transaction_id]).'</td>
*/

?>
<?php
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">' . date('Y-m-d') . '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Finance ' . $status . ' List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
			<th>S no</th>
			<th>User Email</th> 
			<th>Payment Date</th>
			<th>Booking No</th>
			<th>Total</th>';
if ($status == "Paid") {
	$XML .= '<th>Payment Type</th>';
}
$XML .= '<th>Status</th>
    </tr>';
$sno = 1;
$admin_currency_code = $this->db->where('id', '1')->get(ADMIN)->row()->admin_currencyCode;
foreach ($getCustomerDetails as $myrow) {
	
	//echo $myrow['currency_code'].' '.$myrow['total'].' ' .$admin_currency_code;
	if($myrow['currency_cron_id']!=0){ $currencyCronId=$myrow['currency_cron_id']; }else { $currencyCronId=''; }
	
	$currencyPerUnitSeller = $myrow['currencyPerUnitSeller'];
	if ($admin_currency_code != $myrow['currency_code'] && $myrow['currency_code'] != '0' && $myrow['currency_code'] != '') {
		//echo convertCurrency($row->currency_code,$admin_currency_code,$row->total);
		//$tot = customised_currency_conversion($currencyPerUnitSeller, $myrow['total']);
		$tot = currency_conversion($myrow['currency_code'], $admin_currency_code, $myrow['total'],$currencyCronId);
	} else
		$tot = $myrow['total'];
	////////////////////

	/*if($admin_currency_code!=$myrow['currency_code'] && $myrow['currency_code'] !='0' && $myrow['currency_code'] !=''){
	 	$tot =  convertCurrency($myrow['currency_code'],$admin_currency_code,$myrow['total']);
		
	 }else
	   	$tot = $myrow['total'];	
*/

	$bookedstatus = ($myrow[status] == "Pending") ? "Failed" : $myrow[status];
	$ptype = ($myrow[payment_type] == "Credit Cart") ? "Credit Card" : $myrow[payment_type];
	$XML .= '<tr>
    	<td style="text-align:left">' . $sno .'|'.$currencyCronId. '</td>
		<td style="text-align:left">' . ucfirst($myrow[email]) . '</td>
		<td style="text-align:left">' . date('m-d-Y', strtotime($myrow[created])) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[bookingno]) . '</td>
      
		
		 <td style="text-align:left">' . $admin_currency_symbol . $tot . '</td>';

	if ($bookedstatus == "Paid") {
		$XML .= '<td style="text-align:left">' . ucfirst($myrow[payment_type]) . '</td>';
	}
	$XML .= '<td style="text-align:left">' . $bookedstatus . '</td>
    </tr>';
	$sno = $sno + 1;


}
$XML .= '</table>';
echo $XML;

?>

<!-- <td style="text-align:left">'.$myrow['total'].'</td> -->
