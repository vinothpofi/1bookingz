<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Host_list_" . date('m-d-Y') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('report_model');
?>
<?php
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">' . date('Y-m-d') . '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Host List</td>

        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
    	
        <th>Host Name</th>       
        <th>Total Orders</th>       
        <th>Paid Orders</th>
            <th>Pending Orders</th>
         <th>Cancelled Orders</th>
		
		
        

    </tr>';
$sno = 1;
foreach ($getCustomerDetails as $row) 
{
    $exp_reportList =  $this->report_model->get_exp_det($row['email']);
	$name = $row['firstname'] != '' || $row['lastname'] != '' ? $row['firstname'].' '.$row['lastname'] :  'No Name given';
	$XML .= '<tr>
    	
        <td style="text-align:left">' . ucfirst($name) . '</td>
        <td style="text-align:left">' . ($row['total_order'] +  $exp_reportList->exp_total_order) . '</td>
        <td style="text-align:left">' . ($row['booked_pro_count'] + $exp_reportList->booked_exp_count) . '</td>
        <td style="text-align:left">' . ($row['pending_pro_count'] + $exp_reportList->pending_exp_count) . '</td>
        <td style="text-align:left">' . ($row['cacelled_pro_count'] + $exp_reportList->cacelled_exp_count) . '</td> 
        
      
        
    </tr>';
	$sno = $sno + 1;

}
$XML .= '</table>';
echo $XML;